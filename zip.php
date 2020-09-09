<?php
$titel = "Zip Apachelog";
$menuitem = '';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php';

print "<h1>$titel</h1>";

$wochenzahlen = range('1', '53'); // Woche 53 existiert
$jahreszahlen = range('2000', '2020');
$woche = null;
$jahr = null;
$filename = 'log/access_log_2009_w[woche]-0.gz'; // nur für den Text
$self = htmlspecialchars($_SERVER['PHP_SELF']);
$erfolg = 2;
$wochenliste = null;

$query = mysql_query("select woche from apachelog group by woche");
if ($query)
    {
    while ($reihe = mysql_fetch_array($query, MYSQL_NUM))
        {
        foreach ($reihe as $wert)
            {
            $wochenliste .= "$wert, ";
        }
    }
}

print <<<HTML

<p>Hier wird die Datei <code>$filename</code> in Mysql eingelesen und in die Tabelle apachelog mit den Spalten <code>ip time request status size referer ua woche ts id</code> geschrieben.</p>

<p>create Tabelle in mysql:</p>

<p><code>create table apachelog (ip varchar(15), date date, time time, request text, status smallint unsigned, size smallint unsigned, referer text, ua text, woche tinyint unsigned, jahr year, ts TIMESTAMP not null, id INT NOT NULL auto_increment, PRIMARY KEY(id));</code></p>

<p>Formular, um die Woche einzutragen und das update zu starten. Das update dauert eine Weile. </p>

<p>Im Moment in der Datenbank vorhandene Wochen: $wochenliste. Wird eine Woche erneut eingelesen, werden die alten Einträge gelöscht.</p>

<p>Ich habe auch ein paar <a href="apachelogabfragen.php">Beispiele von Anfragen</a> geschrieben.</p>

<form action="$self" method="post">
<fieldset>
<legend>
Update von Tabelle apachelog (dauert ~30sec)
</legend>


<table>
    <tr>
    <td class="rechts"><label for="id_woche">Woche:</label></td>
    <td><select size="1" name="woche" id="id_woche">
HTML;

    // options-Liste bauen
    $max_woche = count($wochenzahlen);
    for ($i = 0; $i < $max_woche; $i++)
        {
        // druckt die Liste für die Auswahl
        print "\t<option value=\"$wochenzahlen[$i]\"> $wochenzahlen[$i] </option>\n";
    }

print <<<HTML
    </select></td>
    </tr>

    <tr>
    <td class="rechts"><label for="id_jahr">Jahr:</label></td>
    <td><select size="1" name="jahr" id="id_jahr">
HTML;
    // options-Liste bauen
    $max_jahr = count($jahreszahlen);
    for ($i = 0; $i < $max_jahr; $i++)
        {
        // druckt die Liste für die Auswahl
        print "\t<option value=\"$jahreszahlen[$i]\">$jahreszahlen[$i]</option>\n";
    }
print <<<HTML
    </select></td>
    </tr>


    <tr>
    <td></td>
    <td><input type="submit" value=" Apachelog updaten "></td>
    </tr>
</table>

<input type="hidden" name="abgeschickt" value="1">
HTML;

// Formular verarbeiten
if (isset($_POST['abgeschickt']) && $_POST['abgeschickt'] == 1)
    {
    $woche = $_POST['woche'];
    $jahr = $_POST['jahr'];
    mysql_query("delete from apachelog where woche = '$woche' AND jahr = '$jahr'");
    $erfolg = update($woche,$jahr);
}
// Seite zeigen
zeigedenrest();

if ($erfolg == 1)
    {
    print "<p>Die Logdaten von $woche/$jahr sind zur Datenbank hinzugefügt worden.</p>\n";
} elseif ($erfolg == 0)
    {
    print "<p>Die Datei konnte nicht geöffnet werden</p>\n";
}

function zeigedenrest ()
    {
    print <<<HTML
</fieldset>
</form>
HTML;
}


function update($woche,$jahr)
    {
    $mode = 'r';
    $filename = 'log/access_log_' . $jahr . '_w' . $woche . '-0.gz';
    if (file_exists ($filename) && is_readable($filename))
        {
        $gzip = gzopen ($filename, $mode);
    } else	{
        return 0;
    }
    // eof -> end of file
    while (!gzeof($gzip) && ($gzip))
        {
        $zeilenlaenge = 1024;
        $buffer = gzgets($gzip, $zeilenlaenge);
        $formatiert = formatieren($buffer);
        $mysql_eingabe = "$formatiert, '{$woche}', '{$jahr}'";
        mysql_query("insert into apachelog (ip, date, time, request, status, size, referer, ua, woche, jahr) values ($mysql_eingabe)");
    }
    return 1;
}


function formatieren($string)
    {
    // wenn man nicht Zugriff hat auf das log-Format vom Apache, muss der string noch für mysql formatiert werden
    // ip ([0-9]*\.[0-9]*\.[0-9]*\.[0-9]*)
    // time ([^\]]+)
        // time wird unterteilt und dann umsortiert nach
        // DATE '0000-00-00' und TIME '00:00:00'
        // Beispielstring:  [18/Sep/2008:12:51:24 +0200]
        // ([0-9]{2})/([a-zA-Z]{3})/([0-9]{4}):([0-9:]+)
        // und ersetzt durch ($1 ist ip) '$4-$3-$2', '$5'
    // request ("[^"]+]") //
    // status ([0-9-]+)
    // size ([0-9-]+)
    // referer ("[^"]+")
    // ua ("[^"]+")
    $muster = '@([0-9]*\.[0-9]*\.[0-9]*\.[0-9]*)[^[]*\[([0-9]{2})/([a-zA-Z]{3})/([0-9]{4}):([0-9:]+)[^"]+"([^"]+)" ([0-9-]+) ([0-9-]+) "([^"]+)" "([^"]+)"@';
    // $muster = '@([0-9]*\.[0-9]*\.[0-9]*\.[0-9]*)[^[]*\[@';
    $ersatz = "'$1', '$4-$3-$2', '$5', '$6', '$7', '$8', '$9', '$10'";
    $vorformatiert = preg_replace ($muster, $ersatz, $string);
    // Jetzt müssen die Monate ersetzt werden durch entsprechende Zahlen.
    $muster2 = array(
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec'
        );
    $ersatz2 = array(
        '01',
        '02',
        '03',
        '04',
        '05',
        '06',
        '07',
        '08',
        '09',
        '10',
        '11',
        '12'
        );
    $formatiert = str_replace ($muster2, $ersatz2, $vorformatiert);
    return $formatiert;
}


require 'includes/uebungfooter.php';
<?php
$titel = "Update der Seitenlisten-Datenbank";
$menuitem = '';


require '../../../files/php/login_web330.php';
require '../includes/definitions.php';
require '../includes/functions.php';
connect ();
session_start();
require '../includes/uebunghead.php';
require '../includes/uebungkopf.php';
require '../includes/uebungnavi.php';

print "<h1>$titel</h1>";



// Beginn Inhalt

// Ordner hier listen, die durchsucht werden sollen
$ordner = array (
    'navigation',
    'sessions+cookies',
    'update'
);
# // gibt keine Unterordner hier, also:
# $ordner = null;
# // es gibt keine Ordner, dann:
# $ordner = null;
# // es gibt Unterordner, dann:
# $ordner = array (
# 	'ordner/unterordner';
# 	'ordner/unterordner2';
# };

// MySQL-Tabellenname
$tabellenname = 'seitenliste';

# Ende der nötigen Angaben

$self = htmlspecialchars($_SERVER['PHP_SELF']);
$erfolg = null;

print <<<HTML
<p>Anweisung zur Erstellung der Tabelle in mysql:</p>

<pre>
create table seitenliste (
    cwd char(255),
    basename char(255),
    id int not null auto_increment,
    primary key(id)
);
</pre>

<h3>Test, ob absolute Pfade hier funktionieren:</h3>

<ul>
<li><a href="/.">Startseite</a></li>
<li><a href="/sessions+cookies/login.php">Cookies</a></li>
</ul>

HTML;


print "<h2>Vorher in der Tabelle $tabellenname vorhandene Einträge</h2>";

status($tabellenname);

print <<<HTML

<h2>Dateiliste updaten</h2>

<p>- alte Einträge werden gelöscht</p>

<form action="$self" method="post">
<fieldset>
<legend>
Update von Tabelle $tabellenname
</legend>

<table>

<tr><td><input type="radio" name="ja" value="ja">Ja</td></tr>
<tr><td><input type="submit" value=" $tabellenname updaten "></td></tr>

</table>

<input type="hidden" name="abgeschickt" value="1">
HTML;

// Formular verarbeiten
if (isset($_POST['abgeschickt']) && $_POST['abgeschickt'] == 1)
    {
    $dir_read = '../';
    $dir_write = '/';
    $info = array();
    $rooteintragen = "insert into $tabellenname (cwd, basename) values ('/', '', 1)";
    $info = dateiliste($dir_read);
    sort($info);
    // den alten Inhalt löschen
    mysql_query ("delete from $tabellenname");
    // einmal die index.php von /root eintragen
    mysql_query ($rooteintragen);
    insertliste($dir_write, $info, $tabellenname);
    // runter in die jeweiligen Ordner und dort die Dateien eintragen
    $max = count($ordner);
    for ($i = 0; $i < $max; $i++)
        {
        $dir_read = '../' . $ordner[$i];
        $dir_write = '/' . $ordner[$i];
        $info = dateiliste($dir_read);
        sort($info);
        insertliste($dir_write, $info, $tabellenname);
    }
    $erfolg = 1;
}
// Seite zeigen
zeigedenrest();


if ($erfolg == 1)
    {
    print "<p>Die Tabelle $tabellenname wurde gelöscht und neu erstellt.</p>\n\n";
    $zeit = strftime('%d. %B %Y, %H:%M:%S');
    print "<h2>Jetzt ($zeit) in der Tabelle $tabellenname vorhandenen Einträge</h2>\n\n";
    status($tabellenname);
}

function zeigedenrest ()
    {
    print <<<HTML
</fieldset>
</form>
HTML;
}

function status ($tabellenname)
    {
    print '<table class="$tabellenname">';
    $query = mysql_query("select cwd, basename from $tabellenname order by cwd, basename");
    while ($liste = mysql_fetch_array($query, MYSQL_NUM))
        {
        print "<tr>\n";
        foreach ($liste as $wert)
            {
            print "\t<td>$wert</td>\n";
        }
        print "</tr>\n";
    }
print '</table>';
}

function dateiliste($dir_read)
    {
    $dirhandle = opendir($dir_read);
    while ($file = readdir($dirhandle))
        {
        // sucht nach .php, nicht nach index.* und google[a-z0-9]+ (Google Authorization file; index.php sollte direkt geschrieben werden und in Unterordnern nicht gefunden werden)
        if (preg_match ('/.+\.php/', $file)
        && 'index.php' != $file
        && !preg_match ('/google[0-9a-z]+\.php/',$file))
            {
            $info[] = $file;
            // $info[] = basename($file);
        }
    }
    return $info;
}

function insertliste ($dir_write,$info,$tabellenname)
    {
    $max = count($info);
    for ($i = 0; $i < $max; $i++)
        {
        $mysql_anweisung = "insert into $tabellenname (cwd, basename) values ('$dir_write', '$info[$i]')";
        mysql_query($mysql_anweisung);
        // print "$dir_write\t$info[$i]\n\n";
        // print "$mysql_anweisung\n<hr>\n";
    }
}
#################################################

require '../includes/uebungfooter.php';
?>

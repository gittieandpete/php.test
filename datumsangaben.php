<?php
$titel = "Datumsangaben";
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
?>


<?php
/*
// Dieses Jahr
$j = date('Y');
*/
// heute
$j = time();
?>

<p>d) Heute (strftime) ist der <?php print strftime("<span>%A, der %d.%m.%y</span>"); ?>. Zeigen Sie die Namen der Personen in Ihrer Familie sowie deren Verwandtschaftsverhältnis zu Ihnen.</p>

<?php

// mktime(Stunde, Minute, Sekunde, Monat, Tag, Jahr)
$meingeburtstag = mktime(12,00,00,6,3,1956);
$wolfgangsgeburtstag = mktime(12,00,00,3,28,1958);
$uwesgeburtstag = mktime(12,00,00,06,14,1962);
$mamasgeburtstag = mktime(00,00,00,8,15,1929);
$hansgeburtstag = mktime(12,00,00,3,26,1992);
$helenesgeburtstag = mktime(12,00,00,10,1,1994);
$christinesgeburtstag = mktime(12,00,00,4,20,1976);
$jakobsgeburtstag = mktime(04,00,00,3,14,2009);
$simonsgeburtstag = mktime(01,37,00,12,12,2013);

print "<p>Mein Geburtstag (mktime): $meingeburtstag</p>";
print strftime('<p>Mein Geburtstag ist %A, der %d. %B %Y</p>', $meingeburtstag);
print strftime('<p>Wolfgangs Geburtstag ist %A, der %d. %B %Y.</p>', $wolfgangsgeburtstag);
print strftime('<p>Uwes Geburtstag ist %A, der %d. %B %Y.</p>', $uwesgeburtstag);
print strftime('<p>Mamas Geburtstag ist %A, der %d. %B %Y.</p>', $mamasgeburtstag);
print strftime('<p>Hans\' Geburtstag ist %A, der %d. %B %Y.</p>', $hansgeburtstag);
print strftime('<p>Helenes Geburtstag ist %A, der %d. %B %Y.</p>', $helenesgeburtstag);
print strftime('<p>Christines Geburtstag ist %A, der %d. %B %Y.</p>', $christinesgeburtstag);
print strftime('<p>Jakobs Geburtstag ist %A, der %d. %B %Y.</p>', $jakobsgeburtstag);
print strftime('<p>Simons Geburtstag ist %A, der %d. %B %Y.</p>', $simonsgeburtstag);

print '<p>Heute (date) ist ' . date('l') . ', der ' . date('d.m.y') . ', ' . date('H:i') . ' Uhr und ' . date('s') . ' Sekunden.</p>';
print strftime('<p>Heute (strftime) ist %c.</p>');
print strftime('<p>Heute (strftime) ist %A, der %x, %H:%M Uhr und %S Sekunden.</p>');


$heute = time(); //dasselbe wie time();
// Zeitpunkt mit mktime festlegen
$mittag = mktime(12,00,00);
$vergangen = ($heute - $mittag);
printf ('<p>Seit Mittag sind %d Sekunden vergangen.', $vergangen);

print strftime('<p>Seit Mittag sind %H:%M Stunden vergangen.', $vergangen);

$meinalter = ($heute - $meingeburtstag)/(3600*24*365);
printf ('<p>Mein Alter beträgt %d Jahre.</p>', $meinalter);


function alter ($heute,$geburtstag)
    {
    $alter = floor(($heute - $geburtstag)/(3600*24*365));
    return $alter;
}

$familie = array (
    'Uwe' => array (
        'Beziehung' => 'Bruder',
        'Alter' => alter($heute,$uwesgeburtstag)),
    'Wolfgang' => array (
        'Beziehung' => 'Bruder',
        'Alter' => alter($heute,$wolfgangsgeburtstag)),
    'Mama' => array (
        'Beziehung' => 'Mutter',
        'Alter' => alter($heute,$mamasgeburtstag)),
    'Hans' => array (
        'Beziehung' => 'Sohn',
        'Alter' => alter($heute,$hansgeburtstag)),
    'Helene' => array (
        'Beziehung' => 'Tochter',
        'Alter' => alter($heute,$helenesgeburtstag)),
    'Christine' => array (
        'Beziehung' => '<strong style="color:red;font-size:200%">&hearts;</strong>',
        'Alter' => alter($heute,$christinesgeburtstag)),
    'Jakob' => array (
        'Beziehung' => 'Sohn',
        'Alter' => alter($heute,$jakobsgeburtstag)),
    'Simon' => array (
        'Beziehung' => 'Sohn',
        'Alter' => alter($heute,$simonsgeburtstag))
    );

print "<table class=\"rahmen\">\n";
$jahre = 0;
foreach ($familie as $name => $mehr)
    {
    print "<tr><th colspan=\"2\">$name</th></tr>";
    foreach ($mehr as $verwandt => $wiealt)
        {
        print "<tr><td>$verwandt</td><td style=\"text-align:center\">$wiealt</td></tr>";
        $alter = $mehr['Alter'];
    }
$jahre = $alter + $jahre;
}
print "</table>\n";
$meinalter = alter($heute,$meingeburtstag);
$zusammen = $meinalter + $jahre;
printf ('<p>Ich bin %d, also sind wir zusammen schon %d Jahre alt!</p>', $meinalter, $zusammen);

?>

<hr>

<h2>Weitere Datumsangaben</h2>


<?php
$lf = "\n<br>";
print '<p>aktuelles Datum: ' . date('d.n.Y H:i:s') . $lf;
print 'letzter Monat: ' . strtotime('last Month') . $lf;
print 'letzter Monat: ' . date('n', strtotime('last month')) . $lf;
print 'letzter Monat: ' . date('d.n.Y', strtotime('last month')) . $lf;
print 'nächster Monat: ' . date('d.n.Y', strtotime('next month')) . $lf;
print 'vor 5 Monaten: ' . date('d.n.Y', strtotime('-5 month')) . $lf;
print 'in 3 Monaten: ' . date('d.n.Y', strtotime('+3 month')) . $lf;
?>
</p>

<hr>

<h2>Übungen</h2>

<ol>
<li>Verwenden Sie strftime(), um einen formatierten Zeit- und Datums-String auszugeben, der so aussieht:

<p>
Heute ist der 20. Tag des Oktober und der 294. des Jahres 2004.<br>
Es ist 19:45 Uhr (auch bekannt als 07:45 PM).
</p>

<?php
// %p und %P wollen nicht.
$tag = mktime(19,45,00,10,20,2004);
print strftime('<p>Heute ist der %d. Tag des %B und der %j. des Jahres %Y.<br>Es ist %H:%M Uhr (auch bekannt als %I:%M PM).</p>', $tag);
?>


</li>
<li>Verwenden Sie date(), um den gleichen formatierten Zeit- und Datums-String auszugeben. <small>(Was für ne Arie...)</small> <br>
Und warum verzählt sich date mit den Tagen des Jahres?

<?php
print '<p>Heute ist der ' . date('d', $tag) . '. Tag des ' . date('F', $tag) . ' und der ' . date('z', $tag) . '. des Jahres ' . date('Y', $tag) . '<br>Es ist ' . date('H', $tag) . ':' . date('i', $tag) . ' Uhr (auch bekannt als ' . date('h', $tag) . ':' . date('i', $tag) . ' PM).</p>';
?>

</li>
<li>In den USA ist der Tag der Arbeit der erste Montag im September. Geben Sie eine Tabelle mit allen Datumswerten aus, auf die der Tag der Arbeit in den Jahren 2004 bis 2020 fällt.

<?php
// 1. Sep. 2004
$sep1 = mktime(12,00,00,9,1,2004);
// tda, Tag der Arbeit: Montag danach
$tda = strtotime('Monday', $sep1);
print strftime('<p>Tag der Arbeit in den USA ist %A, %x.</p>', $tda);
?>
<table class="daten">
<tr><th>Jahr</th><th>Tag der Arbeit</th></tr>
<?php
for ($i = 0;$i <= 16;$i++)
    {
    print strftime('<tr><td>%Y</td><td>%A, %x</td></tr>', $tda);
    $sep1 = strtotime('next year', $sep1);
    $tda = strtotime('Monday', $sep1);
}
?>
</table>

</li>
<li>Schreiben Sie ein PHP-Programm, das ein Formular anzeigt, in dem ein Benutzer einen zukünftigen Tag, Monat und Jahr auswählen kann. Geben Sie eine Liste aller Dienstage zwischen dem aktuellen Datum und dem Datum aus, das der Benutzer im Formular angegeben hat.


<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']);?>" method="get">

<fieldset>
<legend>
Wähle ein Datum
</legend>

<label for="id_tag">Tag</label>
<select size="1" name="tag" id="id_tag">
<?php
for ($i = 1;$i <= 31;$i++)
    {
    print "\t<option value=\"$i\">$i</option>\n";
}
?>
</select>

<label for="id_monat">Monat</label>
<select size="1" name="monat" id="id_monat">
<?php
$monate = array
    (
    Januar => 1,
    Februar => 2,
    März => 3,
    April => 4,
    Mai => 5,
    Juni => 6,
    Juli => 7,
    August => 8,
    September => 9,
    Oktober => 10,
    November => 11,
    Dezember => 12
);
foreach ($monate as $monat => $nummer)
    {
    print "\t<option value=\"$nummer\">$monat</option>\n";
}
?>
</select>

<label for="id_jahr">Jahr</label>
<select size="1" name="jahr" id="id_jahr">
<?php
for ($i = 2008;$i <= 2020;$i++)
    {
    print "\t<option value=\"$i\">$i</option>\n";
}
?>
</select>
<input type="hidden" name="abgeschickt" value="1">
<input type="submit" value=" OK ">

</form>

<?php
if (isset($_GET['abgeschickt']) && $_GET['abgeschickt'] == 1)
    {
    print "<p>Tag: $_GET[tag], Monat: $_GET[monat], Jahr: $_GET[jahr].</p>";
    $zeitstempel = mktime(12,00,00,$_GET['monat'],$_GET['tag'],$_GET['jahr']);
    print strftime('%c', $zeitstempel);
    $jetzt = time();
    print strftime('<p>Alle %Ae ', strtotime('Tuesday', $zeitstempel));
    print strftime('bis zum %x:<br>', $zeitstempel);
    for ($jetzt = strtotime('Tuesday', $jetzt);$jetzt < $zeitstempel;$jetzt = strtotime('next week', $jetzt))
        {
        print strftime('<span>%A, %x; </span>', $jetzt);
    }
    print '</p>';
}
?>

</li>
</ol>

<?php
require 'includes/uebungfooter.php';
?>

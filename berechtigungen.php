<?php
$titel = "Berechtigungen";
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

print "<p>Es sollen für ein admin-Feld in einer Datenbank auf einfache Weise Berechtigungen für ein Programm gesetzt werden können, z.B.</p>";

$berechtigungen = array(
    '1' => 'buchen und Rechnungen sehen',
    '2' => 'User eintragen',
    '4' => 'alle Rechnungen sehen',
    '8' => 'alle Buchungen sehen',
    '16' => 'User löschen'
    );

print '<dl>';
foreach($berechtigungen as $num => $text)
    {
    print "<dt>$num</dt><dd>$text</dd>\n";
}
print '</dl>';

print "<p>Addition der Berechtigungen soll möglich sein, z.B. 31 darf alles, 5 darf eigene Buchungen anlegen und alle Rechnungen sehen usw.</p>\n";

$potenzzahl = count($berechtigungen);
$limit = pow(2,$potenzzahl)-1;
// print $limit;

print "<table>\n\n\t<caption>Berechtigungen</caption>\n";
print "\t<tr>\n\t<th>Wert</th>\n\t<th>Berechtigung</th>\n\t</tr>\n\n";
for ($i=1;$i<=$limit;$i++)
    {
    print "\t<tr>\n\t<td>$i</td>\n";
    print "\t<td>";
    if ($i%2>=1) print $berechtigungen['1'] . ', ';
    if ($i%4>=2) print $berechtigungen['2'] . ', ';
    if ($i%8>=4) print $berechtigungen['4'] . ', ';
    if ($i%16>=8) print $berechtigungen['8'] . ', ';
    if ($i%32>=16) print $berechtigungen['16'] . ', ';
    print "</td>\n\t</tr>\n\n";
}
print "</table>\n\n";

print "<h3>Struktur</h3>\n\n";

$struktur = array(
    '1' => '1',
    '2' => '2',
    '4' => '4',
    '8' => '8',
    '16' => '16'
    );

$potenzzahl = count($struktur);
$limit = pow(2,$potenzzahl)-1;

print "<table>\n\t<caption>Struktur</caption>\n";
print "\t<tr>\n\t<th>Wert</th>\n\t<th>Zusammensetzung</th>\n\t</tr>\n\n";
for ($i=1;$i<=$limit;$i++)
    {
    print "\t<tr>\n\t<td>$i</td>\n";
    print "\t<td>";
    if ($i%2>=1) print '+' . $struktur['1'];
    if ($i%4>=2) print '+' . $struktur['2'];
    if ($i%8>=4) print '+' . $struktur['4'];
    if ($i%16>=8) print '+' . $struktur['8'];
    if ($i%32>=16) print '+' . $struktur['16'];
    print "</td>\n\t</tr>\n\n";
}
print "</table>\n\n";

print "<div style='clear:both;'></div>";

require 'includes/uebungfooter.php';
?>

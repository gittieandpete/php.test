<?php
$titel = 'Arrays, Fortsetzung';
$menuitem = 'arrays';


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


<h2>Implode</h2>

<p>...ist noch einfacher. Implode haut das Array in einem String raus. Nehmen wir nochmal die alte Tabelle von Übung 5.</p>


<?php

$name = array
    (
    'Zelter',
    'Adorf',
    'Beethoven',
    'Förster');
$vorname = array
    (
    'Oskar',
    'Heinz',
    'Otto',
    'Karl');
$plz = array
    (
    '30161',
    '30159',
    '""',
    '30160');
$ort = array
    (
    'Hannover',
    'Bielefeld',
    '""',
    '""');
$strasse = array
    (
    'Schubertstr',
    'Wagnerstr',
    'Moltkeplatz',
    'Bonifaziusplatz');
$telefon = array
    (
    '"0160-1234"',
    '""',
    '""',
    '"0511-112"');
$tabelle = array
    (
    $name,
    $vorname,
    $plz,
    $ort,
    $strasse,
    $telefon);

print '<pre>';
print implode(', ', $name);
print "\n";
print 'Ohne Trennzeichen:';
print implode('', $vorname);
print '</pre>';

print '<p>Auf die ganze Tabelle angewandt sieht die foreach-Abfrage dann so aus:</p>';

print "<table class=\"rahmen\">\n";
foreach ($tabelle as $reihe)
    {
    print '<tr><td>' . implode('</td><td>', $reihe) . '</td></tr>';
}
print "</table>\n";

print "<p>Das ist doch schön einfach!</p>";

print "<p>explode liest ein Array ein. Die Trennstelle, wo die Array-Elemente beginnen sollen, kann man bestimmen. z.B.</p>";

$text = 'Es war eine dunkle, stürmische Nacht in den ersten Tagen des Novembers, im Jahre 1599, als
die spanische Schildwache auf dem Fort Liefkenhoek an dem flandrischen Ufer der Schelde das Lärmzeichen gab, die Trommel die schlafende Besatzung wach rief und ein jeder - Befehlshaber wie Soldat - seinen Posten auf den Wällen einnahm.';

$wortliste = explode(' ', $text);
print $text;
print "<p>print_r gibt Variablen formatiert aus, ist eine Alternative zu var_dump</p>";
print_r($wortliste);
print "<p>Beachte Element 15, 'als die'.</p>";
print "<p>Mit implode wieder zusammengefügt:</p>";
$wortliste2 = implode(' ', $wortliste);
print_r($wortliste2);
print "<p>Eine andere Möglichkeit, Trennzeichen ist das Komma:</p>";
$wortliste = explode(', ', $text);
print_r($wortliste);
print "<p>Eine andere Möglichkeit, str_split:</p>";
$wortliste = str_split($text, 5);
print_r($wortliste);
print "<p>Eine andere Möglichkeit, preg_split, findet hier Punkt, Komma, Leerzeichen, Bindestrich und Zeilenumbruch:</p>";
$wortliste = preg_split("/[,\.\s-\n]/", $text);
print_r($wortliste);
print "<p>Das ganze sortiert:</p>";
sort($wortliste);
print_r($wortliste);
?>

<h2>Übung S. 73, Array definieren</h2>

<?php
$berlin = array
    (
    'Berlin',
    'Berlin',
    '3392425');
$hamburg = array
    (
    'Hamburg',
    'Hamburg',
    '1728806');
$muenchen = array
    (
    'München',
    'Bayern',
    '1234692');
$koeln = array
    (
    'Köln',
    'NRW',
    '968639');
$frankfurt = array
    (
    'Frankfurt a.M.',
    'Hessen',
    '643726');
$dortmund = array
    (
    'Dortmund',
    'NRW',
    '590831');
$stuttgart = array
    (
    'Stuttgart',
    'Baden-Württemberg',
    '588477');
$essen = array
    (
    'Essen',
    'NRW',
    '585481');
$duesseldorf = array
    (
    'Düsseldorf',
    'NRW',
    '571886');
$bremen = array
    (
    'Bremen',
    'Bremen',
    '542987');
$gesamt = array
    (
    'insgesamt:',
    '',
    '');

$gesamt[2] = $berlin[2]+$hamburg[2]+$muenchen[2]+$koeln[2]+$frankfurt[2]+$dortmund[2]+$stuttgart[2]+$essen[2]+$duesseldorf[2]+$bremen[2];

print "<p>Testen, ob's richtig ist:</p>";

print "<p>$gesamt[2]</p>";
print "<ul><li>" . implode('</li><li>', $bremen) . '</li></ul>';

print "<p>Tabelle ausgeben</p>";

$tabelle2 = array
    (
    $berlin,
    $hamburg,
    $muenchen,
    $koeln,
    $frankfurt,
    $dortmund,
    $stuttgart,
    $essen,
    $duesseldorf,
    $bremen,
    $gesamt);

print '<table class=\"rahmen\">';
foreach ($tabelle2 as $zeile)
    {
    print '<tr><td>' . implode('</td><td>', $zeile) . '</td></tr>';
}
print '</table>';

print "<p>Tabelle sortieren und ausgeben - nach Bevölkerungszahl sortieren kann ich hier nicht. </p>";

asort($tabelle2);
print '<table class=\"rahmen\">';
foreach ($tabelle2 as $zeile)
    {
    print '<tr><td>' . implode('</td><td>', $zeile) . '</td></tr>';
}
print '</table>';
?>


<p>3. Ändern Sie Ihre Lösung so ab, dass die Tabelle auch Zeilen enthält, in der für die jeweiligen Bundesländer Gesamtsummen für die Bevölkerung der in ihnen liegenden Städte stehen. - Tja, wenn das jetzt mysql wäre, wäre das einfacher.</p>

<p>Land und Leute, Stadt-Info</p>

<?php
$berlin2 = array
    (
    'land'	=> 'Berlin',
    'leute'	=> '3392425');
$hamburg2 = array
    (
    'land'	=> 'Hamburg',
    'leute'	=> '1728806');
$muenchen2 = array
    (
    'land'	=> 'Bayern',
    'leute'	=> '1234692');
$koeln2 = array
    (
    'land'	=> 'NRW',
    'leute'	=> '968639');
$frankfurt2 = array
    (
    'land'	=> 'Hessen',
    'leute'	=> '643726');
$dortmund2 = array
    (
    'land'	=> 'NRW',
    'leute'	=> '590831');
$stuttgart2 = array
    (
    'land'	=> 'Baden-Württemberg',
    'leute'	=> '588477');
$essen2 = array
    (
    'land'	=> 'NRW',
    'leute'	=> '585481');
$duesseldorf2 = array
    (
    'land'	=> 'NRW',
    'leute'	=> '571886');
$bremen2 = array
    (
    'land'	=> 'Bremen',
    'leute'	=> '542987');

$bevoelkerung = array
    (
    $berlin2,
    $hamburg2,
    $muenchen2,
    $koeln2,
    $frankfurt2,
    $dortmund2,
    $stuttgart2,
    $essen2,
    $duesseldorf2,
    $bremen2);
$land_gesamt = array ();
$gesamtbevoelkerung = 0;

print '<p> $erste ? $zweite : $dritte <br>
Wenn der $erste Ausdruck TRUE ist (nicht null), wird der zweite Ausdruck ausgewertet, das ist das Ergebnis; Wenn nicht (erster Ausdruck false), wird der dritte Ausdruck ausgewertet. In einfach (das anfängliche $zahl = habe ich weiter unten bei $land_gesamt usw... weggelassen): </p>';
isset($zahl) ? print $zahl : print '<p>$zahl nicht gesetzt</p>';
$zahl = isset($zahl) ? $zahl = $zahl + 3 : $zahl = 0;
isset($zahl) ? print "<p>Zahl = $zahl</p>" : print '<p>$zahl nicht gesetzt</p>';

print '<table class=\"rahmen\">';
foreach ($bevoelkerung as $stadt2	=> $infos)
    {
    $gesamtbevoelkerung = $gesamtbevoelkerung + $infos['leute'];
    isset($land_gesamt[$infos['land']]) ? $land_gesamt[$infos['land']] += $infos['leute'] : $land_gesamt[$infos['land']] = $infos['leute'];
    /*
    // dasselbe, in lang:
    if (isset($land_gesamt[$infos['land']]))
        {
        $land_gesamt[$infos['land']] = $land_gesamt[$infos['land']] + $infos['leute'];
    }
    else
        {
        $land_gesamt[$infos['land']] = $infos['leute'];
    }
    */
    print '<tr><td>' . implode('</td><td>', $infos) . '</td></tr>';
}
print '</table>';

print "<p>Gesamtbevölkerung ist: $gesamtbevoelkerung</p>";

print '<h2>Bevölkerung pro Bundesland</h2>';

print '<table class=\"rahmen\">';
foreach ($land_gesamt as $land	=> $leute)
    {
    print "<tr><td>$land</td><td>$leute</td></tr>";
}
print '</table>';

?>

<hr>


<h2>Übung S. 74</h2>

<p>b) Wieviel eines Artikels im Lagerbestand eines Ladens vorhanden ist.</p>

<p>Ware -> Anzahl, klaro</p>

<?php
$artikel = array(
    'Stuhl'	=> '4',
    'Tisch'	=> '2',
    'Schrank'	=> '4',
    'Tassen'	=> '15',
    'Untertassen'	=> '15');
$alleartikel = 0;
print "<table class=\"rahmen\">\n";
foreach ($artikel as $moebel => $zahl)
    {
    print "<tr><td>$moebel</td><td>$zahl</td></tr>";
    $alleartikel = $alleartikel + $zahl;
}
print "<tr><td>Summe: </td><td>$alleartikel</td></tr>";
print "</table>\n";


?>

<p>c) Schulmittagessen für eine Woche, Gänge + Preis<br>
Für die Darstellung mit deutschen locales benutze ich setlocale in functions.php mit setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge'); LC_TIME ging nicht.
</p>



<?php

$montag = array (
    'Suppe'	=>	'3.50',
    'Kartoffeln'	=>	'1.50',
    'Huhn'	=>	'2.10',
    'Pudding'	=>	'.50');
$dienstag = array (
    'Frühlingsrolle'	=>	'1.10',
    'Nudeln'	=>	'.90',
    'Frikadelle'	=>	'1.40',
    'Eis'	=>	'.70');
$mittwoch = array (
    'Kroepek'	=>	'1.70',
    'Reis'	=>	'1.10',
    'Shrimps'	=>	'3.00',
    'Litschis'	=>	'2.10');
$donnerstag = array (
    'Tomatensalat'	=>	'1.00',
    'Spaghetti'	=>	'1.00',
    'Bolgnese'	=>	'1.00',
    'Tiramisu'	=>	'.80');
$freitag = array (
    'Gurkensalat'	=>	'.90',
    'Bratkartoffeln'	=>	'1.20',
    'Scholle'	=>	'2.20',
    'Banane'	=>	'.70');
$samstag = array (
    'Brühe'	=>	'.60',
    'Brot'	=>	'.70',
    'Truthahn'	=>	'3.70',
    'Melone'	=>	'1.00');
$woche = array (
    $montag,
    $dienstag,
    $mittwoch,
    $donnerstag,
    $freitag,
    $samstag);

$tage = array ('Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');
print "<table class=\"rahmen\">\n";
foreach ($woche as $i => $tag)
    {
    $name = $tage[$i];
    print "<tr><th colspan=\"2\">$name</th></tr>";
    $menuetotal = 0;
    foreach ($tag as $essen	=> $preis)
        {
        printf ("<tr><td>$essen</td><td>%.2f &euro;</td></tr>", $preis);
        $menuetotal = $menuetotal + $preis;
    }
    printf ("<tr><td>Menü: </td><td><u>%.2f &euro;</u></td></tr>", $menuetotal);
}
print "</table>\n";
?>


<pre>
Das geht einfacher, wenn man gleich mit
$woche = array (
    'Montag'	=&gt; array (
    'Suppe'	=&gt; '3.50',
    'Kartoffeln'	=&gt; '1.50',
    'Huhn'	=&gt; '2.10',
    'Pudding'	=&gt; '.50'),
    'Dienstag'	=&gt; array (
    usw. mal probieren...siehe unten bei $familie bzw. Übung 7, Datumsangaben

</pre>



<?php
require 'includes/uebungfooter.php';
?>

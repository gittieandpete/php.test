<?php
$plz = 98052;

$wetter_seite = file_get_contents('http://www.srh.noaa.gov/zipcity.php?inputstring=' . $plz);

// Nur all das auswählen, was nach dem "Detailed Forecast" image alt-Text kommt
$seite = strstr($wetter_seite,'Detailed Forecast');
// Ermitteln, wo die Tabelle mit der Vorhersage beginnt
$tabellenanfang = strpos($seite, '<table');
// Ermitteln, wo die Tabelle endet, und diese Position um 8 Stellen nach
// vorn verschieben, damit das </table>-Tag vollständig mit erfasst wird
$tabellenende  = strpos($seite, '</table>') + 8;
// Den Ausschnitt von $seite ausgeben, der die Tabelle enthält
$vorhersage = substr($seite, $tabellenanfang, $tabellenende - $tabellenanfang);
// Die Vorhersage ausgeben;
print $vorhersage;
// Die Vorhersage in einer Datei speichern
file_put_contents("wetter-$plz.txt", $vorhersage);
?>
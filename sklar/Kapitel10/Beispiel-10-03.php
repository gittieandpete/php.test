<?php
$plz = 98052;

$wetter_seite = file_get_contents('http://www.srh.noaa.gov/zipcity.php?inputstring=' . $plz);

// Nur all das ausw�hlen, was nach dem "Detailed Forecast" image alt-Text kommt
$seite = strstr($wetter_seite,'Detailed Forecast');
// Ermitteln, wo die Tabelle mit der Vorhersage beginnt 
$tabellenanfang = strpos($seite, '<table');
// Ermitteln, wo die Tabelle endet und diese Position um 8 Stellen nach
// vorn verschieben, damit das </table>-Tag vollst�ndig miterfasst wird
$tabellenende  = strpos($seite, '</table>') + 8;
// Den Ausschnitt von $seite ausgeben, der die Tabelle enth�lt
print substr($seite, $tabellenanfang, $tabellenende - $tabellenanfang);
?>
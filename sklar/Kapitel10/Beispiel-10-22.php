<?php
$plz = 10040;
$wetterseite = file_get_contents('http://www.srh.noaa.gov/zipcity.php?inputstring=' . $plz);

if ($wetterseite === false) {
    print "Konnte das Wetter für $plz nicht laden";
} else {
    // Nur all das auswählen, was nach dem "Detailed Forecast" image alt-Text kommt
    $seite = strstr($wetter_seite,'Detailed Forecast');
    // Ermitteln, wo die Tabelle mit der Vorhersage beginnt
    $tabellenanfang = strpos($seite, '<table');
    // Ermitteln, wo die Tabelle endet, und diese Position um 8 Stellen nach
    // vorn verschieben, damit das </table>-Tag vollständig mit erfasst wird
    $tabellenende  = strpos($seite, '</table>') + 8;
    // Den Ausschnitt von $seite ermitteln, der die Tabelle enthält
    $vorhersage = substr($seite, $tabellenanfang, $tabellenende - $tabellenanfang);
    // Die Vorhersage ausgeben
    print $vorhersage;
    $gespeicherte_datei = file_put_contents("wetter-$plz.txt", $vorhersage[1]);###$vorhersage ist im Original $treffer[1] FIO###
    // Prüfen, ob file_put_contents(  ) false oder -1 zurückliefert
    if (($gespeicherte_datei === false) || ($gespeicherte_datei == -1)) {
        print "Konnte das Wetter nicht in wetter-$plz.txt speichern";
    }
}
?>
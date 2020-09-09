<?php
$seite = file_get_contents('artikel.php');
if ($seite === false) {
    die("Kann artikel.php nicht lesen: $php_errormsg");
}
$vars = array('{titel}' => 'Mann beißt Hund',
              '{ueberschrift}' => 'Mann und biss Hund',
              '{autorenzeile}' => 'Ireneo Funes',
              '{artikel}' => "<p>Als er heute mit seinem Hund im
Park spazieren ging, nahm Bioy Casares einen großen saftigen Biss aus
seinem Hund Nikos Kleiner Freund. Als er gefragt wurde, warum er das
getan hat, antwortete er: \"Ich hatte Hunger.\"</p>",
              '{date}' => date('l, j. F Y'));
foreach ($vars as $feld => $neuer_wert) {
    $seite = str_replace($feld, $neuer_wert, $seite);
}
$ergebnis = file_put_contents('hund-artikel.php', $seite);
if (($ergebnis === false) || ($ergebnis == -1)) {
    die("Konnte hund-artikel.php nicht schreiben: $php_errormsg");
}
?>
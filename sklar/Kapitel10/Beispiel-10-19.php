<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');

// gerichte.txt zum Schreiben �ffnen
$fh = fopen('/usr/local/gerichte.txt','wb');
if (! $fh) {
    print "Fehler beim �ffnen von gerichte.txt: $php_errormsg";
} else {
    $q = $db->query("SELECT gerichtnamen, preis FROM gerichte");
    while($zeile = $q->fetchRow(  )) {
        // Schreibe jede Zeile in gerichte.txt und h�nge dabei am
        // Ende jeweils einen Zeilenumbruch an
        fwrite($fh, "Der Preis von $zeile[0] ist $zeile[1] \n");
    }
    if (! fclose($fh)) {
        print "Fehler beim Schlie�en von gerichte.txt: $php_errormsg";
    }
}
?>
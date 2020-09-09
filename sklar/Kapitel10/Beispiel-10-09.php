<?php
require 'DB.php';

$db = DB::connect('mysql://root@localhost/restaurant');
if (DB::isError($db)) {
    die("Keine Verbindung " . $db->getMessage());
} 

// gerichte.txt zum Schreiben öffnen
$fh = fopen('gerichte.txt','wb');

$q = $db->query("SELECT gerichtname, preis FROM gerichte");
while($zeile = $q->fetchRow(  )) {
    // Schreibe jede Zeile in gerichte.txt (und hänge dabei jeweils
    // einen Zeilenumbruch an sie an)
    fwrite($fh, "Der Preis für $zeile[0] ist $zeile[1] \n");
}
fclose($fh);
?>
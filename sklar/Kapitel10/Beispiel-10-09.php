<?php
require 'DB.php';

$db = DB::connect('mysql://root@localhost/restaurant');
if (DB::isError($db)) {
    die("Keine Verbindung " . $db->getMessage());
} 

// gerichte.txt zum Schreiben �ffnen
$fh = fopen('gerichte.txt','wb');

$q = $db->query("SELECT gerichtname, preis FROM gerichte");
while($zeile = $q->fetchRow(  )) {
    // Schreibe jede Zeile in gerichte.txt (und h�nge dabei jeweils
    // einen Zeilenumbruch an sie an)
    fwrite($fh, "Der Preis f�r $zeile[0] ist $zeile[1] \n");
}
fclose($fh);
?>
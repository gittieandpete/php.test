<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
$zeilen = $db->getAll('SELECT gerichtname, preis FROM gerichte');
foreach ($zeilen as $zeile) {
    print "$zeile[0], $zeile[1] \n";
}
?>
<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
$q = $db->query('SELECT gerichtname, preis FROM gerichte');
while ($zeile = $q->fetchRow(  )) {
    print "$zeile[0], $zeile[1] \n";
}
?>
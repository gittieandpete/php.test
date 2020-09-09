<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die("Verbindungsfehler: " . $db->getMessage(  )); }
// Den Preis einiger Gerichte vermindern
$db->query("UPDATE gerichte SET preis=preis - 5 WHERE preis > 20");
print 'Der Preis wurde in ' . $db->affectedRows(  ) . ' Zeilen geändert.';
?>
<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die("Verbindungsfehler: " . $db->getMessage(  )); }
$q = $db->query("INSERT INTO gerichte (gerichtname, preis, ist_scharf)
    VALUES ('Sesam-Windbeutel', 2.50, 0)");
?>
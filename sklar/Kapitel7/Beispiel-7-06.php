<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die("Keine Verbindung: " . $db->getMessage(  )); }
$q = $db->query("CREATE TABLE gerichte (
        gericht_id INT,
        gerichtname VARCHAR(255),
        preis DECIMAL(4,2),
        ist_scharf INT
)");
?>
<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die("Verbindungsfehler: " . $db->getMessage(  )); }
// Aubergine mit Chili-Soße ist scharf
$db->query("UPDATE gerichte SET ist_scharf = 1
            WHERE gerichtname = 'Aubergine mit Chili-Soße'");
// Hummer mit Chili-Soße ist scharf und teuer
$db->query("UPDATE gerichte SET ist_scharf = 1, preis=preis * 2
            WHERE gerichtname = 'Hummer mit Chili-Soße'");
?>
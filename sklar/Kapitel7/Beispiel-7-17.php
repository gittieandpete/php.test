<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die("Verbindungsfehler: " . $db->getMessage(  )); }
// Teure Gerichte entfernen
if ($dinge_billiger_machen) {
    $db->query("DELETE FROM gerichte WHERE preis > 19.95");
} else {
    // oder alle Gerichte entfernen
    $db->query("DELETE FROM gerichte");
}
?>
<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die("Keine Verbindung: " . $db->getMessage(  )); }

// Bei zukünftigen Datenbankfehlern eine Meldung ausgeben und die Ausführung beenden
$db->setErrorHandling(PEAR_ERROR_DIE);

$q = $db->query("INSERT INTO gerichte (gerichtgroesse, gerichtname, preis, ist_scharf)
    VALUES ('gross', 'Sesam-Windbeutel', 2.50, 0)");
print "Abfrage erfolgreich!";
?>

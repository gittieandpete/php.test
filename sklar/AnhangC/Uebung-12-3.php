<?php
require 'DB.php';
require 'formularhelfer.php';

// Mit der Datenbank verbinden
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die ("Keine Verbindung: " . $db->getMessage(  )); }

function db_fehlerhandler($fehler) {
    error_log('DATENBANKFEHLER: ' . $fehler->getDebugInfo(  ));
    die('Es ist ein ' . $error->getMessage(  )) . ' Fehler aufgetreten.';
}

// Die automatische Fehlerbehandlung einrichten
$db->setErrorHandling(PEAR_ERROR_CALLBACK,'db_fehlerhandler');
<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
$q = $db->query('SELECT gerichtname, preis FROM gerichte');
print 'Es gibt ' . $q->numrows(  ) . ' Zeilen in der Tabelle gerichte.';
?>
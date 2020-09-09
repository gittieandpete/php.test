<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
$billigstes_gericht = $db->getOne('SELECT gerichtname, preis
                                  FROM gerichte ORDER BY preis LIMIT 1');
print "Das billigste Gericht ist $billigstes_gericht";
?>
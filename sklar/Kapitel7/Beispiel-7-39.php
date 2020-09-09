<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
$billigstes_gericht = $db->getRow('SELECT gerichtname, preis
                                   FROM gerichte ORDER BY preis LIMIT 1');
print "$billigstes_gericht[0], $billigstes_gericht[1]";
?>
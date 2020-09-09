<?php
require 'DB.php';
// Mit der Datenbank verbinden
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
// Die CVS-Datei öffnen
$fh = fopen('gerichte.csv','rb');

for ($info = fgetcsv($fh, 1024); ! feof($fh); $info = fgetcsv($fh, 1024)) {
    // $info[0] ist der Gerichtname (das erste Feld einer Zeile von gericht.cvs)
    // $info[1] ist der Preis       (das zweite Feld)
    // $info[2] ist die Schärfe     (das dritte Feld)
    // Eine Zeile in die Datenbank-Tabelle einfügen
    $db->query("INSERT INTO gerichte (gerichtname, preis, ist_scharf) VALUES (?, ?, ?)", 
               $info);
    print "$info[0] eingefügt\n";
}
// Die Datei schließen
fclose($fh);
?>
<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');

// Den Abrufmodus in Objekte ändern
$db->setFetchMode(DB_FETCHMODE_OBJECT);

print "query(  ) und fetchRow(  ): \n";
// Alle Zeilen mit query(  ) und fetchRow(  ) abrufen
$q = $db->query("SELECT gerichtname, preis FROM gerichte");
while($zeile = $q->fetchRow(  )) {
    print "Der Preis von $zeile->gerichtname ist $zeile->preis \n";
}

print "getAll(  ): \n";
// Alle Zeilen mit getAll(  ) abrufen
$gerichte = $db->getAll('SELECT gerichtname, preis FROM gerichte');
foreach ($gerichte as $gericht) {
    print "Der Preis von $gericht->gerichtname ist $gericht->preis \n";
}

print "getRow(  ): \n";
$billig = $db->getRow('SELECT gerichtname, preis FROM gerichte
    ORDER BY preis LIMIT 1');
print "Das billigste Gericht ist $billig->gerichtname und hat den Preis $billig->preis";
?>
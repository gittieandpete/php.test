<?php
require 'DB.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) {
    die ("Keine Verbindung");
}

// Den Abrufmodus in assoziative Arrays ändern
$db->setFetchMode(DB_FETCHMODE_ASSOC);

print "<gerichte>\n";
$q = $db->query("SELECT gericht_id, gerichtname, preis FROM gerichte WHERE ist_scharf = 1");
while($zeile = $q->fetchRow()) {
    print ' <gericht id="' . htmlentities($zeile['gericht_id']) .'">' . "\n";
    print '  <name>' . htmlentities($zeile['gerichtname'])."</name>\n";
    print '  <preis>' . htmlentities($zeile['preis'])."</preis>\n";
    print " </gericht>\n";
}
print '</gerichte>';
?>
<?php
require 'DB.php';
require 'formularhelfer.php';

// Verbindung mit der Datenbank herstellen
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die ("Keine Verbindung: " . $db->getMessage(  )); }

// Die automatische Fehlerbehandlung einrichten
$db->setErrorHandling(PEAR_ERROR_DIE);

// Den Abrufmodus einrichten: Zeilen als assoziative Arrays
$db->setFetchMode(DB_FETCHMODE_ASSOC);

// Das Array mit den Gerichtnamen aus der Datenbank abrufen
$gerichtnamen = array(  );
$res = $db->query('SELECT gericht_id,gerichtname FROM gerichte');
while ($zeile = $res->fetchRow()) {
    $gerichtnamen[ $zeile['gericht_id'] ] = $zeile['gerichtname'];
}
$kunden = $db->query('SELECT * FROM kunden ORDER BY kundenname');

if ($kunden->numRows() == 0) {
    print "Keine Kunden.";
} else {
    print '<table>';
    print '<tr><th>ID</th><th>Name</th><th>Telefon</th><th>Lieblingsgericht</th></tr>';
    while ($kunde = $kunden->fetchRow(  )) {
        printf('<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td></tr>',
               $kunde['kunden_id'],
               htmlentities($kunde['kundenname']),
               $kunde['telefon'],
               $gerichtnamen [ $kunde['lieblingsgericht_id'] ]);
    }
    print '</table>';
}
?>
<?php
require 'DB.php';

$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die("Keine Verbindung: " . $db->getMessage(  )); }
$db->setErrorHandling(PEAR_ERROR_DIE);
$db->setFetchMode(DB_FETCHMODE_ASSOC);

$gerichte = $db->getAll('SELECT gerichtname,preis FROM gerichte ORDER BY preis');

if (count($gerichte) > 0) {
    print '<ul>';
    foreach ($gerichte as $gericht) {
        print "<li> $gericht[gerichtname] ($gericht[preis])</li>";
    }
    print '</ul>';
} else {
    print 'Keine Gerichte verfügbar.';
}
?>
<?php
require 'DB.php';
// Die Hilfsfunktionen für die Ausgabe der Formularelemente laden
require 'formularhelfer.php';
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die("Keine Verbindung: " . $db->getMessage(  )); }
$db->setErrorHandling(PEAR_ERROR_DIE);
$db->setFetchMode(DB_FETCHMODE_ASSOC);
// Das Array mit Gerichtnamen aus der Datenbank abrufen
$gerichtnamen = array(  );
$res = $db->query('SELECT gerichtname FROM gerichte');
while ($zeile = $res->fetchRow(  )) {
    $gerichtnamen[  ] = $zeile['gerichtname'];
}
if ($_POST['_abgeschickt_test']) {
    if ($formularfehler = validiere_formular(  )) {
        zeige_formular($formularfehler);
    } else {
        verarbeite_formular(  );
    }
} else {
    zeige_formular(  );
}
function zeige_formular($fehler = '') {
    global $db;
    if ($fehler) {
        print 'Bitte beheben Sie die folgenden Fehler: <ul><li>';
        print implode('</li><li>',$fehler);
        print '</li></ul>';
    }
    // Der Anfang des Formulars
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    print '<table>';
    // Menü zur Auswahl der Gerichte
    print '<tr><td>Gericht:</td><td>';
    input_select('gerichtname', $_POST, $GLOBALS['gerichtnamen']);
    print '</td></tr>';
    
    // Formularende
    print '<tr><td colspan="2"><input type="submit" value="Search Dishes">';
    print '</td></tr>';
    print '</table>';
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}      
function validiere_formular(  ) {
    $fehler = array(  );
    if (! array_key_exists($_POST['gerichtname'], $GLOBALS['gerichtnamen'])) {
        $fehler[  ] = 'Wählen Sie ein gültiges Gericht.';
    }
    return $fehler;
}
function verarbeite_formular(  ) {
    global $db;
    // Übersetze $_POST['gerichtname'] (eine Zahl) in einen Namen 
    // wie "Walnuss-Weckchen"
    $gerichtname = $GLOBALS['gerichtnamen'][ $_POST['gerichtname'] ];
    $gericht_info = $db->getRow('SELECT gericht_id, gerichtname, preis,
                                ist_scharf FROM gerichte WHERE
                                gerichtname = ?',
                               array($gerichtname));
    if (count($gericht_info) > 0) {
        print '<ul>';
        print "<li> ID: $gericht_info[gericht_id]</li>";
        print "<li> Name: $gericht_info[gerichtname]</li>";
        print "<li> Preis: $gericht_info[preis]</li>";
        print "<li> Schärfe: $gericht_info[ist_scharf]</li>";
        print '</ul>';
    } else {
        print 'Keine passenden Gerichte.';
    }
}
?>
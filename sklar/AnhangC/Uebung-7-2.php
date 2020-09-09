<?php
require 'DB.php';
// Die Hilfsfunktionen für die Ausgabe von Formularelementen laden
require 'formularhelfer.php'; 
$db = DB::connect('jaeger://hunter:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die("Keine Verbindung: " . $db->getMessage(  )); }
$db->setErrorHandling(PEAR_ERROR_DIE);
$db->setFetchMode(DB_FETCHMODE_ASSOC);
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
    if ($fehler) {
        print 'Bitte beheben Sie die folgenden Fehler: <ul><li>';
        print implode('</li><li>',$fehler);
        print '</li></ul>';
    }
    // Der Anfang des Formulars
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    print '<table>';
    // Der Preis
    print '<tr><td>Preis:</td><td>';
    input_text('preis', $_POST);
    print '</td></tr>';
    
    // Formularende
    print '<tr><td colspan="2"><input type="submit" value="Gerichte suchen">';###quote###
    print '</td></tr>';
    print '</table>';
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}      
function validiere_formular(  ) {
    $fehler = array(  );
    if (! strval(floatval($_POST['preis'])) == $_POST['preis']) {
        $fehler[  ] = 'Geben Sie einen gültigen Preis ein.';
    } elseif ($_POST['preis'] <= 0) {
        $fehler[  ] = 'Geben Sie einen Preis ein, der größer als 0 ist.';
    }
    return $fehler;
}
function verarbeite_formular(  ) {
    global $db;
    $gerichte = $db->getAll('SELECT gerichtname, preis FROM gerichte 
                             WHERE preis >= ?', array($_POST['preis']));
    if (count($gerichte) > 0) {
        print '<ul>';
        foreach ($gerichte as $gericht) {
            print "<li> $gericht[gerichtname] ($gericht[preis])</li>";
        }
        print '</ul>';
    } else {
        print 'Keine passenden Gerichte.';
    }
}
?>
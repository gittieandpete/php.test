<?php
// PEAR DB laden
require 'DB.php';
// Die Hilfsfunktionen für Formulare laden
require 'formularhelfer.php';

// Mit der Datenbank verbinden
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die ("Keine Verbindung: " . $db->getMessage(  )); }
// Die automatische Fehlerbehandlung einrichten
$db->setErrorHandling(PEAR_ERROR_DIE);

// Die eigentliche Seitenlogik:
// - Wurde das Formular abgeschickt, validiere und verarbeite dann oder zeige erneut an
// - Wurde es nicht abgeschickt, zeige es an
if ($_POST['_abgeschickt_test']) {
    // Liefert validiere_formular(  ) Fehler, übergebe sie an zeige_formular(  )
    if ($formularfehler = validiere_formular(  )) {
        zeige_formular($formularfehler);
    } else {
        // Die übermittelten Daten sind gültig, also verarbeite sie
        verarbeite_formular(  );
    }
} else {
    // Das Formular wurde nicht übermittelt, also zeige es an
    zeige_formular(  );
}

function zeige_formular($fehler = '') {
    // Wurde das Formular übermittelt, verwende die übermittelten Parameter als Standardwerte
    if ($_POST['_abgeschickt_test']) {
        $standardwerte = $_POST;
    } else {
        // Andernfalls setze unsere eigenen Standardwerte: preis ist 5?
        $standardwerte = array('preis' => '5.00');
    }
    
    // Wurden Fehler übergeben, stecke sie (einschließlich HTML-Markup) in  $fehlertext
    if ($fehler) {
        $fehlertext = '<tr><td>Bitte beheben Sie folgende Fehler:';
        $fehlertext .= '</td><td><ul><li>';
        $fehlertext .= implode('</li><li>',$fehler);
        $fehlertext .= '</li></ul></td></tr>';
    } else {
        // Keine Fehler? Dann ist $fehlertext leer
        $fehlertext = '';
    }

    // Den PHP-Modus verlassen, um die Anzeige all der HTML-Tags zu vereinfachen
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
<table>
<?php print $fehlertext ?>

<tr><td>Gerichtname:</td>
<td><?php input_text('gerichtname', $standardwerte); ?></td></tr>

<tr><td>Preis:</td>
<td><?php input_text('preis', $standardwerte); ?></td></tr>

<tr><td>Scharf:</td>
<td><?php input_radiocheck('checkbox','ist_scharf', $standardwerte, 'ja'); ?>
 Ja</td></tr>

<tr><td colspan="2" align="center"><?php input_submit('sichern','Bestellen'); ?>
</td></tr>

</table>
<input type="hidden" name="_abgeschickt_test" value="1"/>
</form>
<?php
      } // Ende von zeige_formular(  )

function validiere_formular(  ) {
    $fehler = array(  );

    // gerichtname ist erforderlich
    if (! strlen(trim($_POST['gerichtname']))) {
        $fehler[  ] = 'Bitte geben Sie den Namen des Gerichts ein.';
    }

    // preis muss eine gültige Fließkommazahl und größer 0 sein
    if (floatval($_POST['preis']) <= 0) {
        $fehler[  ] = 'Bitte geben Sie einen gültigen Preis ein.';
    }

    return $fehler;
}

function verarbeite_formular(  ) {
    // Auf die globale Variable $db innerhalb dieser Funktion zugreifen
    global $db;

    // Eine eindeutige Kennung für dieses Gericht abrufen
    $gericht_id = $db->nextID('gerichte');

    // Auf Grundlage der Checkbox den Wert von $ist_scharf setzen
    if ($_POST['ist_scharf'] == 'ja') {
        $ist_scharf = 1;
    } else {
        $ist_scharf = 0;
    }

    // Das neue Gericht in die Tabelle einfügen
    $db->query('INSERT INTO gerichte (gericht_id, gerichtname, preis, ist_scharf)
                VALUES (?,?,?,?)',
               array($gericht_id, $_POST['gerichtname'], $_POST['preis'],
                     $ist_scharf));

    // Dem Benutzer mitteilen, dass das neue Gericht hinzugefügt wurde
    print htmlentities($_POST['gerichtname']) . 
          ' wurde der Datenbank hinzugefügt.';
}

?>

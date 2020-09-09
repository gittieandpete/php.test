<?php

/* Die Struktur der Tabelle kunden:
    CREATE TABLE kunden (
        kunden_id INT UNSIGNED
        kundenname VARCHAR(255),
        telefon VARCHAR(15),
        lieblingsgericht_id INT 
    )
*/

//Das Formular, das einen neuen Kunden einfügt:

require 'DB.php';
require 'formularhelfer.php';

// Mit der Datenbank verbinden
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
if (DB::isError($db)) { die ("Keine Verbindung: " . $db->getMessage(  )); }

// Die automatische Fehlerbehandlung einschalten
$db->setErrorHandling(PEAR_ERROR_DIE);

// Den Abrufmodus einrichten: Zeilen als assoziative Arrays
$db->setFetchMode(DB_FETCHMODE_ASSOC);

// Das Array mit den Gerichtnamen aus der Datenbank abrufen
$gerichtnamen = array(  );
$res = $db->query('SELECT gericht_id,gerichtname FROM gerichte');
while ($zeile = $res->fetchRow(  )) {
    $gerichtnamen[ $zeile['gericht_id'] ] = $zeile['gerichtname'];
}

// Die eigentliche Seitenlogik:
// - Wurde das Formular übermittelt, validiere es und verarbeite es
//   dann oder zeige es erneut an
// - Wurde es nicht übermittelt, zeige es an
if ($_POST['_abgeschickt_test']) {
    // Wenn validiere_formular(  ) Fehler liefert, übergebe sie an zeige_formular(  )
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
    global $gerichtnamen;
    // Wurde das Formular übermittelt, verwende die übermittelten
    // Variablen als Standardwerte
    if ($_POST['_abgeschickt_test']) {
        $standardwerte = $_POST;
    } else {
        // Andernfalls gibt es keine Standardwerte
        $standardwerte = array(  );
    }
    
    // Wurden Fehler übergeben, speichere Sie (einschließlich 
    // HTML-Markup) in $fehlertext
    if ($fehler) {
        $fehlertext = '<tr><td>Bitte beheben Sie die folgenden Fehler:';
        $fehlertext .= '</td><td><ul><li>';
        $fehlertext .= implode('</li><li>',$fehler);
        $fehlertext .= '</li></ul></td></tr>';
    } else {
        // Keine Fehler? Dann ist $fehlertext leer
        $fehlertext = '';
    }
    // Den PHP-Modus verlassen, um das Ausgeben all der HTML-Tags 
    // zu erleichtern
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
<table>
<?php print $fehlertext ?>
<tr><td>Kundenname:</td>
<td><?php input_text('kundenname', $standardwerte) ?></td></tr>
<tr><td>Telefonnummer:</td>
<td><?php input_text('telefon', $standardwerte) ?></td></tr>
<tr><td>Lieblingsgericht:</td>
<td><?php input_select('lieblingsgericht_id', $standardwerte, $gerichtnamen); ?></td></tr>
<tr><td colspan="2" align="center"><?php input_submit('speichern','Kunde hinzufügen'); ?>
</td></tr>
</table>
<input type="hidden" name="_abgeschickt_test" value="1"/>
</form>
<?php
      } // Das Ende von verarbeite_formular(  )

function validiere_formular(  ) {
    global $gerichtnamen;
    $fehler = array(  );
    // kundenname ist erforderlich
    if (! strlen(trim($_POST['kundenname']))) {
        $fehler[  ] = 'Bitte geben Sie den Kundennamen ein.';
    }
    // telefon ist erforderlich und muss ein vernünftiges Format haben
    if (! strlen(trim($_POST['telefon']))) {
        $fehler[  ] = 'Bitte geben Sie eine Telefonnummer ein';
    } elseif (! preg_match('/^\d{3,4}\/?\d{6,7}$/', $_POST['telefon'])) {
        $fehler[  ] = 'Geben Sie eine Telefonnummer im Format XXXX/XXXXXX ein.';
    }
    // Das Lieblingsgericht ist erforderlich
    if (! array_key_exists($_POST['lieblingsgericht_id'], $gerichtnamen)) {
        $fehler[  ] = 'Wählen Sie eine Lieblingsgericht.';
    }
    return $fehler;
}

function verarbeite_formular(  ) {
    // Auf die globale Variable $db innerhalb dieser Funktion zugreifen
    global $db;
    // Eine eindeutige ID für diesen Kunden erzeugen
    $kunden_id = $db->nextID('kunden');
    // Den neuen Kunden in die Tabelle einfügen
    $db->query('INSERT INTO kunden (kunden_id, kundenname, telefon, lieblingsgericht_id) VALUES (?,?,?,?)',
               array($kunden_id, $_POST['kundenname'], $_POST['telefon'], 
                     $_POST['lieblingsgericht_id']));
    // Dem Benutzer mitteilen, dass der neue Kunde hinzugefügt wurde
    print htmlentities($_POST['kundenname']) . ' wurde der Datenbank hinzugefügt.';
}
?>
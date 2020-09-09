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

// Den Abrufmodus einrichten: Zeilen sollen als Objekte geliefert werden
$db->setFetchMode(DB_FETCHMODE_OBJECT);

// Wahlmöglichkeiten für das "scharf"-Menü des Formulars
$scharf_auswahl = array('Nein','Ja','Beides');

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
    // Wurde das Formular übermittelt, mach die übermittelten Parameter zu den Standardwerten
    if ($_POST['_abgeschickt_test']) {
        $standardwerte = $_POST;
    } else {
        // Andernfalls, richte eigene Standardwerte ein
        $standardwerte = array('min_preis' => '5.00',
                          'max_preis' => '25.00');
    }
    
    // Wenn Fehler übergeben wurden, packe sie (samt HTML-Markup) in $fehlertext
    if ($fehler) {
        $fehlertext = '<tr><td>Beheben Sie Bitte folgende Fehler:';
        $fehlertext .= '</td><td><ul><li>';
        $fehlertext .= implode('</li><li>',$fehler);
        $fehlertext .= '</li></ul></td></tr>';
    } else {
        // Keine Fehler? Dann ist $fehlertext leer
        $fehlertext = '';
    }

    // Den PHP-Modus verlassen, um das Ausgeben all der HTML-Tags zu erleichtern
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
<table>
<?php print $fehlertext ?>

<tr><td>Gerichtname:</td>
<td><?php input_text('gerichtname', $standardwerte) ?></td></tr>

<tr><td>Minimales Preis:</td>
<td><?php input_text('min_preis', $standardwerte) ?></td></tr>

<tr><td>Maximaler Preis:</td>
<td><?php input_text('max_preis', $standardwerte) ?></td></tr>

<tr><td>Scharf:</td>
<td><?php input_select('ist_scharf', $standardwerte, $GLOBALS['scharf_auswahl']); ?>
</td></tr>

<tr><td colspan="2" align="center"><?php input_submit('suchen','Suchen'); ?>
</td></tr>

</table>
<input type="hidden" name="_abgeschickt_test" value="1"/>
</form>
<?php
      } // Ende von zeige_formular(  )

function validiere_formular(  ) {
    $fehler = array(  );

    // Der minimale Preis muss eine gültige Fließkommazahl sein
    if ($_POST['min_preis'] != strval(floatval($_POST['min_preis']))) {
        $fehler[  ] = 'Bitte geben Sie einen gültigen minimalen Preis ein.';
    }

    // Der maximale Preis muss eine gültige Fließkommazahl sein
    if ($_POST['max_preis'] != strval(floatval($_POST['max_preis']))) {
        $fehler[  ] = 'Bitte geben Sie einen gültigen maximalen Preis ein.';
    }

    // Der mininmale Preis muss kleiner als der maximale Preis sein
    if ($_POST['min_preis'] >= $_POST['max_preis']) {
        $fehler[  ] = 'Der minimale Preis muss kleiner als der maximale Preis sein.';
    }

    if (! array_key_exists($_POST['ist_scharf'], $GLOBALS['scharf_auswahl'])) {
        $fehler[  ] = 'Bitte wählen Sie bei "Scharf" eine zulässige Option.';
    }
    return $fehler;
}

function verarbeite_formular(  ) {
    // Greife auf die globale Variable $db innerhalb dieser Funktion zu
    global $db;
    
    // Die Abfrage aufbauen 
    $sql = 'SELECT gerichtname, preis, ist_scharf FROM gerichte WHERE
            preis >= ? AND preis <= ?';

    // Wenn ein Gerichtname übermittelt wurde, füge ihn zur WHERE-Klausel hinzu.
    // Wir verwenden quoteSmart(  ) und strtr(  ), um vom Benutzer eingegebene 
    // Jokerzeichen zu maskieren
    if (strlen(trim($_POST['gerichtname']))) {
        $gericht = $db->quoteSmart($_POST['gerichtname']);
        $gericht = strtr($gericht, array('_' => '\_', '%' => '\%'));
        $sql .= " AND gerichtname LIKE $gericht";
    }

    // Wenn ist_scharf gleich "Ja" oder "Nein" ist, füge das entsprechende 
    // SQL hinzu (wenn es "Beides" ist, müssen wir der WHERE-Klausel 
    // ist_scharf nicht hinzufügen)
    $scharf_auswahl = $GLOBALS['scharf_auswahl'][ $_POST['ist_scharf'] ];
    if ($scharf_auswahl == 'Ja') {
        $sql .= ' AND ist_scharf = 1';
    } elseif ($scharf_auswahl == 'Nein') {
        $sql .= ' AND ist_scharf = 0';
    }

    // Die Abfrage an die Datenbank schicken und alle Zeilen abrufen
    $gerichte = $db->getAll($sql, array($_POST['min_preis'],
                                      $_POST['max_preis']));

    if (count($gerichte) == 0) {
        print 'Keine passenden Gerichte gefunden.';
    } else {
        print '<table>';
        print '<tr><th>Gerichtname</th><th>Preis</th><th>Scharf?</th></tr>';
        foreach ($gerichte as $gericht) {
            if ($gericht->ist_scharf == 1) {
                $scharf = 'Ja';
            } else {
                $scharf = 'Nein';
            }
            printf('<tr><td>%s</td><td>$%.02f</td><td>%s</td></tr>',
                   htmlentities($gericht->gerichtname), $gericht->preis, $scharf);
        }
    }
}
?>

<?php
// Vergessen Sie nicht, den Code für die Formular-Hilfsfunktion
// einzuschließen, die in Beispiel 6-29 definiert wurden

require 'formularhelfer.php';

// Die Arrays mit den Optionen der Auswahlmenüs einrichten, die von 
// zeige_formular(  ), validiere_formular(  ) und verarbeite_formular(  ) 
// benötigt und deswegen mit globaler Geltung deklariert werden
$suesswaren = array('windbeutel' => 'Sesam-Windbeutel',
                    'happen' => 'Kokosnuss-Gelee-Happen',
                    'toertchen' => 'Karamell-Törtchen',
                    'reisfleisch' => 'Süßer Reis mit Fleisch');

$hauptgerichte = array('gurke' => 'Gedünstete Seegurke',
                       'magen' => "Sautierter Schweinemagen",
                       'kutteln' => 'Sautierte Kutteln in Calvados',
                       'taro' => 'Geschmortes Schwein mit Taro',
                       'gaense' => 'Geschmortes Gänseklein mit Salz', 
                       'abalone' => 'Abalone mit Mark und Entenfüßen');

// Die eigentliche Logik der Seiten:
// - Wenn das Formular übermittelt wurde, validiere und verarbeite dann 
//   oder zeige erneut an
// - Wenn das Formular nicht übermittelt wurde, zeige es an
if ($_POST['_abgeschickt_test']) {
    // Wenn validiere_formular(  ) Fehler meldet, übergebe sie an zeige_formular(  )
    if ($formularfehler = validiere_formular(  )) {
        zeige_formular($formularfehler);
    } else {
        // Die übermittelten Daten sind gültig, also verarbeite sie
        verarbeite_formular(  );
    }
} else {
    // Das Formular wurde noch nicht übermittelt, also zeige es an
    zeige_formular(  );
}

function zeige_formular($fehler = '') {
    // Wenn das Formular abgeschickt wurde, verwende die übermittelten 
    // Parameter als Standardwerte
    if ($_POST['_abgeschickt_test']) {
        $standardwerte = $_POST;
    } else {
        // Andernfalls eigene Standardwerte festlegen: mittlere Größe und 
        // ein Ja zur Lieferung
        $standardwerte = array('lieferung' => 'ja',
                               'groesse'     => 'mittel');
    }
    
    // Wenn Fehler übergeben wurden, packe sie (einschließlich HTML-Markup) in $fehlertext
    if ($fehler) {
        $fehlertext = '<tr><td>Sie müssen die folgenden Fehler beheben:';
        $fehlertext .= '</td><td><ul><li>';
        $fehlertext .= implode('</li><li>',$fehler);
        $fehlertext .= '</li></ul></td></tr>';
    } else {
        // Keine Fehler? Dann ist $fehlertext leer
        $fehlertext = '';
    }

    // Verlasse den PHP-Modus, um die Ausgabe all der HTML-Elemente 
    // einfacher zu machen
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
<table>
<?php print $fehlertext ?>

<tr><td>Ihr Name:</td>
<td><?php input_text('name', $standardwerte) ?></td></tr>

<tr><td>Größe:</td>
<td><?php input_radiocheck('radio','groesse', $standardwerte, 'klein');  ?> Klein <br/>
<?php input_radiocheck('radio','groesse', $standardwerte, 'mittel'); ?> Mittel <br/>
<?php input_radiocheck('radio','groesse', $standardwerte, 'gross');  ?> Groß
</td></tr>

<tr><td>Wählen Sie ein süßes Gericht:</td>
<td><?php input_select('suess', $standardwerte, $GLOBALS['suesswaren']); ?>
</td></tr>

<tr><td>Wählen Sie zwei Hauptgerichte:</td>
<td>
<?php input_select('hauptgericht', $standardwerte, $GLOBALS['hauptgerichte'], true) ?>
</td></tr>

<tr><td>Möchten Sie, dass Ihre Bestellung geliefert wird?</td>
<td><?php input_radiocheck('checkbox','lieferung', $standardwerte, 'ja'); ?> Ja
</td></tr>

<tr><td>Geben Sie besondere Anweisungen an.<br/>
Geben Sie hier Ihre Adresse an, wenn Ihre Bestellung geliefert werden soll:</td>
<td><?php input_textarea('kommentare', $standardwerte); ?></td></tr>

<tr><td colspan="2" align="center"><?php input_submit('speichern','Bestellen'); ?>
</td></tr>

</table>
<input type="hidden" name="_abgeschickt_test" value="1"/>
</form>
<?php
      } // Das Ende von zeige_formular(  )

function validiere_formular(  ) {
    $fehler = array(  );

    // name ist erforderlich
    if (! strlen(trim($_POST['name']))) {
        $fehler[  ] = 'Bitte geben Sie Ihren Namen ein.';
    }
    // groesse ist erforderlich
    if (($_POST['groesse'] != 'klein') && ($_POST['groesse'] != 'mittel') &&
        ($_POST['groesse'] != 'gross')) {
        $fehler[  ] = 'Bitte wählen Sie eine Größe aus.';
    }
    // suess ist erforderlich
    if (! array_key_exists($_POST['suess'], $GLOBALS['suesswaren'])) {
        $fehler[  ] = 'Bitte wählen Sie ein süßes Gericht.';
    }
    // Es sind genau zwei Hauptgerichte erforderlich
    if (count($_POST['hauptgericht']) != 2) {
        $fehler[  ] = 'Bitte wählen Sie genau zwei Hauptgerichte.';
    } else {
        // Es sind zwei Hauptgerichte ausgewählt, also prüfe nach, 
        // ob beide gültig sind
        if (! (array_key_exists($_POST['hauptgericht'][0], $GLOBALS['hauptgerichte']) &&
               array_key_exists($_POST['hauptgericht'][1], $GLOBALS['hauptgerichte']))) {
            $fehler[  ] = 'Bitte wählen Sie genau zwei gültige Hauptgerichte.';
        }
    }
    // Wenn lieferung ausgewählt ist, muss kommentare etwas enthalten
    if (($_POST['lieferung'] == 'ja') && (! strlen(trim($_POST['kommentare'])))) {
        $fehler[  ] = 'Bitte geben Sie für die Lieferung Ihre Adresse an.';
    }

    return $fehler;
}

function verarbeite_formular(  ) {
    // Suche die vollständigen Namen des süßen Gerichts und der Hauptgerichte
    // in den Arrays $GLOBALS['suesswaren'] und $GLOBALS['hauptgerichte'] 
    $suess = $GLOBALS['suesswaren'][ $_POST['suess'] ];
    $hauptgericht_1 = $GLOBALS['hauptgerichte'][ $_POST['hauptgericht'][0] ];
    $hauptgericht_2 = $GLOBALS['hauptgerichte'][ $_POST['hauptgericht'][1] ];
    if ($_POST['lieferung'] == 'ja') {
        $lieferung = 'möchten eine';
    } else {
        $lieferung = 'möchten keine';
    }
    // Den Text für die Bestellungsnachricht aufbauen
    $nachricht=<<<_BESTELLUNG_
Vielen Dank für Ihre Bestellung, $_POST[name].
Sie haben $suess, $hauptgericht_1 und $hauptgericht_2 der Größe  $_POST[groesse] bestellt.
Sie $lieferung Lieferung.
_BESTELLUNG_;
    if (strlen(trim($_POST['kommentare']))) {
        $message .= 'Ihre weiteren Angaben: '.$_POST['kommentare'];
    }

    // Schicke die Nachricht an den Koch
    mail('koch@restaurant.beispiel.com', 'Neue Bestellung', $nachricht);
    // Gib die Nachricht aus, aber kodiere dabei alle HTML-Entities
    // und wandle Zeilenumbrüche in <br/>-Tags um
    print nl2br(htmlentities($nachricht));
}
?>

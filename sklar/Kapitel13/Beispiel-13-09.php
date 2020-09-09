<?php
// Die QuickForm-Bibliothek laden
require 'HTML/QuickForm.php';
// Das Formular-Objekt erzeugen
$formular = new HTML_QuickForm(  );

// Die gleichen Arrays mit gültigen Süßwaren und Hauptgerichten erzeugen
$suesswaren = array('windbeutel' => 'Sesam-Windbeutel',
                    'happen' => 'Kokusnuss-Gelee-Happen',
                    'toertchen' => 'Karamell-Törtchen',
                    'reisfleisch' => 'Süßer Reis und Fleisch');

$hauptgerichte = array('gurke' => 'Gedünstete Seegurke',
                       'magen' => "Sautierter Schweinemagen",
                       'kutteln' => 'Sautierte Kutteln in Calvados',
                       'taro' => 'Geschmortes Schwein mit Taro',
                       'gaense' => 'Geschmortes Gänseklein mit Salz', 
                       'abalone' => 'Abalone mit Mark und Entenfüßen');

// Die Standardwerte für die Formularelemente einrichten
$formular->setDefaults(array('lieferung' => 'ja',
                             'groesse'   => 'mittel'));

// Dem Formular alle Elemente hinzufügen
$formular->addElement('text','name','Ihr Name: ');
$formular->addElement('radio','groesse','Größe:','Klein', 'klein');
$formular->addElement('radio','groesse','',     'Mittel', 'mittel');
$formular->addElement('radio','groesse','',     'Groß', 'gross');

$formular->addElement('select','suess','Wählen Sie ein süßes Gericht:', $suesswaren);
$formular->addElement('select','hauptgericht','Wählen Sie zwei 
                      Hauptgerichte:',$hauptgerichte, 'multiple="multiple"');

$formular->addElement('radio','lieferung','Soll die Bestellung 
                      geliefert werden?','Ja','ja');

$formular->addElement('textarea','kommentare','Geben Sie besondere 
                      Anweisungen an. <br/>Geben Sie hier Ihre Adresse an, 
                      wenn Ihre Bestellung geliefert werden soll:');

$formular->addElement('submit','speichern','Bestellen');

// Erzeuge zwei selbst definierte Validierungsregeln (die von Funktionen
// am Ende des Skripts implementiert werden) 
$formular->registerRule('array_pruefen','function','array_pruefen');
$formular->registerRule('array_groesse_pruefen','function','array_groesse_pruefen');

// Das Feld name ist erforderlich
$formular->addRule('name','Bitte geben Sie Ihren Namen ein.','required');
// Das Feld groesse ist erforderlich, und der Wert muss
// "klein", "mittel" oder "gross" sein
$formular->addRule('groesse','Bitte wählen Sie eine Größe.','required');
$formular->addRule('groesse','Bitte wählen Sie eine Größe.',
                   'array_pruefen',array('klein' => 1, 'mittel' => 1, 
                   'gross' => 1));

// Das Feld suess ist erforderlich und sein Wert muss sich im
// Array $suesswaren befinden
$formular->addRule('suess','Bitte wählen Sie ein gültiges süßes 
                   Gericht.','required');
$formular->addRule('suess','Bitte wählen Sie ein gültiges süßes Gericht.', 
                   'array_pruefen',$suesswaren);

// Das Feld hauptname ist erforderlich und muss genau zwei Werte enthalten
// die sich im Array $hauptgerichte befinden
$formular->addRule('hauptgericht','Bitte wählen Sie genau zwei Hauptgerichte.',
               'required');
$formular->addRule('hauptgericht','Bitte wählen Sie genau zwei 
                   Hauptgerichte.','check_array_size', 2);
$formular->addRule('hauptgericht','Bitte wählen Sie genau zwei 
                   Hauptgerichte.','array_pruefen', $hauptgerichte);

// Die eigentliche Seitenlogik: Wenn die übermittelten Formularparameter 
// gültig sind, verarbeite Sie, indem die Funktion bestellung_speichern() 
// ausgeführt wird, andernfalls zeige das Formular an
if ($formular->validate(  )) {
    $formular->process('bestellung_speichern');
} else {
    $formular->display(  );
}

// Die Funktion, die die Formularverarbeitung durchführt. Sie ist mit der 
// Funktion verarbeite_formular() aus Kapitel 6 identisch, abgesehen davon,
// dass auf die übermittelten Formularparameter über $formulardaten anstatt
// über $_POST zugegriffen wird
function bestellung_speichern($formulardaten) {
    // Die vollständigen Namen der süßen Gerichte und Hauptgerichte in den 
    // Arrays $GLOBALS['suesswaren'] und $GLOBALS['hauptgerichte'] suchen
    $suessware = $GLOBALS['suesswaren'][ $formulardaten['suess'] ];
    $hauptgericht_1 = $GLOBALS['hauptgerichte'][ $formulardaten['hauptgericht'][0] ];
    $hauptgericht_2 = $GLOBALS['hauptgerichte'][ $formulardaten['hauptgericht'][1] ];
    if ($formulardaten['lieferung'] == 'ja') {
        $lieferung = 'wünschen eine';
    } else {
        $lieferung = 'wünschen keine';
    }
    // Den Bestellungstext aufbauen
    $nachricht=<<<_BESTELLUNG_
Vielen Dank für Ihre Bestellung, $formulardaten[name].
Sie haben $suessware, $hauptgericht_1 und $hauptgericht_2 der Größe 
$formulardaten[groesse] bestellt. Sie $lieferung Lieferung.
_BESTELLUNG_;
    if (strlen(trim($formulardaten['kommentare']))) {
        $nachricht .= 'Ihre Anweisungen: '.$formulardaten['kommentare'];
    }

    // Die Nachricht an den Koch senden
    mail('koch@restaurant.beispiel.com', 'Neue Bestellung', $nachricht);
    // Die Nachricht ausgeben und dabei alle HTML-Entitys kodieren und
    // Zeilenumbrüche in <br/>-Tags umwandeln
    print nl2br(htmlentities($nachricht));
}

// Eine Hilfsfunktion zur Validierung, die prüft, ob $param_wert ein 
// Schlüssel in $array ist (oder jeder Wert in $param_wert ein Schlüssel
// in $array ist, wenn $param_wert ein Array ist
function array_pruefen($param_name, $param_wert, $array) { 
    if (is_array($param_wert)) {
        foreach ($param_wert as $uebermittelter_wert) {
            if (! array_key_exists($uebermittelter_wert, $array)) {
                return false;
            }
        }
        return true;
    } else {
        return array_key_exists($param_wert, $array);
    }
}

function array_groesse_pruefen($param_name, $param_wert, $size) { 
    return count($param_wert) == $size;
}
?>

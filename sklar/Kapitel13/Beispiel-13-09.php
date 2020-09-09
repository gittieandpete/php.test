<?php
// Die QuickForm-Bibliothek laden
require 'HTML/QuickForm.php';
// Das Formular-Objekt erzeugen
$formular = new HTML_QuickForm(  );

// Die gleichen Arrays mit g�ltigen S��waren und Hauptgerichten erzeugen
$suesswaren = array('windbeutel' => 'Sesam-Windbeutel',
                    'happen' => 'Kokusnuss-Gelee-Happen',
                    'toertchen' => 'Karamell-T�rtchen',
                    'reisfleisch' => 'S��er Reis und Fleisch');

$hauptgerichte = array('gurke' => 'Ged�nstete Seegurke',
                       'magen' => "Sautierter Schweinemagen",
                       'kutteln' => 'Sautierte Kutteln in Calvados',
                       'taro' => 'Geschmortes Schwein mit Taro',
                       'gaense' => 'Geschmortes G�nseklein mit Salz', 
                       'abalone' => 'Abalone mit Mark und Entenf��en');

// Die Standardwerte f�r die Formularelemente einrichten
$formular->setDefaults(array('lieferung' => 'ja',
                             'groesse'   => 'mittel'));

// Dem Formular alle Elemente hinzuf�gen
$formular->addElement('text','name','Ihr Name: ');
$formular->addElement('radio','groesse','Gr��e:','Klein', 'klein');
$formular->addElement('radio','groesse','',     'Mittel', 'mittel');
$formular->addElement('radio','groesse','',     'Gro�', 'gross');

$formular->addElement('select','suess','W�hlen Sie ein s��es Gericht:', $suesswaren);
$formular->addElement('select','hauptgericht','W�hlen Sie zwei 
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
$formular->addRule('groesse','Bitte w�hlen Sie eine Gr��e.','required');
$formular->addRule('groesse','Bitte w�hlen Sie eine Gr��e.',
                   'array_pruefen',array('klein' => 1, 'mittel' => 1, 
                   'gross' => 1));

// Das Feld suess ist erforderlich und sein Wert muss sich im
// Array $suesswaren befinden
$formular->addRule('suess','Bitte w�hlen Sie ein g�ltiges s��es 
                   Gericht.','required');
$formular->addRule('suess','Bitte w�hlen Sie ein g�ltiges s��es Gericht.', 
                   'array_pruefen',$suesswaren);

// Das Feld hauptname ist erforderlich und muss genau zwei Werte enthalten
// die sich im Array $hauptgerichte befinden
$formular->addRule('hauptgericht','Bitte w�hlen Sie genau zwei Hauptgerichte.',
               'required');
$formular->addRule('hauptgericht','Bitte w�hlen Sie genau zwei 
                   Hauptgerichte.','check_array_size', 2);
$formular->addRule('hauptgericht','Bitte w�hlen Sie genau zwei 
                   Hauptgerichte.','array_pruefen', $hauptgerichte);

// Die eigentliche Seitenlogik: Wenn die �bermittelten Formularparameter 
// g�ltig sind, verarbeite Sie, indem die Funktion bestellung_speichern() 
// ausgef�hrt wird, andernfalls zeige das Formular an
if ($formular->validate(  )) {
    $formular->process('bestellung_speichern');
} else {
    $formular->display(  );
}

// Die Funktion, die die Formularverarbeitung durchf�hrt. Sie ist mit der 
// Funktion verarbeite_formular() aus Kapitel 6 identisch, abgesehen davon,
// dass auf die �bermittelten Formularparameter �ber $formulardaten anstatt
// �ber $_POST zugegriffen wird
function bestellung_speichern($formulardaten) {
    // Die vollst�ndigen Namen der s��en Gerichte und Hauptgerichte in den 
    // Arrays $GLOBALS['suesswaren'] und $GLOBALS['hauptgerichte'] suchen
    $suessware = $GLOBALS['suesswaren'][ $formulardaten['suess'] ];
    $hauptgericht_1 = $GLOBALS['hauptgerichte'][ $formulardaten['hauptgericht'][0] ];
    $hauptgericht_2 = $GLOBALS['hauptgerichte'][ $formulardaten['hauptgericht'][1] ];
    if ($formulardaten['lieferung'] == 'ja') {
        $lieferung = 'w�nschen eine';
    } else {
        $lieferung = 'w�nschen keine';
    }
    // Den Bestellungstext aufbauen
    $nachricht=<<<_BESTELLUNG_
Vielen Dank f�r Ihre Bestellung, $formulardaten[name].
Sie haben $suessware, $hauptgericht_1 und $hauptgericht_2 der Gr��e 
$formulardaten[groesse] bestellt. Sie $lieferung Lieferung.
_BESTELLUNG_;
    if (strlen(trim($formulardaten['kommentare']))) {
        $nachricht .= 'Ihre Anweisungen: '.$formulardaten['kommentare'];
    }

    // Die Nachricht an den Koch senden
    mail('koch@restaurant.beispiel.com', 'Neue Bestellung', $nachricht);
    // Die Nachricht ausgeben und dabei alle HTML-Entitys kodieren und
    // Zeilenumbr�che in <br/>-Tags umwandeln
    print nl2br(htmlentities($nachricht));
}

// Eine Hilfsfunktion zur Validierung, die pr�ft, ob $param_wert ein 
// Schl�ssel in $array ist (oder jeder Wert in $param_wert ein Schl�ssel
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

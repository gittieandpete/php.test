<?php
require 'formularhelfer.php';

session_start(  );

$hauptgerichte = array('gurke'   => 'Ged�nstete Seegurke',
                       'magen'   => "Sautierter Schweinemagen",
                       'kutteln' => 'Sautierte Kutteln in Calvados',
                       'taro'    => 'Geschmortes Schweinefleisch mit Taro',
                       'gaense'  => 'Gebackenes G�nseklein mit Salz', 
                       'abalone' => 'Abalone mit Mark und Entenf��en');

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
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';

    if ($fehler) {
        print '<ul><li>';
        print implode('</li><li>',$fehler);
        print '</li></ul>';
    } 
    // Da wir keine eigenen Standardwerte angeben, ist es in Ordnung, $_POST 
    // als das Array mit den Standardwerden an input_select und input_text
    // zu �bergeben, damit die Werte, die der Benutzer eingegeben hat,
    // bewahrt bleiben
    print 'Gericht: ';
    input_select('gericht', $_POST, $GLOBALS['hauptgerichte']);
    print '<br/>';

    print 'Menge: ';
    input_text('menge', $_POST);
    print '<br/>';

    input_submit('bestellen','Bestellen');

    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}

function validiere_formular(  ) {
    $fehler = array(  );

    // Das im Men� ausgew�hlte Gericht muss g�ltig sein
    if (! array_key_exists($_POST['gericht'], $GLOBALS['hauptgerichte'])) {
        $fehler[  ] = 'Bitte w�hlen Sie ein g�ltiges Gericht.';
    }

    if ((! is_numeric($_POST['menge'])) || (intval($_POST['menge']) <= 0)) {
        $fehler[  ] = 'Bitte geben Sie eine Menge ein.';
    }

    return $fehler;
}

function verarbeite_formular(  ) {
    $_SESSION['bestellung'][  ] = array('gericht' => $_POST['gericht'],
                                      'menge'   => $_POST['menge']);

    print 'Vielen Dank f�r Ihre Bestellung.';

} ?>
<?php
require 'formularhelfer.php';

session_start(  );

$farben = array('#ff0000' => 'Rot',
                '#ff6600' => 'Orange',
                '#ffff00' => 'Gelb',
                '#0000ff' => 'Grün',
                '#00ff00' => 'Blau',
                '#ff00ff' => 'Purpurrot');

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
    // Da wir keine eigenen Standardwerte angeben, ist es in Ordnung
    // $_POST als Array mit den Standardwerten an input_select und
    // input_text zu übergeben, damit alle vom Benutzer eingegebenen 
    // Werte erhalten bleiben
    print 'Farbe: ';
    input_select('farbe', $_POST, $GLOBALS['farben']);
    print '<br/>';
    input_submit('absenden','Farbe auswählen');
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}

function validiere_formular(  ) {
    $fehler = array(  );
    // Die ausgewählte Farbe muss gültig sein
    if (! array_key_exists($_POST['farbe'], $GLOBALS['farben'])) {
        $fehler[  ] = 'Wählen Sie eine gültige Farbe.';
    }
    return $fehler;
}

function verarbeite_formular(  ) {
    $_SESSION['farbe'] = $_POST['farbe'];
    print "Ihre Lieblingsfarbe ist: " . $GLOBALS['farben'][ $_SESSION['farbe'] ];
}
?>
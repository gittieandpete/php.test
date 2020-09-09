<?php

session_start(  );

require 'formularhelfer.php';

$produkte = array('gurke'    => 'Ged�nstete Seegurke',
                  'magen' => "Sautierter Schweinemagen",
                  'kutteln'   => 'Kutteln in Calvados',
                  'taro'    => 'Geschmortes Schweinefleisch mit Taro',
                  'gaense' => 'Gebackenes G�nseklein mit Salz', 
                  'abalone' => 'Abalone mit Mark und Entenf��en');

// Da das Formular nur aus einem Button besteht, m�ssen die 
// �bermittelten Formulardaten nicht validiert werden
if ($_POST['_abgeschickt_test']) {
    verarbeite_formular(  );
} else {
    zeige_formular(  );
}

function zeige_formular($fehler = '') {
    global $produkte;
    if ($_SESSION['gespeicherte_bestellung']) {
        print 'Ihre Bestellung: <ul>';
        foreach ($produkte as $produkt => $beschreibung) {
            if (array_key_exists("gericht_$produkt", $_SESSION)) {
                print '<li> '.$_SESSION["gericht_$produkt"]." $beschreibung </li>";
            }
        }
        print '</ul>';
    } else {
        print 'Es gibt kein gespeicherte Bestellung.';
    }
    print '<br/>';
    // Hier wird vorausgesetzt, dass das Bestellungsformular als
    // "bestellungsformular.php" gespeichert wird
    print '<a href="bestellungsformular.php">Zur Bestellungsseite zur�ckgehen</a>';
    print '<br/>';
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    input_submit('absenden','Bestellung l�schen');
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}

function verarbeite_formular(  ) {
    global $produkte;
    unset($_SESSION['gespeicherte_bestellung']);
    
    foreach ($produkte as $produkt => $beschreibung) {
        unset($_SESSION["gericht_$produkt"]);
    }
    print 'Ihre Bestellung wurde gel�scht.';
}
?>
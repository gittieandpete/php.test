<?php

session_start(  );

require 'formularhelfer.php';

$produkte = array('gurke'    => 'Gedünstete Seegurke',
                  'magen' => "Sautierter Schweinemagen",
                  'kutteln'   => 'Kutteln in Calvados',
                  'taro'    => 'Geschmortes Schweinefleisch mit Taro',
                  'gaense' => 'Gebackenes Gänseklein mit Salz', 
                  'abalone' => 'Abalone mit Mark und Entenfüßen');

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
    global $produkte;
    
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    if ($fehler) {
        print '<ul><li>';
        print implode('</li><li>',$fehler);
        print '</li></ul>';
    } 
    // Ein Array mit Standardwerten aufbauen, wenn in der Session eine 
    // Bestellung gespeichert ist
    if ($_SESSION['gespeicherte_bestellung']) {
        $standardwerte = array(  );
        foreach ($produkte as $produkt => $beschreibung) {
            $standardwerte["gericht_$produkt"] = $_SESSION["gericht_$produkt"];
        }
    } else {
        $standardwerte = $_POST;
    }
    foreach ($produkte as $produkt => $beschreibung) {
        input_text("gericht_$produkt", $standardwerte);
        print " $beschreibung<br/>";
    }
    
    input_submit('absenden','Bestellen');
    
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}

function validiere_formular(  ) {
    global $produkte;
    $fehler = array(  );
    foreach ($produkte as $produkt => $beschreibung) {
        // Wenn etwas in das Textfeld eingegeben wurde
        if (strlen($_POST["gericht_$produkt"]) &&
            // und keine gültige Ganzzahl ist
            (($_POST["gericht_$produkt"] != strval(intval($_POST["gericht_$produkt"]))) ||
             // oder kleiner als null ist
             intval($_POST["gericht_$produkt"]) < 0)) {
            // dann ist es ein Fehler
            $fehler[  ] = "Geben Sie eine Menge für $beschreibung ein.";
        }
    }
    return $fehler;
}

function verarbeite_formular(  ) {
    global $produkte;
    $_SESSION['gespeicherte_bestellung'] = 1;
    
    foreach ($produkte as $produkt => $beschreibung) {
        if (strlen($_POST["gericht_$produkt"])) {
            $_SESSION["gericht_$produkt"] = $_POST["gericht_$produkt"];
        }
    }
    print 'Vielen Dank für Ihre Bestellung.';
}
?>
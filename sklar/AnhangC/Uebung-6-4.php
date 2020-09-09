<?php
// Die Hilfsfunktionen f�r die Ausgabe von Formularelementen laden
require 'formularhelfer.php';
if ($_POST['_abgeschickt_test']) {
    // Wenn validiere_formular(  ) Fehler liefert, �bergebe sie an zeige_formular(  )
    if ($formularfehler = validiere_formular(  )) {
        zeige_formular($formularfehler);
    } else {
        // Die �bermittelten Formulardaten sind g�ltig, also verarbeite sie
        verarbeite_formular(  );
    }
} else {
    // Kein Formular �bermittelt, also zeige es an
    zeige_formular(  );
}
function zeige_formular($fehler = '') {
    if ($fehler) {
        print 'Bitte beheben Sie die folgenden Fehler: <ul><li>';
        print implode('</li><li>',$fehler);
        print '</li></ul>';
    }
    // Der Anfang des Formulars
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    print '<table>';
    // Die erste Adresse
    print '<tr><th colspan="2">Absender</th></tr>';
    print '<td>Name:</td><td>';
    input_text('name_1', $_POST);
    print '</td></tr>';
    print '<tr><td>Stra�e:</td><td>';
    input_text('adresse_1', $_POST);
    print '</td></tr>';
    print '<tr><td>Stadt, PLZ:</td><td>';
    input_text('stadt_1', $_POST);
    input_text('plz_1', $_POST);
    print '</td></tr>';
    // Die zweite Adresse
    print '<tr><th colspan="2">Empf�nger</th></tr>';
    print '<td>Name:</td><td>';
    input_text('name_2', $_POST);
    print '</td></tr>';
    print '<tr><td>Stra�e:</td><td>';
    input_text('adresse_2', $_POST);
    print '</td></tr>';
    print '<tr><td>Stadt, PLZ:</td><td>';
    input_text('stadt_2', $_POST);
    input_text('plz_2', $_POST);
    print '</td></tr>';
    // Paketinformationen
    print '<tr><th colspan="2">Pakte</th></tr>';
    print '<tr><td>H�he:</td><td>';
    input_text('hoehe',$_POST);
    print '</td></tr>';
    print '<tr><td>Breite:</td><td>';
    input_text('breite',$_POST);
    print '</td></tr>';
    print '<tr><td>L�nge:</td><td>';
    input_text('laenge',$_POST);
    print '</td></tr>';
    print '<tr><td>Gewicht:</td><td>';
    input_text('gewicht',$_POST);
    print '</td></tr>';
    
    // Formularende
    print '<tr><td colspan="2"><input type="submit" value="Paket versenden"></td></tr>';
    print '</table>';
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}      
function validiere_formular(  ) {
    $fehler = array(  );
    // Erste Adresse:
    // Name, Stra�e und Stadt sind erforderlich
    if (! strlen(trim($_POST['name_1']))) {
        $fehler[  ] = 'Geben Sie einen Absendernamen ein';
    }
    if (! strlen(trim($_POST['adresse_1']))) {
        $fehler[  ] = 'Geben Sie die Stra�e des Absenders ein';
    }
    if (! strlen(trim($_POST['stadt_1']))) {
        $fehler[  ] = 'Geben Sie die Stadt des Absenders ein';
    }
    // Die Postleitzahl muss f�nf Stellen haben
    if (!preg_match('/^\d{5}$/', $_POST['plz_1'])) {
        $fehler[  ] = 'Geben Sie eine g�ltige Absender-Postleitzahl ein';
    }
    // Zweite Adresse:
    // Name, Stra�e und Stadt sind erforderlich
    if (! strlen(trim($_POST['name_2']))) {
        $fehler[  ] = 'Geben Sie einen Empf�ngernamen ein';
    }
    if (! strlen(trim($_POST['adresse_2']))) {
        $fehler[  ] = 'Geben Sie die Stra�e des Empf�ngers ein';
    }
    if (! strlen(trim($_POST['stadt_2']))) {
        $fehler[  ] = 'Geben Sie die Stadt des Empf�ngers ein';
    }
    // Die Postleitzahl muss f�nf Stellen haben
    if (!preg_match('/^\d{5}$/', $_POST['plz_2'])) {
        $fehler[  ] = 'Geben Sie eine g�ltige Empf�nger-Postleitzahl ein';
    }
    // Paket:
    // Allen Kantenl�ngen m�ssen <= 100
    if (! strlen($_POST['hoehe'])) {
        $fehler[  ] = 'Geben Sie eine H�he ein.';
    }
    if ($_POST['hoehe'] > 100) {
        $fehler[  ] = 'Die H�he darf nicht mehr als 100 cm betragen.';
    }
    if (! strlen($_POST['laenge'])) {
        $fehler[  ] = 'Geben Sie eine L�nge ein.';
    }
    if ($_POST['laenge'] > 100) {
        $fehler[  ] = 'Die L�nge darf nicht mehr als 100 cm betragen.';
    }
    if (! strlen($_POST['breite'])) {
        $fehler[  ] = 'Geben Sie eine Breite ein.';
    }
    if ($_POST['breite'] > 100) {
        $fehler[  ] = 'Die Breite darf nicht mehr als 100 cm betragen.';
    }
    // Das Gewicht muss <= 75
    if (! strlen($_POST['gewicht'])) {
        $fehler[  ] = 'Geben Sie ein Gewicht ein.';
    }
    if ($_POST['gewicht'] > 75) {
        $fehler[  ] = 'Das Gewicht darf 75 kg nicht �bersteigen.';
    }
    return $fehler;
}
function verarbeite_formular(  ) {
    print 'Dieses Paket wird verschickt von: <br/>';
    print htmlentities($_POST['name_1']) . '<br/>';
    print htmlentities($_POST['adresse_1']) . '<br/>';
    print htmlentities($_POST['stadt_1']) .' '. $_POST['plz_1'] . '<br/>';
    print 'Das Paket wird geschickt an: <br/>';
    print htmlentities($_POST['name_2']) . '<br/>';
    print htmlentities($_POST['adresse_2']) . '<br/>';
    print htmlentities($_POST['stadt_2']) .' '. $_POST['plz_2'] . '<br/>';
    print 'Das Paket ist ' . htmlentities($_POST['laenge']) . 
          ' x' . htmlentities($_POST['breite']) . ' x ' . 
          htmlentities($_POST['hoehe']);
    print ' gro� und wiegt ' . htmlentities($_POST['gewicht']) . ' Kilo.';
}
?>
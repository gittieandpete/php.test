<?php
require 'formularhelfer.php';

// Das entspricht der Funktion input_text(  ) in formularhelfer.php, gibt 
// aber ein Passwortfeld aus (indem Sternchen verbergen, was eingegeben 
// wird) anstelle eines gew�hnlichen Textfelds
function input_password($feldname, $werte) {
    print '<input type="password" name="' . $feldname .'" value="';
    print htmlentities($werte[$feldname]) . '">';
}

session_start(  );

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
    print 'Benutzername: ';
    input_text('benutzername', $_POST);
    print '<br/>';

    print 'Passwort:     ';
    input_password('passwort', $_POST);
    print '<br/>';

    input_submit('absenden','Einloggen');

    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}

function validiere_formular(  ) {
    $fehler = array(  );

    // Einige Beispiele f�r Benutzernamen und Passw�rter
    $benutzer = array('alice'    => 'hund123',
                      'richard'  => 'my^pwd',
                      'karlchen' => '**spass**');
    
    // Sicherstellen, dass der Benutzername g�ltig ist
    if (! array_key_exists($_POST['benutzername'], $benutzer)) {
        $fehler[  ] = 'Bitte geben Sie g�ltigen Benutzernamen und Passwort ein.';
    }
                                   
    // Pr�fen, ob das Passwort korrekt ist
    $gespeichertes_passwort = $benutzer[ $_POST['benutzername'] ];
    if ($gespeichertes_passwort != $_POST['passwort']) {
        $fehler[  ] = 'Bitte geben Sie g�ltigen Benutzernamen und Passwort ein.';
    }

    return $fehler;
}


function verarbeite_formular(  ) {
    // Der Session den Benutzernamen hinzuf�gen
    $_SESSION['benutzername'] = $_POST['benutzername'];

    print "Willkommen $_SESSION[benutzername]";
}
?>
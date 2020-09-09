<?php
require 'formularhelfer.php';

$monate = array(1 => 'Januar', 2 => 'Februar', 3 => 'März', 4 => 'April', 
                5 => 'Mai', 6 => 'Juni', 7 => 'Juli', 8 => 'August',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 
                12 => 'Dezember');

$jahre = array(  );
for ($jahr = date('Y'), $max_jahr = date('Y') + 10; $jahr < $max_jahr; $jahr++) {
    $jahre[$jahr] = $jahr;
}

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
    if ($fehler) {
        print 'Bitte beheben Sie die folgenden Fehler: <ul><li>';
        print implode('</li><li>',$fehler);
        print '</li></ul>';
    }

    print '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '">';

    print 'Verfallsdatum: ';
    input_select('monat',$_POST,$GLOBALS['monate']);
    print ' ';
    input_select('jahr', $_POST,$GLOBALS['jahre']);
    print '<br/>';
    input_submit('absenden','Verfallsdatum prüfen');

    // Die verborgene _abgeschickt_test-Variable am Ende des Formulars
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}

function validiere_formular(  ) {
    $fehler = array(  );
    
    // Prüfen, ob ein gültiger Monat und ein gültiges Jahr eingegeben wurden
    if (! array_key_exists($_POST['monat'], $GLOBALS['monate'])) {
        $fehler[  ] = 'Bitte wählen Sie einen gültigen Monat.';
    }
    if (! array_key_exists($_POST['jahr'], $GLOBALS['jahre'])) {
        $fehler[  ] = 'Bitte wählen Sie ein gültiges Jahr.';
    }
    // Sicherstellen, dass Monat und Jahr dem aktuellen Monat und Jahr
    // oder einem späteren Datum entsprechen
    $aktueller_monat = date('n');
    $aktuelles_jahr  = date('Y');

    if ($_POST['jahr'] < $aktuelles_jahr) {
        // Liegt das Jahr in der Vergangenheit, ist die Kreditkarte
        // abgelaufen
        $fehler[  ] = 'Die Kreditkarte ist abgelaufen.';
        
    } elseif (($_POST['jahr'] == $aktuelles_jahr) &
              ($_POST['monat'] < $aktueller_monat)) {
        // Wenn das Jahr das aktuelle Jahr ist und der eingegebene Monat
        // vor dem aktuellen Monat liegt, ist die Kreditkarte abgelaufen
        $fehler[  ] = 'Die Kreditkarte ist abgelaufen.';
    }

    return $fehler;
}

function verarbeite_formular(  ) {
    print "Sie haben ein gültiges Verfallsdatum eingegeben.";
}
?>
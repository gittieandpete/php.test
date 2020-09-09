<?php
require 'formularhelfer.php';

// Arrays für Monate, Tage, Jahre einrichten
$monate = array(1 => 'Januar', 2 => 'Februar', 3 => 'März', 4 => 'April', 
                5 => 'Mai', 6 => 'Juni', 7 => 'Juli', 8 => 'August',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 
                12 => 'Dezember');

$tage = array(  );

for ($i = 1; $i <= 31; $i++) { $tage[$i] = $i; }
$jahre = array(  );

for ($jahr = date('Y') -1, $max_jahr = date('Y') + 5; $jahr < $max_jahr; $jahr++) {
    $jahre[$jahr] = $jahr;
}

if ($_POST['_abgeschickt_test']) {
    // Wenn validiere_formular(  ) Fehler liefert, übergebe sie an zeige_formular(  )
    if ($formularfehler = validiere_formular(  )) {
        zeige_formular($formularfehler);
    } else {
        // Die übermittelten Formulardaten sind gültig, also verarbeite sie
        verarbeite_formular(  );
    }
} else {
    // Das Formular wurde nicht übermittelt, also zeige es an
    zeige_formular(  );
}

function zeige_formular($fehler = '') {
    global $monate, $tage, $jahre;
    // Wurde das übermittelt, verwende die übermittelten Variablen als Standardwerte
    if ($_POST['_abgeschickt_test']) {
        $standardwerte = $_POST;
    } else {
        // Andernfalls, eigene Standardwerte einrichten: in einem Monat
        $standard_zeitstempel = strtotime('+1 month');
        $standardwerte = array('monat' => date('n', $standard_zeitstempel),
                               'tag'   => date('j', $standard_zeitstempel),
                               'jahr'  => date('Y', $standard_zeitstempel));
        
    }
    // Wurden Fehler übergeben, stecke sie (einschließliche 
    // HTML-Markup) in $fehlertext
    if ($fehler) {
        print 'Bitte beheben Sie die folgenden Fehler: <ul><li>';
        print implode('</li><li>',$fehler);
        print '</li></ul>';
    }
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    print 'Geben Sie ein Datum ein:';
    
    input_select('monat',$standardwerte,$monate);
    print ' ';
    input_select('tag',$standardwerte,$tage);
    print ' ';
    input_select('jahr',$standardwerte,$jahre);
    print '<br/>';
    input_submit('absenden','Dienstage suchen');
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}

function validiere_formular(  ) {
    global $monate, $tage, $jahre;
 
    $fehler = array(  );
   
    if (! array_key_exists($_POST['monat'], $monate)) {
        $fehler[  ] = 'Wählen Sie einen gültigen Monat.';
    }
    if (! array_key_exists($_POST['tag'], $tage)) {
        $fehler[  ] = 'Wählen Sie einen gültigen Tag.';
    }
    if (! array_key_exists($_POST['jahr'], $jahre)) {
        $fehler[  ] = 'Wählen Sie ein gültiges Jahr.';
    }
    // Prüfe, ob das übermittelte Datum in der Zukunft liegt.
    // Suche den Unix-Zeitstempel für Mitternacht des heutigen Tags.
    // Werden die Argumente für Monat, Tag und Jahr weggelassen, 
    // wird der heutige Tag als Standardwert angenommen
    $mitternacht = mktime(0,0,0);
    // Den Unix-Zeitstempel für Mitternacht des übermittelten Tags herausfinden
    $mitternacht_ueberm = mktime(0,0,0,$_POST['monat'], $_POST['tag'],
                                 $_POST['jahr']);
    if ($mitternacht_ueberm <= $mitternacht) {
        $fehler[  ] = 'Geben Sie ein Datum ein, das in der Zukunft liegt.';
    }
                                 
    return $fehler;
}

function verarbeite_formular(  ) {
    // Einen Unix-Zeitstempel für das vom Benutzer eingegebene Datum erzeugen
    $mitternacht_ueberm = mktime(0,0,0,$_POST['monat'], $_POST['tag'],
                                 $_POST['jahr']);
    // Den Unix-Zeitstempel für den nächsten Dienstag (einschließlich 
    // heute, wenn heute Dienstag ist) ermitteln
    $zeitstempel = strtotime('tuesday');
    if ($zeitstempel >= $mitternacht_ueberm) {
        print 'Es gibt keine Dienstage zwischen  ';
        print date('l, j. F Y');
        print ' and ';
        print date('l, j. F Y.', $mitternacht_ueberm);
    } else {
        while ($zeitstempel < $mitternacht_ueberm) {
            // Einen formatierten Datumsstring für $zeitstempel 
            // (einen Dienstag) ausgeben
            print date('l, j. F  Y', $zeitstempel);
            print '<br/>';
            // $zeitstempel eine Woche hinzufügen
            $zeitstempel = strtotime('+1 week', $zeitstempel);
        }
    }
}
?>
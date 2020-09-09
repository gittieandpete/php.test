<?php
require 'formularhelfer.php';

// Die Arrays für die Monate, Tage, Jahre, Stunden und Minuten einrichten
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

$stunden = array(  );
for ($stunde = 1; $stunde <= 24; $stunde++) { $stunden[$stunde] = $stunde; }

$minuten = array(  );
for ($minute = 0; $minute < 60; $minute+=5) {
    $formatierte_minuten = sprintf('%02d', $minute);
    $minuten[$formatierte_minuten] = $formatierte_minuten;
}

if ($_POST['_abgeschickt_test']) {
    // Wenn validiere_formular(  ) Fehler meldet, übergebe Sie an zeige_formular(  )
    if ($formularfehler = validiere_formular(  )) {
        zeige_formular($formularfehler);
    } else {
        // Die übermittelten Daten sind gültig, also verarbeite sie
        verarbeite_formular(  );
    }
} else {
    // Das Formular wurde nicht übermittelt, also zeige es an
    zeige_formular(  );
}

function zeige_formular($fehler = '') {
    global $stunden, $minuten, $monate, $tage, $jahre;

    // Wenn das Formular übermittelt wurde, verwende die übermittelten 
    // Werte als Standardwerte
    if ($_POST['_abgeschick_test']) {
        $defaults = $_POST;
    } else {
        // Andernfalls, eigene Standardwerte einrichten: die aktuellen 
        // Zeit- und Datumsteile
        $standardwerte = array('stunde' => date('G'),
                               'monat'  => date('n'),
                               'tag'    => date('j'),
                               'jahr'   => date('Y'));
        
        // Weil die Wahlmöglichkeiten im Minuten-Menü in 5-Minuten-Schritten 
        // sind müssen wir die aktuelle Minute zu einem Vielfachen von 
        // machen, wenn sie das nicht ist
        $aktuelle_minute = date('i');
        $minute_mod_fuenf = $aktuelle_minute % 5;
        if ($minute_mod_fuenf != 0) { $aktuelle_minute -= $minute_mod_fuenf;  }
        $standardwerte['minute'] = sprintf('%02d', $aktuelle_minute);
    }

    // Wenn Fehler übergeben wurden, gebe Sie (mit HTML-Markup) aus###Original: put them in $error_text, aber der Code sagt was anderes###
    if ($fehler) {
        print 'Bitte beheben Sie die folgenden Fehler: <ul><li>';
        print implode('</li><li>',$fehler);
        print '</li></ul>';
    }

    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    print 'Geben Sie ein Datum und eine Uhrzeit ein:';
    
    input_select('stunde',$standardwerte,$stunden);
    print ':';
    input_select('minute',$standardwerte,$minuten);
    input_select('monat',$standardwerte,$monate);
    print ' ';
    input_select('tag',$standardwerte,$tage);
    print ' ';
    input_select('jahr',$standardwerte,$jahre);
    print '<br/>';
    input_submit('absenden','Treffen suchen');
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}

function validiere_formular(  ) {
    global $stunden, $minuten, $monate, $tage, $jahre;
 
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
    if (! array_key_exists($_POST['stunde'], $stunden)) {
        $fehler[  ] = 'Wählen Sie eine gültige Stunde.';
    }
    if (! array_key_exists($_POST['minute'], $minuten)) {
        $fehler[  ] = 'Wählen Sie eine gültige Minute.';
    }

    return $fehler;
}

function verarbeite_formular(  ) {
    
    // Wandle das vom Benutzer eingegebene Datum in einen Unix-Zeitstempel um
    $zeitstempel = mktime($_POST['stunde'], $_POST['minute'], 0,
                        $_POST['monat'], $_POST['tag'], $_POST['jahr']);


    // Herausfinden, ob das nächste NYPHP-Treffen nach dem eingegebenen Datum liegt:
    // Wenn $zeitstempel am oder vor dem vierten Donnerstag des Monats liegt, dann 
    // verwende das Datum des NYPHP-Treffens für den Monat von $zeitstempel, 
    // andernfalls verwende das Datum für das NYPHP-Treffen im kommenden Monat

    // Mitternacht an dem Tag, den der Benutzer eingegeben hat
    $mitternacht  = mktime(0,0,0, $_POST['monat'], $_POST['tag'], $_POST['jahr']);
    // Mitternacht am Ersten des Monats, den der Benutzer eingegeben hat
    $monatserster = mktime(0,0,0,$_POST['monat'],1,$_POST['jahr']);
    // Mitternacht des vierten Donnerstag des Monats, den der Benutzer eingegeben hat
    $monat_nyphp = strtotime('fourth thursday',$monatserster);
    
    if ($mitternacht < $monat_nyphp) {
        // Das Datum, das der Benutzer eingegeben hat, liegt vor dem Tag des Treffens
        print "NYPHP-Treffen diesen Monat: ";
        print date('l, j. F Y', $monat_nyphp);
    } elseif ($mitternacht == $monat_nyphp) {
        // Das vom Benutzer eingegebene Datum ist ein Treffen-Tag
        print "NYPHP-Treffen ist heute. ";
        $treffen_anfang = strtotime('6:30pm', $monat_nyphp);
        // Wenn es nach 18:30 ist, melden, dass das Treffen bereits begonnen hat
        if ($zeitstempel > $treffen_anfang) {
            print "Das Treffen begann um 18:30, aber Sie haben ";
            print date('G:i', $timestamp);
            print " eingegeben.";
        }
    } else {
        // Das vom Benutzer eingegebene Datum liegt nach dem Tag des Treffens,
        // also suche den Tag des Treffens im nächsten Monat
        $erster_naechster_monat = mktime(0,0,0,$_POST['monat'] + 1,1,$_POST['jahr']);
        $naechster_monat_nyphp = strtotime('fourth thursday',$erster_naechster_monat);
        print "NYPHP-Treffen im nächsten Monat: ";
        print date('l, j. F Y', $naechster_monat_nyphp);
    }
}
?>
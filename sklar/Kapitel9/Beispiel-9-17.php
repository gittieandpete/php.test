<?php
// Verwende die Hilfsfunktionen für Formulare, die in Kapitel 6 definiert wurden
require 'formularhelfer.php';

$monate = array(1 => 'Januar',
    2 => 'Februar',
    3 => 'März',
    4 => 'April',
    5 => 'Mai',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'August',
        9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Dezember');

$jahre = array(  );
for ($jahr = date('Y') - 1, $max_jahr = date('Y') + 5; $jahr < $max_jahr; $jahr++) {
    $jahre[$jahr] = $jahr;
}

if ($_POST['_abgeschickt_test']) {
    if ($fehler = validiere_formular(  )) {
        zeige_formular($errors);
    } else {
        zeige_formular(  );
        verarbeite_formular(  );
    }
} else {
    // Wurde das Formular nicht übermittelt, zeige das Formular und dann
    // einen Kalender für den aktuellen Monat an
    zeige_formular(  );
    zeige_kalender(date('n'), date('Y'));
}

function validiere_formular(  ) {
    global $monate, $jahre;
    $fehler = array(  );

    if (! array_key_exists($_POST['monat'], $monate)) {
        $errors[  ] = 'Wählen Sie einen gültigen Monat.';
    }

    if (! array_key_exists($_POST['jahr'], $jahre)) {
        $errors[  ] = 'Wählen Sie ein gültiges Jahr.';
    }

    return $fehler;
}

function zeige_formular($fehler = '') {
    global $monate, $jahre, $aktuelles_jahr;

    // Wenn das Formular übermittelt wurde, lese die Standardwerte aus den
    // übermittelten Variablen
    if ($_POST['_abgeschickt_test']) {
        $standardwerte = $_POST;
    } else {
        // Andernfalls setze eigene Standardwerte: aktuellen Monat und Jahr
        $standardwerte = array('jahr' => date('Y'),
                               'monat' => date('n'));
    }


    if ($fehler) {
        print 'Bitte beheben Sie die folgenden Fehler: <ul><li>';
        print implode('</li><li>',$fehler);
        print '</li></ul>';
    }

    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    input_select('monat', $standardwerte, $monate);
    input_select('jahr',  $standardwerte, $jahre);
    input_submit('absenden','Kalender anzeigen');
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}

function verarbeite_formular(  ) {
    zeige_kalender($_POST['monat'], $_POST['jahr']);
}

function zeige_kalender($monat, $jahr) {
    global $monate;
    $wochentage = array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa');

    // Ermittle den Unix-Zeitstempel für Mitternacht am Monatsersten
    $erster_tag = mktime(0,0,0,$monat, 1, $jahr);
    // Wie viele Tage hat der Monat?
    $tage_im_monat = date('t', $erster_tag);
    // Welcher Wochentag (numerisch) ist der erste Tag des Monats, den benötigen
    // wir, um die erste Tabellenzelle an die richtige Stelle zu setzen
    $tag_verschiebung = date('w', $erster_tag) ;

    // Den Anfang der Tabelle und die Zeile mit den Namen der Wochentage ausgeben
    print<<<_HTML_
<table border="0" cellspacing="0" cellpadding="2">
<tr><th colspan="7">$monate[$monat] $jahr</th></tr>
<tr><td align="center">
_HTML_;
    print implode('</td><td align="center">', $wochentage);
    print '</td></tr>';


    // Wenn der erste Tag des Monats z.B. Dienstag ist, dann müssen Sie in
    // der ersten Zeile unter "So" und "Mo" leere Zellen einfügen, damit
    // die Tabellenzelle für den ersten Tag unter "Di" steht
    if ($tag_verschiebung > 0) {
        for ($i = 0; $i < $tag_verschiebung; $i++) { print '<td>&nbsp;</td>'; }
    }

    // Eine Tabellenzelle für jeden Monatstag ausgeben
    for ($tag = 1; $tag <= $tage_im_monat; $tag++ ) {
        print '<td align="center">' . $tag . '</td>';
        $tag_verschiebung++;
        // Wenn diese Zelle die siebte der Zeile war, beende die
        // Tabellenzeile und setzte $tages_verschiebung zurück
        if ($tag_verschiebung == 7) {
            $tag_verschiebung = 0;
            print "</tr>\n";
            // Wenn noch weitere Tage folgen, beginne
            // eine neue Tabellenzeile
            if ($tag < $tage_im_monat) {
                print '<tr>';
            }
        }
    }

    // An diesem Punkt wurde für jeden Tag des Monats eine Tabellenzelle
    // ausgegeben. Wenn der letzte Tag des Monats kein Samstag ist, muss
    // die letzte Zeile der Tabelle bis zum Ende der Zeile mit einigen
    // leeren Zellen aufgefüllt werden
    if ($tag_verschiebung > 0) {
        for ($i = $tag_verschiebung; $i < 7; $i++) {
            print '<td>&nbsp;</td>';
        }
        print '</tr>';
    }
    print '</table>';
}
?>

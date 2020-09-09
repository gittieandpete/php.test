<?php
// Die Hilfsfunktionen für Formularelemente laden
require 'formularhelfer.php';

if ($_POST['_abgeschickt_test']) {
    // Wenn validiere_formular(  ) Fehler liefert, übergebe sie an zeige_formular(  )
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
    if ($fehler) {
        print 'Bitte beheben Sie die folgenden Fehler: <ul><li>';
        print implode('</li><li>',$fehler);
        print '</li></ul>';
    }
    // Der Anfang des Formulars
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    // Der Dateiname
    print' Dateiname: ';
    input_text('dateiname', $_POST);
    print '<br/>';
    // Der Absenden-Button
    input_submit('absenden','Datei anzeigen');
    // Die verborgene Variable _abgeschickt_test
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    // Das Ende des Formulars
    print '</form>';
}

function validiere_formular(  ) {
    $fehler = array(  );
    // Der Dateiname ist erforderlich
    if (! strlen(trim($_POST['dateiname']))) {
        $fehler[  ] = 'Geben Sie einen Dateinamen ein.';
    } else {
        // Aus dem Dokument-Wurzelverzeichnis des Webservers, einem 
        // Schrägstrich und dem übermittelten Wert den vollständigen 
        // Dateinamen aufbauen
        $dateiname = $_SERVER['DOCUMENT_ROOT'] . '/' . $_POST['dateiname'];
        
        // realpath verwenden, um eventuelle ..-Sequenzen aufzulösen
        $dateiname = realpath($dateiname);
        
        // Prüfen, ob der $dateiname mit dem Dokument-Wurzel-
        // verzeichnis beginnt
        $dokwurzel_laenge = strlen($_SERVER['DOCUMENT_ROOT']);
        // Hier ist die Anwendung von realpath() erforderlich, damit der
        // Vergleich auch unter Windows funktioniert
        $dokwurzel = realpath($_SERVER['DOCUMENT_ROOT']);
        if (substr($dateiname, 0, $dokwurzel_laenge) != $dokwurzel) {
            $fehler[  ] = 'Die Datei muss sich unterhalb des Dokument-Wurzelverzeichnisses befinden.';
        }
    }
    return $fehler;
}

function verarbeite_formular(  ) {
    // Wie in validiere_formular(  ) den vollständigen Dateinamen herstellen
    $dateiname = $_SERVER['DOCUMENT_ROOT'] . '/' . $_POST['dateiname'];
    $dateiname = realpath($dateiname);
    // Den Inhalt der Datei ausgeben
    print file_get_contents($dateiname);
}
?>
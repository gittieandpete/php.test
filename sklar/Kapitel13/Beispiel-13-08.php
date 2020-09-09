if ($_POST['_abgeschickt_test']) {
    // Wenn validiere_formular(  ) Fehler liefert, übergeben Sie an zeige_formular(  )
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

    print<<<_HTML_
<form enctype="multipart/form-data" method="POST"
      action="$_SERVER[PHP_SELF]">

Heraufzuladende Datei: <input name="meine_datei" type="file"/>

<input type="hidden" name="MAX_FILE_SIZE" value="131072"/>
<input type="hidden" name="_abgeschickt_test" value="1">
<input type="submit" value="Heraufladen"/>
</form>
_HTML_;
}

function validiere_formular(  ) {
    $fehler = array(  );

    if (($_FILES['meine_datei']['fehler'] == UPLOAD_ERR_INI_SIZE)||
        ($_FILES['meine_datei']['fehler'] == UPLOAD_ERR_FORM_SIZE)) {
        $fehler[  ] = 'Heraufgeladene Datei ist zu groß.';
    } elseif ($_FILES['meine_datei']['fehler'] == UPLOAD_ERR_PARTIAL) {
        $fehler[  ] = 'Heraufladen der Datei wurde unterbrochen.';
    } elseif ($_FILES['meine_datei']['fehler'] == UPLOAD_ERR_NO_FILE) {
        $fehler[  ] = 'Keine Datei heraufgeladen.';
    }
    
    return $fehler;
}

function verarbeite_formular(  ) {
    print "Sie haben eine Datei namens {$_FILES['meine_datei']['name']} ";
    print "des Typs {$_FILES['meine_datei']['type']} heraufgeladen, die  ";
    print "{$_FILES['meine_datei']['size']} groß ist.";

    $sicherer_dateiname = str_replace('/', '', $_FILES['meine_datei']['name']);
    $sicherer_dateiname = str_replace('..', '', $sicherer_dateiname);

    $zieldatei = '/usr/local/uploads/' . $sicherer_dateiname;
    if (move_uploaded_file($_FILES['meine_datei']['tmp_name'], $zieldatei)) {
        print "Datei erfolgreich als $zieldatei gespeichert.";
    } else {
        print "Konnte Datei nicht in /usr/local/uploads speichern.";
    }
}

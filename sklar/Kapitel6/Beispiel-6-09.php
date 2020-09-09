<?php
// Die auf den übermittelten Formularparametern basierende 
// Logik für die Entscheidung
if ($_POST['_abgeschickt_test']) {
    // Wenn validiere_formular(  ) Fehler zurückliefert, übergebe sie an zeige_formular(  )
    if ($formularfehler = validiere_formular(  )) {
        zeige_formular($formularfehler);
    } else {
        verarbeite_formular(  );
    }
} else {
    zeige_formular(  );
}

// Tu das, wenn das Formular abgeschickt wurde
function verarbeite_formular(  ) {
    print "Hallo ". $_POST['mein_name'];
}

// Zeige das Formular an
function zeige_formular($fehler = '') {
    // Wenn Fehler übergeben wurden, gebe sie aus
    if ($fehler) {
        print 'Bitte beheben Sie diese Fehler: <ul><li>';
        print implode('</li><li>', $fehler);
        print '</li></ul>';
    }

    print<<<_HTML_
<form method="POST" action="$_SERVER[PHP_SELF]">
Ihr Name: <input type="text" name="mein_name">
<br/>
<input type="submit" value="Sag hallo">
<input type="hidden" name="_abgeschickt_test" value="1">
</form>
_HTML_;
}

// Die Formulardaten prüfen
function validiere_formular(  ) {
    // Beginne mit einem leeren Array für Fehlermeldungen
    $fehler = array(  );

    // Füge eine Fehlermeldung hinzu, wenn der Name zu kurz ist
    if (strlen($_POST['mein_name']) < 3) {
        $fehler[  ] = 'Ihr Name muss mindestens drei Zeichen lang sein.';
    }

    // Liefer das (möglicherweise leere) Array mit Fehlermeldungen zurück
    return $fehler;
}
?>
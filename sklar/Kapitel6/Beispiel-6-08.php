<?php
// Die auf den übermittelten Formularparametern basierende 
// Logik für die Entscheidung
if ($_POST['_abgeschickt_test']) {
    if (validiere_formular(  )) {
        verarbeite_formular(  );
    } else {
        zeige_formular(  );
    }
} else {
    zeige_formular(  );
}

// Tu das, wenn das Formular abgeschickt wurde
function verarbeite_formular(  ) {
    print "Hallo ". $_POST['mein_name'];
}

// Zeige das Formular an
function zeige_formular(  ) {
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
    // Ist mein_name mindestens 3 Zeichen lang?
    if (strlen($_POST['mein_name']) < 3) {
        return false;
    } else {
        return true;
    }
}
?>
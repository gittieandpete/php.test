<?php
// Die auf den übermittelten Formularparametern basierende 
// Logik für die Entscheidung
if (array_key_exists('mein_name',$_POST)) {
    verarbeite_formular(  );
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
</form>
_HTML_;
}
?>
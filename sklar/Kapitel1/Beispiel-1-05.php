<?php
// Eine Begr��ung ausgeben, wenn das Formular abgeschickt wurde
if ($_POST['benutzer']) {
    print "Hallo ";
    // Den �ber den Formularparameter 'benutzer' �bergebenen Wert ausgeben
    print $_POST['benutzer'];
    print "!";
} else {
    // Andernfalls das Formular ausgeben
    print <<<_HTML_
<form method="post" action="$_SERVER[PHP_SELF]">
Ihr Name: <input type="text" name="benutzer">
<br/>
<input type="submit" value="Sag hallo">
</form>
_HTML_;
}
?>

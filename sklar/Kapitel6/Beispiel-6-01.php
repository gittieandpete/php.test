<?php
if (array_key_exists('mein_name',$_POST)) {
    print "Hallo ". $_POST['mein_name'];
} else {
    print<<<_HTML_
<form method="post" action="$_SERVER[PHP_SELF]">
 Ihr Name: <input type="text" name="mein_name">
<br/>###die Zeile würde ich löschen, sonst erhält man nicht das, was in Abbildung 6-2 zu sehen ist, und das, was man dort sieht ist schöner, als das, was man so sieht###
<input type="submit" value="Sag hallo">
</form>
_HTML_;
}
?>
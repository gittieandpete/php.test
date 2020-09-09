<?php
print <<<_HTML_
<form method="post" action="$_SERVER[PHP_SELF]">
Ihr Name: <input type="text" name="benutzer">
<br/>
<input type="submit" value="Sag hallo">
</form>
_HTML_;
?>

<?php
$titel = "Fehlerseite";
$menuitem = '';

require '../../../files/php/login_web330.php';
require '../includes/definitions.php';
require '../includes/functions.php';
connect ();
session_start();
require '../includes/uebunghead.php';
require '../includes/uebungkopf.php';
require '../includes/uebungnavi.php';

print "<h1>$titel</h1>";
?>


<h1>Diese Seite wurde nicht gefunden</h1>

<p>
Diese Datei ist auf diesem Server nicht vorhanden. Irgendwas ist schief gelaufen...
</p>
<p>
Der Server konnte die Datei nicht finden, die Sie angefordert haben. Es kann sein, dass Sie sich bei der Eingabe der Adresse verschrieben haben. Möglich wäre auch, dass das Dokument nicht mehr existiert, der Name geändert wurde oder dass es an einer anderen Stelle steht.
</p>


<?php
require '../includes/uebungfooter.php';
?>

<?php
$titel = "Teste Regex-Ausdrücke";
$menuitem = '';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php';

print "<h1>$titel</h1>";
?>


<?php

// Text zum Testen eingeben:
$text = 'ab, abc, cba, ba, a, b, bla bla bla aa aa aa';
// soll die Buchstabenfolge ab oder ba treffen
preg_match_all('@ab|ba@',$text,$treffer);

print '<pre>';
print_r($treffer);
print '</pre>';

?>



<?php
require 'includes/uebungfooter.php';
?>

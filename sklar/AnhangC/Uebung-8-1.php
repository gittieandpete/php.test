<?php
$seitenzaehler = $_COOKIE['seitenzaehler'] + 1;
setcookie('seitenzaehler',$seitenzaehler);
print "Anzahl der Besuche: $seitenzaehler";
?>
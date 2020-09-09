<?php
setlocale(LC_TIME, 'ge');
// Den Unix-Zeitstempel für den 1. November 2008 ermitteln
$november = mktime(0,0,0,11,1,2008);
// Den ersten Montag auf oder nach dem 1. November 2008 ermitteln
$montag = strtotime('Monday', $november);
// Einen Tag zum Dienstag nach dem ersten Montag vorspringen
$wahltag = strtotime('+1 day', $montag);

print strftime('Der Wahltag ist %A, der %d. %B %Y', $wahltag);
?>
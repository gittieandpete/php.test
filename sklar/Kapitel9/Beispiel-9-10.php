<?php
require 'formularhelfer.php';

setlocale(LC_TIME, 'ge');

$mitternacht_heute = mktime(0,0,0);
$optionen = array(  );
for ($i = 0; $i < 7; $i++) {
    $zeitstempel = strtotime("+$i day", $mitternacht_heute);
    $angezeigtes_datum = strftime('%A, %d. %B %Y', $zeitstempel);
    $optionen[$zeitstempel] = $angezeigtes_datum;
}
input_select('datum', $_POST, $optionen);

?>
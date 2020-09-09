<?php
setlocale(LC_TIME, 'ge');
$mitternacht_heute = mktime(0,0,0);
print '<select name="datum">';
for ($i = 0; $i < 7; $i++) {
    $zeitstempel = strtotime("+$i day", $mitternacht_heute);
    $angezeigtes_datum = strftime('%A, %d. %B %Y', $zeitstempel);
    print '<option value="' . $zeitstempel .'">'.$angezeigtes_datum."</option>\n";
}
print "\n</select>";
?>
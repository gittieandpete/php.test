<?php
$zeilenfarbe = array('red','green');
$farbindex = 0;
$mahlzeit = array('Fr¸hst¸ck' => 'Walnuss-Weckchen',
                 'Mittagessen' => 'Cashew-N¸sse mit Champignons',
                 'Snack' => 'Getrocknete Maulbeeren',
                 'Abendessen' => 'Aubergine mit Chili-Soﬂe');
print "<table>\n";
foreach ($mahlzeit as $schluessel => $wert) {
    print '<tr bgcolor="' . $zeilenfarbe[$farbindex] . '">';
    print "<td>$schluessel</td><td>$wert</td></tr>\n";
    // Damit wird $farbindex zwischen 0 und 1 hin- und hergeschaltet
    $farbindex = 1 - $farbindex;
}
print '</table>';
?>
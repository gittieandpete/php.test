<?php
$mahlzeit = array('Fr�hst�ck' => 'Walnuss-Weckchen',
                 'Mittagessen' => 'Cashew-N�sse mit Champignons',
                 'Snack' => 'Getrocknete Maulbeeren',
                 'Abendessen' => 'Aubergine mit Chili-So�e');
print "<table>\n";
foreach ($mahlzeit as $schluessel => $wert) {
    print "<tr><td>$schluessel</td><td>$wert</td></tr>\n";
}
print '</table>';
?>
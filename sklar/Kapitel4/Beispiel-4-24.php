<?php
$mahlzeit = array('Fr�hst�ck' => 'Walnuss-Weckchen',
                 'Mittagessen' => 'Cashew-N�sse und Champignons',
                 'Snack' => 'Getrocknete Maulbeeren',
                 'Abendessen' => 'Aubergine mit Chili-So�e');

print "Vor dem Sortieren:\n";
foreach ($mahlzeit as $schluessel => $wert) {
    print "   \$mahlzeit: $schluessel $wert\n";
}

asort($mahlzeit);

print "Nach dem Sortieren:\n";
foreach ($mahlzeit as $schluessel => $wert) {
    print "   \$mahlzeit: $schluessel $wert\n";
}
?>
<?php
$mahlzeit = array('Frühstück' => 'Walnuss-Weckchen',
                 'Mittagessen' => 'Cashew-Nüsse und Champignons',
                 'Snack' => 'Getrocknete Maulbeeren',
                 'Abendessen' => 'Aubergine mit Chili-Soße');

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
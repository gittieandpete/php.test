<?php
$abendessen = array('Mais und Spargel',
                    'Zitronen-Huhn',
                    'Gedünstete Bambuspilze');
$mahlzeit = array('Frühstück' => 'Walnuss-Weckchen',
                 'Mittagessen' => 'Cashew-Nüsse und Champignons',
                 'Snack' => 'Getrocknete Maulbeeren',
                 'Abendessen' => 'Aubergine mit Chili-Soße');

print "Vor dem Sortieren:\n";
foreach ($abendessen as $schluessel => $wert) {
    print " \$abendessen: $schluessel $wert\n";
}
foreach ($mahlzeit as $schluessel => $wert) {
    print "    \$mahlzeit: $schluessel $wert\n";
}

sort($abendessen);
sort($mahlzeit);

print "Nach dem Sortieren:\n";
foreach ($abendessen as $schluessel => $wert) {
    print " \$abendessen: $schluessel $wert\n";
}
foreach ($mahlzeit as $schluessel => $wert) {
    print "    \$mahlzeit: $schluessel $wert\n";
}
?>
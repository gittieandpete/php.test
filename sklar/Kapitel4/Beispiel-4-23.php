<?php
$abendessen = array('Mais und Spargel',
                    'Zitronen-Huhn',
                    'Ged�nstete Bambuspilze');
$mahlzeit = array('Fr�hst�ck' => 'Walnuss-Weckchen',
                 'Mittagessen' => 'Cashew-N�sse und Champignons',
                 'Snack' => 'Getrocknete Maulbeeren',
                 'Abendessen' => 'Aubergine mit Chili-So�e');

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
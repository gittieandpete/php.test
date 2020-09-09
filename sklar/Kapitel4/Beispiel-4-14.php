<?php
$mahlzeiten = array('Walnuss-Weckchen' => 1,
                   'Cashew-Nüsse und Champignons' => 4.95,
                   'Getrocknete Maulbeeren' => 3.00,
                   'Aubergine mit Chili-Soße' => 6.50,
                   'Garnelenbällchen' => 0); // Garnelenbällchen sind kostenlos!
$buecher = array('Gourmet-Handbuch für Chinesische Zeichen',
                 'Chinesisch kochen und essen');

// Das ist true
if (array_key_exists('Garnelenbällchen',$mahlzeiten)) {
    print "Ja, es gibt Garnelenbällchen";
}
// Das ist false
if (array_key_exists('Steak-Sandwich',$mahlzeiten)) {
    print "Wir haben Steak-Sandwich";
}
// Das ist true
if (array_key_exists(1, $buecher)) {
    print "Element 1 ist Chinesisch kochen und essen";
}
?>
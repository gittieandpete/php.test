<?php
$mahlzeiten = array('Walnuss-Weckchen' => 1,
                   'Cashew-N�sse und Champignons' => 4.95,
                   'Getrocknete Maulbeeren' => 3.00,
                   'Aubergine mit Chili-So�e' => 6.50,
                   'Garnelenb�llchen' => 0); // Garnelenb�llchen sind kostenlos!
$buecher = array('Gourmet-Handbuch f�r Chinesische Zeichen',
                 'Chinesisch kochen und essen');

// Das ist true
if (array_key_exists('Garnelenb�llchen',$mahlzeiten)) {
    print "Ja, es gibt Garnelenb�llchen";
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
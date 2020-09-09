<?php
$mahlzeiten = array('Walnuss-Weckchen' => 1,
                   'Cashew-Nüsse und Champignons' => 4.95,
                   'Getrocknete Maulbeeren' => 3.00,
                   'Aubergine mit Chili-Soße' => 6.50,
                   'Garnelenbällchen' => 0); 

$gericht = array_search(6.50, $mahlzeiten);
if ($gericht) {
    print "$gericht kostet 6,50 EUR";
}
?>
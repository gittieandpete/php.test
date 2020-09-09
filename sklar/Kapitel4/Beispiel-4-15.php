<?php
$mahlzeiten = array('Walnuss-Weckchen' => 1,
                   'Cashew-Nüsse und Champignons' => 4.95,
                   'Getrocknete Maulbeeren' => 3.00,
                   'Aubergine mit Chili-Soße' => 6.50,
                   'Garnelenbällchen' => 0); 
$buecher = array("Gourmet-Handbuch für Chinesische Zeichen",
                 'Chinesisch kochen und essen');

// Das ist true: Der Schlüssel Getrocknete Maulbeeren hat den Wert 3.00 
if (in_array(3, $mahlzeiten)) {
  print 'Es gibt ein Element für 3 EUR.';
}
// Das ist true
if (in_array('Chinesisch kochen und essen', $buecher)) {
  print "Wir haben Chinesisch kochen und essen";
}
// Das ist false: in_array() berücksichtigt Groß-/Kleinschreibung
if (in_array("gourmet-handbuch für chinesische zeichen", $buecher)) {
  print "Wir haben Gourmet-Handbuch für Chinesische Zeichen.";
}
?>
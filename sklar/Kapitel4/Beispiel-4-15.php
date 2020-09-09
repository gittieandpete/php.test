<?php
$mahlzeiten = array('Walnuss-Weckchen' => 1,
                   'Cashew-N�sse und Champignons' => 4.95,
                   'Getrocknete Maulbeeren' => 3.00,
                   'Aubergine mit Chili-So�e' => 6.50,
                   'Garnelenb�llchen' => 0); 
$buecher = array("Gourmet-Handbuch f�r Chinesische Zeichen",
                 'Chinesisch kochen und essen');

// Das ist true: Der Schl�ssel Getrocknete Maulbeeren hat den Wert 3.00 
if (in_array(3, $mahlzeiten)) {
  print 'Es gibt ein Element f�r 3 EUR.';
}
// Das ist true
if (in_array('Chinesisch kochen und essen', $buecher)) {
  print "Wir haben Chinesisch kochen und essen";
}
// Das ist false: in_array() ber�cksichtigt Gro�-/Kleinschreibung
if (in_array("gourmet-handbuch f�r chinesische zeichen", $buecher)) {
  print "Wir haben Gourmet-Handbuch f�r Chinesische Zeichen.";
}
?>
<?php
$abendessen = array('Mais und Spargel',
                    'Zitronen-Huhn',
                    'GedŁnstete Bambuspilze');
for ($i = 0, $anzahl_gerichte = count($abendessen); $i < $anzahl_gerichte; $i++) {
  print "Gericht Nummer $i ist $abendessen[$i]\n";
}
?>
<?php
$spezialitaeten = array( array('Haselnuss-Weckchen', 'Walnuss-Weckchen', 'Erdnuss-Weckchen'),
                         array('Haselnuss-Salat','Walnuss-Salat', 'Erdnuss-Salat') );

// $anzahl_spezialitaeten ist gleich 2: D.h. die Anzahl der Elemente in der 
// ersten Dimension von $spezialitaeten
for ($i = 0, $anzahl_spezialitaeten = count($spezialitaeten); $i < $anzahl_spezialitaeten; $i++) {
    // $anzahl_els ist gleich 3: D. h. die Anzahl von Elementen in den einzelnen Unter-Arrays
    for ($m = 0, $anzahl_els = count($spezialitaeten[$i]); $m < $anzahl_els; $m++) {
        print "Element [$i][$m] ist " . $spezialitaeten[$i][$m] . "\n";
    }
}
?>
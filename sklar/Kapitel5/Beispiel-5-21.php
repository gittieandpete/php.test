<?php
$abendessen = 'Curry-Tintenfisch';

function macrobiotisches_abendessen() {
    $abendessen = "Etwas Gem�se";
    print "Abendessen ist $abendessen";
    // Den K�stlichkeiten des Meeres verfallen
    print ", aber ich h�tte lieber ";
    print $GLOBALS['abendessen'];
    print "\n";
}
        
macrobiotisches_abendessen();
print "Das normale Abendessen ist: $abendessen";
?>
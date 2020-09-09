<?php
$abendessen = 'Curry-Tintenfisch';

function macrobiotisches_abendessen() {
    $abendessen = "Etwas Gemüse";
    print "Abendessen ist $abendessen";
    // Den Köstlichkeiten des Meeres verfallen
    print ", aber ich hätte lieber ";
    print $GLOBALS['abendessen'];
    print "\n";
}
        
macrobiotisches_abendessen();
print "Das normale Abendessen ist: $abendessen";
?>
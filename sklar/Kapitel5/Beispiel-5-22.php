<?php
$abendessen = 'Curry-Tintenfisch';

function hungriges_abendessen() {
    $GLOBALS['abendessen'] .= ' und tiefgefrorene Taro';
}

print "Das normale Abendessen ist $abendessen";
print "\n";
hungriges_abendessen();
print "Das Abendessen für Hungrige ist $abendessen";
?>
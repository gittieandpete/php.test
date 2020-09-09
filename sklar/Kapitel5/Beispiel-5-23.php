<?php
$abendessen = 'Curry-Tintenfisch';

function vegetarisches_abendessen() {
    global $abendessen;
    print "Abendessen war $abendessen, aber jetzt ist es ";
    $abendessen = 'Sautierte Zuckerschoten'; 
    print $abendessen;
    print "\n";
}

print "Das normale Abendessen ist $abendessen.\n";
vegetarisches_abendessen();
print "Das normale Abendessen ist $abendessen";
?>
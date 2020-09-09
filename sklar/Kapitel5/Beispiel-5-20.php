<?php
$abendessen = 'Curry-Tintenfisch';

function vegetarisches_abendessen() {
    print "Abendessen ist $abendessen oder ";
    $abendessen = 'Sautierte Zuckerschoten'; 
    print $abendessen;
    print "\n";
}

function koscheres_abendessen() {
    print "Abendesesen ist $abendessen oder ";
    $abendessen = 'Kung Pao-Huhn';
    print $abendessen;
    print "\n";
}

print "Vegetarisches ";
vegetarisches_abendessen();
print "Koscheres ";
koscheres_abendessen();
print "Das normale Abendessen ist $abendessen";
?>
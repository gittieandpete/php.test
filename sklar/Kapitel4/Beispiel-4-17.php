<?php
$gerichte['Rindfleisch Chow Foon'] = 12;
$gerichte['Rindfleisch Chow Foon']++;
$gerichte['Gebackene Ente'] = 3;

$gerichte['total'] = $gerichte['Rindfleisch Chow Foon'] + $gerichte['Gebackene Ente'];

if ($gerichte['total']> 15) {
    print "Sie haben viel gegessen: ";
}

print 'Sie haben ' . $gerichte['Rindfleisch Chow Foon'] . ' Teller Rindfleisch Chow Foon gegessen.';
?>
<?php
$hamburger = 4.95;
$milchshake = 1.95;
$cola = .85;
$essen = 2 * $hamburger + $milchshake + $cola;
$steuer = $essen * .16;
$trinkgeld = $essen * .10;
$gesamt = $essen + $steuer + $trinkgeld;
print "Der Gesamtpreis der Malzeit ist $gesamt EUR";
?>
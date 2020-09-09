<?php
$hamburger = 4.95;
$milchshake = 1.95;
$cola = .85;
$essen = 2 * $hamburger + $milchshake + $cola;
$steuer = $essen * .16;
$trinkgeld = $essen * .10;

printf("%1d %9s zu jeweils %.2f EUR: %.2f EUR\n", 2, 'Hamburger', $hamburger, 2 * $hamburger);
printf("%1d %9s zu jeweils %.2f EUR: %.2f EUR\n", 1, 'Milchshake', $milchshake, $milchshake);
printf("%1d %9s zu jeweils %.2f EUR: %.2f EUR\n", 1, 'Cola', $cola, $cola);
printf("%25s: %.2f\n EUR", 'Essen und Getränke insgesamt', $essen);
printf("%25s: %.2f EUR\n", 'Gesamt mit Steuern', $essen + $steuer);
printf("%25s: %.2f EUR\n", 'Gesamt mit Steuern und Trinkgeld', $essen + $steuer + $trinkgeld);
?>
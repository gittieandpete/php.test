<?php
$meerestiere = "Gurke;Qualle, Aal,Shrimps, Krebs; Blaubarsch";
// Den String in maximal drei Elemente zerlegen
$tier_liste = preg_split('/, ?/',$meerestiere, 3);
print "Das letzte Element ist $tier_liste[2]";
?>
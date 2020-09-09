<?php
$meerestiere = "Gurke;Qualle, Aal,Shrimps, Krebs; Blaubarsch";
// Zerlege den String bei einem Komma oder einem Semikolon
// auf die optional ein Leerzeichen folgen kann
$tier_liste = preg_split('/[,;] ?/',$meerestiere);
print "Hätten Sie gerne etwas wie $tier_liste[2]?";
?>
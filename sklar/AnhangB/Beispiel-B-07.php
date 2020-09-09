<?php
$mitglieder=<<<TEXT

Name               E-Mail-Adresse
------------------------------------------------
Inky T. Geist      inky@pacman.beispiel.com
Donkey K. Gorilla  kong@banana.beispiel.com
Mario A. Klempner  mario@franchise.beispiel.org
Bentley T. Bär     bb@xtal-castles.beispiel.net
TEXT;

print preg_replace('/[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}/',
                   '[ Adresse entfernt ]', $mitglieder);
?>
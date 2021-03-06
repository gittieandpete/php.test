<?php
// Die Datei aus Example 10.2 laden
$seite = file_get_contents('seitenschablone.php');

// Den Seitentitel einf�gen
$seite = str_replace('{seitentitel}', 'Willkommen', $seite);

// Gib der Seite am Nachmittag eine gelbe Farbe und
// am Vormittag eine gr�ne
if (date('H' >= 12)) {
    $seite = str_replace('{farbe}', 'blue', $seite);
} else {
    $seite = str_replace('{farbe}', 'green', $seite);
}

// Hole den Benutzernamen aus der zuvor gespeicherten Session-Variablen
$seite = str_replace('{name}', $_SESSION['benutzername'], $seite);

// Gib das Ergebnis aus
print $seite;
?>
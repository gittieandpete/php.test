<?php

// GDs eingebaute Schriftarten sind von 1 - 5 nummeriert
$schrift = 3;

// Die erforderliche Bildgröße berechnen
$bild_hoehe = intval(imageFontHeight($schrift) * 2);
$bild_breite = intval(strlen($_GET['button']) * imageFontWidth($schrift) * 1.3);

// Das Bild erzeugen
$bild = imageCreate($bild_breite, $bild_hoehe);

// Die Farbe erzeugen, die im grauen Bild-Hintergrund
// verwendet werden soll
$hintergrund = imageColorAllocate($bild, 216, 216, 216);
// Blauer Text
$text_farbe = imageColorAllocate($bild, 0,   0,   255);
// Schwarzer Rahmen
$rahmen_farbe = imageColorAllocate($bild, 0,   0,   0);

// Ermitteln, wo der Text gezeichnet werden soll
// (horizontal und vertikal zentriert)
$x = ($bild_breite - (imageFontWidth($schrift) * strlen($_GET['button']))) / 2;
$y = ($bild_hoehe - imageFontHeight($schrift)) / 2;

// Den Text zeichnen
imageString($bild, $schrift, $x, $y, $_GET['button'], $text_farbe);
// Einen schwarzen Rahmen zeichnen
imageRectangle($bild, 0, 0, imageSX($bild) - 1, imageSY($bild) - 1, $rahmen_farbe);

// Das Bild an den Browser senden
header('Content-Type: image/png');
imagePNG($bild);
imageDestroy($bild);
?>

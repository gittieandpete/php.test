<?php
header ("Content-type: image/jpg");
// Goldener Schnitt, 1,618:1
$im = ImageCreate (161.8, 100)
    or die ("Kann keinen neuen GD-Bild-Stream erzeugen");
// Farben angeben 0 bis 255
$rot = 165; $gruen = 42; $blau = 42;
$background_color = ImageColorAllocate ($im, $rot, $gruen, $blau);
$text_color = ImageColorAllocate ($im, 0, 0, 0);
$text = "Mein Text";
ImageString ($im, 4, 10, 10, $text, $text_color);
ImageJpeg ($im);
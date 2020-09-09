<?php
header ("Content-type: image/jpg");
// Goldener Schnitt, 1,618:1
$im = ImageCreate (161.8, 100)
    or die ("Kann keinen neuen GD-Bild-Stream erzeugen");
// Farben angeben 0 bis 255
$background_color = ImageColorAllocate ($im, 255, 217, 0);
$text_color = ImageColorAllocate ($im, 0, 0, 0);
$text = "Sunrise";
ImageString ($im, 4, 10, 10, $text, $text_color);
ImageJpeg ($im);
?>
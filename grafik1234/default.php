<?php
header ("Content-type: image/jpg");
$bild = ImageCreate (300,100)
    or die ("Kann keinen neuen GD-Bild-Stream erzeugen");
$schrift = 4;
// Farben angeben 0 bis 255
$background_color = ImageColorAllocate ($bild,240,240,240);
$text_color = ImageColorAllocate ($bild, 0,0,255);
$text = '2. Bild, mit Text in blau';
ImageString ($bild, $schrift, 10, 10, $text, $text_color);
ImageJpeg ($bild);
?>
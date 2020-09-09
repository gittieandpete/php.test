<?php
header ("Content-type: image/jpg");
$bild = ImageCreate (3,30)
    or die ("Kann keinen neuen GD-Bild-Stream erzeugen");
$schrift = 4;
// Farben angeben 0 bis 255
$background_color = ImageColorAllocate ($bild,248,121,7);
$text_color = ImageColorAllocate ($bild, 0,0,0);
$text = '';
ImageString ($bild, $schrift, 10, 10, $text, $text_color);
ImageJpeg ($bild);
?>
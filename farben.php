<?php
$titel = "Farben und Bilder";
$menuitem = '';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php';

print "<h1>$titel</h1>";

// Beginn Inhalt

?>

<p>So, ich versuche einen Haufen Bilder zu produzieren mit unterschiedlichen Farben. Erstmal ein Testbild</p>

<?php

define ('GRAFIKDIR','grafik1234');
define ('TEST', GRAFIKDIR . '/testbild.jpg');

/*
int imagestring ( resource $im , int $font , int $x , int $y , string $s , int $col )
ImageString() gibt den String s in dem durch den Parameter im bezeichneten Bild an den Koordinaten x und y aus. Die Koordinaten 0, 0 geben die linke obere Ecke des Bildes im an. Der Font erscheint in der Farbe col . Hat font den Wert 1, 2, 3, 4 oder 5 wird ein interner Font benutzt.
*/

print GRAFIKDIR;
print '<img src="' . TEST . '">';

define ('BILDPFAD', GRAFIKDIR . '/default.php')

?>
<br>
Eine Funktion schreiben, die ein Bild schreibt nach Wunsch, und das dann anzeigen. Wenn nicht anders bestimmt, nimmt die Funktion default-Werte. Das so entstandene Bild:<br>
<?php

// später kann ich noch $text und $textfarbe ändern
// wichtig: durch die '' keine Interpolation der Variablen (z.B. $im), string verbinden  mit '.'.
// Goldener Schnitt, 1,618:1
// Int() für $x,$y funktioniert nicht, immer mit '', z.B. '161.8'

function bild($x = '161.8', $y = '100', $schrift = '4', $pfad = BILDPFAD, $rot = '200', $gruen = '200', $blau = '200', $text = '', $color = '0,0,0')
    {
    $bild = '<?php
header ("Content-type: image/jpg");
$bild = ImageCreate (' . $x . ',' .  $y . ')
    or die ("Kann keinen neuen GD-Bild-Stream erzeugen");
$schrift = ' . $schrift . ';
// Farben angeben 0 bis 255
$background_color = ImageColorAllocate ($bild,' . $rot . ',' .  $gruen . ',' .  $blau . ');
$text_color = ImageColorAllocate ($bild, ' . $color . ');
$text = \'' . $text . '\';
ImageString ($bild, $schrift, 10, 10, $text, $text_color);
ImageJpeg ($bild);
?>';
file_put_contents($pfad, $bild);
}
// Aufruf der Funktion
bild();
// default-Bild
print '<img src="' . GRAFIKDIR . '/default.php">';
?>

<p>Noch ein Bild, diesmal mit Text<br></p>

<p>Mal ein schönes Beispiel</p>

<?php

// mit Text
bild(300,100,4,BILDPFAD,240,240,240,'2. Bild, mit Text in blau','0,0,255');
print '<img src="' . GRAFIKDIR . '/bild2.php">';
//

?>
<p>Viele Bilder, Hintergrund mit Farbverlauf<br></p>
<?php


// print '<ul>';
$rot = 0;
$gruen = 0;
$blau = 255;
for ($i = 0; $i < 256; $i++)
    {
    $pfad = GRAFIKDIR . "/test$i.php";
    $rot = 255 - $i;
    $gruen = abs(128 - $i);
    $blau = $i;
    // print "<li>Rot: $rot Grün: $gruen Blau $blau</li>";
    bild('3','30','4',$pfad, $rot, $gruen, $blau);
    print "<img src=\"$pfad\">";
}
// print '</ul>';

?>

<p>Nochmal zur Ansicht, Bild 10, <img src="<?php print GRAFIKDIR; ?>/test10.php"> Bild 100, <img src="<?php print GRAFIKDIR; ?>/test100.php">Bild 200.<img src="<?php print GRAFIKDIR; ?>/test200.php"></p>

<?php
require 'includes/uebungfooter.php';
?>

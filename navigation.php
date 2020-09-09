<?php
$titel = "Übung zur Navigation 2, Fortsetzung";
$menuitem = 'navigation';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php';

print "<h1>$titel</h1>";

?>

<h2>Navigation mit Untermenüs, Fortsetzung</h2>

<p>Function menue ist ausgelagert. Geht. Test von 'getcwd' (nur Pfad ohne Dateinamen), 'basename' schnippelt den Dateinamen aus dem Superglobal $_SERVER['REQUEST_URI']. Man kann basename auch die Endung sagen, die es abschneiden soll. Pfad bekommt man mit dirname.</p>

<?php

include 'navi_andreas_borutta.php';

$pfad = getcwd();
print "<p>Der momentane Pfad (getcwd) ist $pfad</p>";
$pfad2 = $_SERVER['REQUEST_URI'];
print "<p>Request_uri liefert $pfad2</p>";
$dateiname = basename($pfad2);
print "<p>Diese Datei heißt: $dateiname, abgeschnitten mit basename</p>";
$ohneendung = basename($pfad2, '.php');
print "<p>Diese Datei heißt ohne Endung: $ohneendung, auch mit basename</p>";
$pfad3 = dirname($pfad2);
print "<p>Der Pfad von Request_uri, diesmal ohne Dateinamen, ermittelt mit dirname: $pfad3</p>";
?>





<?php
require 'includes/uebungfooter.php';
?>

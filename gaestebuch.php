<?php
$titel = "Gästebuch";
$menuitem = 'gaestebuch';


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


<p>Ich möchte einen <a href="gaestebuch_zaehler.php">neuen Eintrag</a> schreiben!</p>

<p class="meldung">Bitte blättern Sie nach unten zu Ihrem Eintrag!</p>


<p>Eintrag vom 19.09.16, 03:14 Uhr<br>Neue Nachricht!</p><hr>

<p>Eintrag vom 21.01.19, 01:16 Uhr<br>später Test im Jahre 2019</p><hr>

<p>Eintrag vom 26.07.20, 01:22 Uhr<br></p><hr>

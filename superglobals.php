<?php
$titel = "Superglobale und Konstanten";
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

print "<table class=\"rahmen\">\n";
print "<tr><th colspan=2>Servervariablen</th><tr>";
foreach ($_SERVER as $titel => $inhalt)
    {
    print '<tr><td>' . $titel . '</td><td>' . $inhalt . '</td></tr>';
}
print "<tr><th colspan=2>Umgebungsvariablen</th><tr>";
foreach ($_ENV as $titel => $inhalt)
    {
    print '<tr><td>' . $titel . '</td><td>' . $inhalt . '</td></tr>';
}

print "</table>\n";

print '<h2>Alle vordefinierten Konstanten</h2>';

// print_r ist besser lesbar als var_dump
print '<pre>';
// header ist ein beliebiger string.
print_r(get_defined_constants('header'));
print '</pre>';



require 'includes/uebungfooter.php';
?>

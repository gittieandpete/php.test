<?php
$titel = "PDO Merz Abfragen-Auswahl";
$menuitem = 'pdo';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
// connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php';

print "<h1>$titel</h1>";
?>

<?php

print '<h2>Merz Abfragen umstellen</h2>';

connect_merz();

// Merz-Umgebung:
$kategorie = 'neu';
$instrument = 'blockfloete';
// $leertext = 'angebote';
// $richtung = 'desc';
// $zeitraum = 'rueckblick';
// $status = 2;

print '<ul>' . "\n";
print "\t" . '<li><a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?treffer=5070">Treffer</a></li>' . "\n";
print "\t" . '<li><a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?hersteller=Schimmel">Hersteller</a></li>' . "\n";
print "\t" . '<li><a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?hersteller=Schimmel&amp;instrument=piano">Hersteller+Instrument</a></li>' . "\n";
print "\t" . '<li><a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?instrument=piano">Instrument</a></li>' . "\n";

print '</ul>' . "\n";


hole_pdo_daten();

function sqltable_merz ($result)
    {
    global
        $sep,
        $ln
    ;
    print "<table>\n";
    $zeilenanfang = "\t<tr>\n\t\t<td>";
    $sep = "</td>\n\t\t<td>";
    $ln = "</td>\n\t</tr>\n";
    for ($i = 0;$i < count($result);$i++)
        {
        // id, hersteller, herstellerlink, titel, modell, abmessung, farbe, nummer, baujahr, uvp, text, preis, preisabsolut, rabatt, layout, reihenfolge
        print $zeilenanfang;
        print $result[$i]->id . $sep;
        print $result[$i]->hersteller . $sep;
        print $result[$i]->herstellerlink . $sep;
        print $result[$i]->titel . $sep;
        print $result[$i]->modell . $sep;
        print $result[$i]->abmessung . $sep;
        print $result[$i]->farbe . $sep;
        print $result[$i]->nummer . $sep;
        print $result[$i]->baujahr . $sep;
        print $result[$i]->uvp . $sep;
        print $result[$i]->text . $sep;
        print $result[$i]->preis . $sep;
        print $result[$i]->preisabsolut . $sep;
        print $result[$i]->rabatt . $sep;
        print $result[$i]->layout . $sep;
        print $result[$i]->reihenfolge . $ln;
    }
    print "</table>\n\n";
}





?>


<?php
require 'includes/uebungfooter.php';
?>

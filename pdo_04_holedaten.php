<?php
$titel = "PDO Merz Abfragen";
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

$query = 'select kategorie, instrument, titel, preisabsolut, text, reihenfolge, id
    from produkte
    where kategorie=:kategorie
    AND hersteller=:hersteller
    AND instrument=:instrument';

$stmt = $dbmerz -> prepare($query);
$stmt -> bindParam(':kategorie', $kategorie);
$stmt -> bindParam(':hersteller', $hersteller);
$stmt -> bindParam(':instrument', $instrument);
$kategorie='gebraucht';
$hersteller='Hoffmann';
$instrument='piano';
$stmt -> execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
// alle Ergebnisse in Tabelle
sqltable ($result);

// Merz-Umgebung:
$kategorie = 'gebraucht';
$instrument = 'piano';
$leertext = 'angebote';



function sqltable ($result)
    {
    print "<table>\n";
    $zeilenanfang = "\t<tr>\n\t\t<td>";
    $sep = "</td>\n\t\t<td>";
    $ln = "</td>\n\t</tr>\n";
    for ($i=0;$i<count($result);$i++)
        {
        print $zeilenanfang;
        print $result[$i]->id . $sep;
        print $result[$i]->kategorie . $sep;
        print $result[$i]->instrument . $sep;
        print $result[$i]->titel . $sep;
        print $result[$i]->preisabsolut . $sep;
        print $result[$i]->text . $sep;
        print $result[$i]->reihenfolge . $ln;
    }
    print "</table>\n\n";
}


?>


<?php
require 'includes/uebungfooter.php';
?>

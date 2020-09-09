<?php
$titel = "PDO Merz Checklisten";
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

print '<h2>MySQL Standard-Tabelle ausgeben</h2>';

connect_merz();

// 	global $dbmerz;
$query = 'SELECT hersteller as "Hersteller",instrument as "Instrument",modell as "Mein Modell",preis as Preis,reihenfolge as "Treffer"
        FROM produkte
        WHERE status = 1
        AND kategorie = "gebraucht"
        AND preisabsolut>0
        LIMIT 0,7';

$stmt = $dbmerz -> query($query);
$result = $stmt -> fetchAll(PDO::FETCH_ASSOC);

print count($result);
print count($result[0]);
print '<pre>';
print_r ($result);
print '</pre>';


print '--------------------------' . "\n";

$stmt = $dbmerz -> query($query);
$result = $stmt -> fetchAll(PDO::FETCH_NUM);
print count($result);
print count($result[0]);
print '<pre>';
print_r ($result);
print '</pre>';


print '--------------------------' . "\n";

$stmt = $dbmerz -> query($query);
// Namen der Spalten
$columns = array_keys($stmt->fetch(PDO::FETCH_ASSOC));
// Anzahl der Spalten
$spalten_anzahl = count($columns);
print '<pre>';
print_r($spalten_anzahl);
print_r($columns);
print '</pre>';

print "<p>Bauen der Tabelle mit den Angaben für die Anzahl der Spalten, Namen der Spalten und natürlich dem Inhalt.</p>";

// DB-Handle, Abfrage, Überschrift
pdo_out_standard($dbmerz,$query,'Erste PDO-Tabelle');

function pdo_out_standard($dbmerz,$query, $caption = 'Mysql-Tabelle')
    {
    $stmt = $dbmerz -> query($query);
    $spalten_anzahl = $stmt->columnCount();
    $columnkeys = array_keys($stmt->fetch(PDO::FETCH_ASSOC));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $zeilen = count($result);

    print '<pre>';
    print 'Anzahl der Spalten: ';
    print_r($spalten_anzahl);
    print "\n" . 'Spalten: ';
    print_r($columnkeys);
    print "\n" . 'Zeilen vom Abfrageergebnis: ';
    print_r($zeilen);
    print '</pre>';

    print '<table class = "mysql_out">' . "\n";
    print "\t" . '<caption>' . $caption . '</caption>' . "\n";
    print "\t<tr>\n";
    for ($i = 0;$i < $spalten_anzahl;$i++)
        {
        print "\t<th>" . $columnkeys[$i] . "</th>\n";
    }
    print "\t</tr>\n\n";
    for ($zl = 0;$zl < $zeilen;$zl++)
        {
        print "\t<tr>\n";
        for ($i = 0;$i < $spalten_anzahl;$i++)
            {
            print "\t" . '<td>' . $result[$zl][$columnkeys[$i]] . '</td>' . "\n";
        }
        print "\t</tr>\n\n";
    }
    print "</table>\n\n";
}


?>


<?php
require 'includes/uebungfooter.php';
?>

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

$query = "select kategorie, instrument, titel, preisabsolut, text, reihenfolge, id from produkte where id = :id";
// statement
$stmt = $dbmerz -> prepare($query);
$stmt -> bindParam(':id', $id);
$id = 300;
$stmt -> execute();
$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
// var_dump ($result);
sqltable ($result);
print '<hr>';
$id = 600;
$stmt -> execute();
$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
// var_dump ($result);
sqltable ($result);
print '<hr>';

$query = 'select kategorie, instrument, titel, preisabsolut, text, reihenfolge, id  from produkte where id > :min AND id < :max';

$stmt = $dbmerz -> prepare($query);
$stmt -> bindParam(':min', $min);
$stmt -> bindParam(':max', $max);
$min = 500;
$max = 510;
$stmt -> execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
// var_dump ($result);
// einzelner Zugriff
print $result[0]->reihenfolge . '; ';
print $result[0]->titel . '<br>'. "\n";
print '<hr>';
// alle Ergebnisse in Tabelle
sqltable ($result);

function sqltable ($result)
    {
    print "<table>\n";
    $zeilenanfang = "\t<tr>\n\t\t<td>";
    $sep = "</td>\n\t\t<td>";
    $ln = "</td>\n\t</tr>\n";
    for ($i = 0;$i < count($result);$i++)
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

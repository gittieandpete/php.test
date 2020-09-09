<?php
$titel = "PDO Prepared Statement";
$menuitem = 'pdo';


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

<?php

print '<h2>Abfrageergebnis finden und darstellen</h2>';

$query = "select komponist, titel, id from lieder where id = :id";
// statement
$stmt = $dbh -> prepare($query);
$stmt -> bindParam(':id', $id);
$id = 3;
$stmt -> execute();
$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
// var_dump ($result);
sqltable ($result);
print '<hr>';
$id = 10;
$stmt -> execute();
$result = $stmt -> fetchAll(PDO::FETCH_OBJ);
// var_dump ($result);
sqltable ($result);
print '<hr>';

$query = 'select id, komponist, titel from lieder where id > :min AND id < :max';

$stmt = $dbh -> prepare($query);
$stmt -> bindParam(':min', $min);
$stmt -> bindParam(':max', $max);
$min = 4;
$max = 50;
$stmt -> execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
// var_dump ($result);
// einzelner Zugriff
print $result[0]->komponist . '; ';
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
        print $result[$i]->komponist . $sep;
        print $result[$i]->titel . $ln;
    }
    print "</table>\n\n";
}










?>


<?php
require 'includes/uebungfooter.php';
?>

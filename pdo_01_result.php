<?php
$titel = "PDO Anfang";
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
print "<h2>DB-Treiber</h2>";
print_r ($dbh -> getAvailableDrivers());

print '<h2>Abfrageergebnis finden und darstellen</h2>';

$sep='; ';
$ln="<br>\n";

$query = 'select * from lieder limit 0,5';
// statement
$stmt = $dbh -> query($query);
$result = $stmt -> fetchall();
print_r ($result);
print $ln;
print $result[0][0] . $sep;
print $result[0][1] . $ln;
print $result[4]['komponist'] . $sep;
print $result[4]['titel'];
print '<hr>';

$stmt = $dbh -> query($query);
$result = $stmt->fetchAll(PDO::FETCH_NUM);
print_r ($result);
print $ln;
print $result[0][0] . $sep;
print $result[0][1] . $ln;
for ($i=0;$i<count($result);$i++)
    {
    print $result[$i][2] . $sep;
    print $result[$i][0] . $sep;
    print $result[$i][1] . $ln;
}
print '<hr>';

$stmt = $dbh -> query($query);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r ($result);
print $ln;
print $result[4]['komponist'] . $sep;
print $result[4]['titel'] . $ln;
for ($i=0;$i<count($result);$i++)
    {
    print $result[$i]['id'] . $sep;
    print $result[$i]['komponist'] . $sep;
    print $result[$i]['titel'] . $ln;
}
print '<hr>';

$stmt = $dbh -> query($query);
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
var_dump ($result);
print $ln;
print $result[0]->komponist . $sep;
print $result[0]->titel . $ln;
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
print '</table>';











?>


<?php
require 'includes/uebungfooter.php';
?>

<?php
$titel = "Arrays 1.Teil";
$menuitem = 'arrays';


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

<h2>... sind wie Listen oder Tabellen</h2>

<p>Ausgabe als Liste mit 'for', Nummerierung funktioniert nicht, weil es einfach 5 ol-Listen sind und nicht eine. Count($arrayvariable) zählt die Elemente des Arrays:</p>

<?php
$liste = array('blau','rot','grün','gelb','lila');
for ($i = 0; $i < count($liste); $i++)
    {
    echo "<ol>";
    print "<li>$liste[$i]</li>";
    echo "</ol>";
}
?>

<p>Ausgabe mit var_dump, immer eine Möglichkeit</p>

<?php
print '<pre>';
var_dump ($liste);
print '</pre>';
?>

<p>Ausgabe als Liste mit 'for', Nummerierung funktioniert:</p>

<?php
$liste = array('blau','rot','grün','gelb','lila');
echo "<ol>";
for ($i = 0; $i < count($liste); $i++)
     {
    print "<li>$liste[$i]</li>";
}
echo "</ol>";
?>

<p>Ausgabe mit 'foreach':</p>

<?php
echo "<ol>";
foreach ($liste as $wert)
    {
    print "<li>$wert</li>";
}
echo "</ol>";
?>

<p>Ausgabe mit 'foreach' + Ausgabe der Schlüssel. Die fangen mit 0 an zu zählen.</p>

<?php
echo "<ol>";
foreach ($liste as $schluessel => $wert)
    {
    print "<li>Nr. $schluessel ist $wert</li>";
}
echo "</ol>";
?>

<p>So sorgt man dafür, dass das Array mit key=1 beginnt</p>

<?php
$liste1 = array(1 =>'blau','rot','grün','gelb','lila');
echo "<ol>";
foreach ($liste1 as $schluessel => $wert)
    {
    print "<li>Nr. $schluessel ist $wert</li>";
}
echo "</ol>";
?>

<p>Arrays sind auch wie Tabellen, also wie mehrere Listen mit mehreren (Listen-)Punkten. Leere Zellen sind natürlich möglich (Spalte 3). Ausgabe als Liste:</p>

<?php
$name = array('Zelter','Adorf','Beethoven','Förster');
$vorname = array('Oskar','Heinz','Otto','Karl');
$plz = array('30161','30159','30161','30160');
?>

<p>""ergibt leere Felder, ist wichtig, falls dahinter noch andere Datensätze kommen - die werden sonst falsch zugeordnet. Zum Anzeigen als Html-Tabelle empty-cells:show ins CSS.</p>

<?php
$ort = array('Hannover','Bielefeld','','');
$strasse = array('Schubertstr','Wagnerstr','Moltkeplatz','Bonifaziusplatz');
$telefon = array('','','','05399');
$tabelle = array($name,$vorname,$plz,$ort,$strasse,$telefon);
echo "<ol>";
foreach ($tabelle as $reihennummer => $reihe)
    {
    foreach ($reihe as $zelle => $inhalt)
        {
        print "<li>Reihe $reihennummer: Zelle $zelle: $inhalt</li>";
    }
}
echo "</ol>";
?>

<p>Ausgabe als Tabelle</p>

<?php
echo "<table class=\"rahmen\">";
foreach ($tabelle as $reihennummer => $reihe)
    {
    echo "<tr><td>Reihe $reihennummer</td>";
    foreach ($reihe as $zelle => $inhalt)
        {
        print "<td>Zelle $zelle: $inhalt</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>

<p>Ausgabe als Tabelle ohne Beschriftung</p>

<?php
echo "<table class=\"rahmen\">";
foreach ($tabelle as $spalte => $reihe)
    {
    echo "<tr>";
    foreach ($reihe as $inhalt)
        {
        print "<td>$inhalt</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>

<p>Array komplett kopieren - heißt jetzt nicht mehr $tabelle, sondern $adressen. Wie ein link, also wenn man $adressen ändert, ändert sich $tabelle. </p>


<?php
$adressen = &$tabelle;
echo "<table class=\"rahmen\">";
foreach ($adressen as $spalte => $reihe)
    {
    echo "<tr>";
    foreach ($reihe as $inhalt)
        {
        print "<td>$inhalt</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>

<p>Rückwärts sortieren mit k<strong>R</strong>sort</p>


<?php

krsort($adressen);
echo "<table class=\"rahmen\">";
foreach ($adressen as $spalte => $reihe)
    {
    echo "<tr>";
    foreach ($reihe as $zelle => $inhalt)
        {
        print "<td>$inhalt</td>";
    }
    echo "</tr>";
}
echo "</table>";

?>

<p>...und wieder richtig rum mit <strong>K</strong>sort</p>


<?php

ksort($adressen);
echo "<table class=\"rahmen\">";
foreach ($adressen as $spalte => $reihe)
    {
    echo "<tr>";
    foreach ($reihe as $zelle => $inhalt)
        {
        print "<td>$inhalt</td>";
    }
    echo "</tr>";
}
echo "</table>";

?>



<p> Einzelne Werte ansprechen mit eckigen Klammern. Aufzählung der Vornamen (zur Erinnerung, Array fängt mit 0 an zu zählen), also geht's hier um die 2. Reihe der Tabelle: </p>

<?php

print $tabelle[1][0];
print $tabelle[1][1];
print $tabelle[1][2];
print $tabelle[1][3];
?>

<p>Ausgabe einer Spalte, hier die erste Spalte:</p>

<?php
print $tabelle[0][0];
print $tabelle[1][0];
print $tabelle[2][0];
print $tabelle[3][0];
print $tabelle[4][0];
?>

<p>Werte hinzufügen: wenn man den key (oder Index) weglässt, wird's hinten drangehängt, also hier die Zahlen in den letzten eckigen Klammern weglassen...)</p>

<?php
$adressen[0][]= 'Krause';
$adressen[1][]= 'Torsten';
$adressen[2][]= '14197';
$adressen[3][]= 'Berlin';
$adressen[4][]= 'Kochstr';
$adressen[5][]= '';
?>

<p>Ausgabe: die letzten Werte haben den Index 4 erhalten:</p>

<?php
print $adressen[0][4];
print $adressen[1][4];
print $adressen[2][4];
print $adressen[3][4];
print $adressen[4][4];
print $adressen[5][4];
?>

<p>Hier sieht man, dass sich nicht nur $adressen geändert hat, sondern auch $tabelle. Außerdem täuscht die Tabelle, die Indices sind teilweise nicht vorhanden, z.B. fehlt $adressen[0][8].</p>

<?php
$adressen[0][9]= 'Sandmann';
$adressen[1][9]= 'Tobias';
$adressen[2][9]= '69900';
$adressen[3][9]= 'Frankfurt';
$adressen[4][9]= 'Erwinstr';
$adressen[5][9]= '0160-777';
?>


<?php
echo "<table class=\"rahmen\">";
foreach ($tabelle as $spalte => $reihe)
    {
    echo "<tr>";
    foreach ($reihe as $inhalt)
        {
        print "<td>$inhalt</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>

<p>Nochmal eine Ausgabe, mit var_dump:</p>

<?php
print '<pre>';
var_dump ($tabelle);
print '</pre>';
?>

<p>Also nochmal dieselbe Tabelle, diesmal mit den Schlüsseln:</p>

<?php
echo "<table class=\"rahmen\">";
foreach ($tabelle as $reihe => $spalte)
    {
    echo "<tr><td>Reihe $reihe</td>";
    foreach ($spalte as $zelle => $inhalt)
        {
        print "<td>Zelle $zelle: $inhalt</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>

<p>Welchen Index bekommt der nächste Datensatz, der ohne Index eingegeben wird? - Den nächsten Index (10), nicht einen fehlenden dazwischen (5). Wenn jetzt z.B. Sandmann kein Feld mit Tel.Nr. hätte, würde die Brandt-Nummer nach [5][9] rutschen. Ziemlich unübersichtlich das ganze. Und nicht ungefährlich.</p>

<?php
$adressen[0][]= 'Brandt';
$adressen[1][]= 'Willi';
$adressen[2][]= '10000';
$adressen[3][]= 'Berlin';
$adressen[4][]= 'Reuterstr';
$adressen[5][]= '010-77 44 99';
?>

<?php
echo "<table class=\"rahmen\">";
foreach ($tabelle as $reihe => $spalte)
    {
    echo "<tr><td>Reihe $reihe</td>";
    foreach ($spalte as $zelle => $inhalt)
        {
        print "<td>Zelle $zelle: $inhalt</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>

<p>Die Tabelle wäre natürlich besser zu lesen mit alternierendem Hintergrund pro Zeile. Müsste mit modulo (%) gehen (und auch mit einem index-array, pendelt zwischen 0 und 1, siehe merz). Und die Angaben der Reihen und Zellen können auch weg. Und der resultierende Quelltext (siehe Ctrl+F3) könnte auch etwas übersichtlicher sein als in den vorigen Beispielen. \n und \t als Umbruch und Tab.</p>

<?php
print "<table class=\"rahmen\">\n";
foreach ($tabelle as $reihe => $spalte)
    {
    print "<tr>\n";
    foreach ($spalte as $zelle => $inhalt)
        {
        if ($reihe % 2 == 0)
            {
            print "\t<td class=\"alt\">$inhalt</td>\n";
        }
        else
            {
            print "\t<td>$inhalt</td>\n";
        }
    }
    print "</tr>\n";
}
print "</table>\n";
?>



<p>Siehe auch <a href="datensatz_foreach.php">Datensatz mit foreach</a></p>


<?php
require 'includes/uebungfooter.php';
?>

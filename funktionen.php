<?php
$titel = "Funktionen";
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
?>


<p>Diese sollen in einer externen Datei allen Dokumenten per <code>require</code>
zur Verfügung stehen.</p>

<h2>Beispiel: Funktionen</h2>

<p>In der Datei 'functions.php' (siehe Quelltext) stehen
mehrere Funktionen, die man verwenden kann.</p>

<h3>Multiplikation</h3>

<p>1. statisch:</p>

<?php
$sieben = 7;
$acht = 8;
$erg = multiplizieren($sieben,$acht);
print "<p>$sieben mal $acht ergibt $erg</p>";

function multiplizieren($a,$b)
    {
    return $a*$b;
}
?>

<p>2. mit einer Eingabemöglichkeit</p>

<form action="funktionen.php" method="post">
<fieldset><legend> Multiplikation </legend> <input
    type="text" name="x" size="4" maxlength="10"><span>*</span> <input
    type="text" name="y" size="4" maxlength="10"> <input
    type="submit" value=" = "> <?php
if (isset($_POST['x']) && isset($_POST['y']))
    {
    $x = $_POST['x'];
    $y = $_POST['y'];
    $produkt1 = multiplizieren($x,$y);
    print "<p>$produkt1</p>";
}
?></fieldset>
</form>

<p>Übergabe der Variablen geschieht hier mit POST.</p>

<p>Dasselbe nochmal anders (Ausgabe des Formulars):</p>

<?php
if (isset($_POST['x']) && isset($_POST['y']))
    {
    $produkt2 = multiplizieren("{$_POST['x']}", "{$_POST['y']}");
    print "<p>$produkt2</p>";
}

print '<ol>';
$frucht = array('Erdbeere' => 'rot', 'Banane' => 'gelb');
// Won't work, use braces.  This results in a parse error.
// echo "<li>Eine Banane ist $frucht['Banane'].</li>";
// CURLY geht immer:
echo "<li>Eine Banane ist {$frucht['Banane']}.</li>";
// Das hier funktioniert (warum?) dagegen:
echo "<li>Eine Banane ist $frucht[Banane].</li>";
$zeichenkette = '<li>Eine Erdbeere ist ';
$zeichenkette2 = '.</li>';
print $zeichenkette . $frucht['Erdbeere'] . $zeichenkette2;
print '</ol>';
?>



<p>So, dasselbe nochmal zur Übung mit HERE-Dokument</p>

<?php

// Anfang des HERE-Dokuments: nix darf INHALT folgen in der Zeile, auch kein Kommentar
print <<<INHALT
<hr>
<p><strong>Anfang des HERE-Dokuments.</strong></p>

<p>Dies ist ein längerer Text in html, in dem aber eingebettete Variable aufgelöst werden. Wie das mit den Funktionen ist, werden wir sehen. Das Zeugs von oben kopiere ich hier noch mal rein.</p>

<h3>Multiplikation</h3>

<p>$sieben mal $acht ergibt $erg</p>

<p><strong>Ende des HERE-Dokuments.</strong></p>
<hr>
INHALT;
// Ende des HERE-Dokuments, auch hier nix hinter das ;
// Label direkt nach Zeilenanfang - z.B. kein Tab...


?>

<p>Siehe auch die <a href="primzahl.php">Primzahlen</a></p>

<h3>Array zurückgeben</h3>

<p>Funktionen können auch Arrays zurückgeben. Wie geht das?</p>

<p>Array bauen: (siehe Quelltext)</p>

<p>Die Funktion soll jetzt diese Liste bauen (später irgendwas aus
der Datenbank lesen) und einen Datensatz liefern, also ein Array
liefern.</p>

<?php

function arrayliefern ($einmaleins)
    {
    for ($i = 1; $i <= 10; $i++)
        {
        $ergebnis[] = ($i * $einmaleins);
    }
return $ergebnis;
}

$liste = arrayliefern(7);
print '<ol>';
foreach ($liste as $zahl)
    {
    print "<li>$zahl</li>";
}
print '</ol>';

?>

<p>Ok! Die Funktion rechnet die Ergebnisse aus, packt sie in das
Array $ergebnis, und das wird als $liste ausgegeben.</p>

<p>Test: mehrdimensionales Array müsste eigentlich auch gehen.</p>

<?php

function matrix ($start,$bereich)
    {
    $limit = $start + $bereich;
    for ($k = $start; $k <= $limit; $k++)
        {
        for ($i = 1; $i <= 10; $i++)
            {
            $f_ergebnis[$i] = ($i * $k);
            $f_tabelle[$i] = $f_ergebnis[$i];
        }
    $f_matrix[$k] = $f_tabelle;
    }
return $f_matrix;
}

// 1. Argument Startpunkt, 2. Bereich
$matrix = matrix(39,7);
foreach ($matrix as $zahl => $ergebnis)
    {
    print '<ul style="float:left;">';
    foreach ($ergebnis as $k => $produkt)
        {
        print "<li>$k mal $zahl = $produkt</li>";
    }
print '</ul>';
}

?>



<?php
require 'includes/uebungfooter.php';
?>

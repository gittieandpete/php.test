<?php
$titel = 'Objektorientiertes Programmieren';
$menuitem = 'oop';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php';

include_once('classes/autoload.php');

print "<h1>$titel</h1>";
?>

<p>Als erstes eine Funktion, die eine benötigte Klasse automatisch einbindet, 'autoload'.</p>

<p>Test: erstmal eine hier vorhandene Klasse testen, 'addtest':</p>



<?php

define('A',17);
define('B',4);

class addtest
    {
    public $ergebnis;

    public function plus($a, $b)
        {
        $this->c = $a + $b;
    }
}

$rechne = new addtest();
$rechne->plus(A,B);
print $rechne->c;
?>

<p>Jetzt die Klasse 'rechnen', die im Verzeichnis classes liegt und automatisch eingebunden werden soll. Sie setzt voraus, dass die Datei nach dem Klassennamen benannt worden ist, im Verzeichnis classes liegt, dass 'class_' vorangestellt ist und dass die Endung '.php' ist.</p>

<?php


$rechne = new rechnen();
$rechne->plus(A,B);
print $rechne->ergebnis;
$rechne->minus(A,B);
print $rechne->ergebnis;
$rechne->mal(A,B);
print $rechne->ergebnis;
$rechne->geteilt(A,B);
print $rechne->ergebnis;

$rechne2 = new rechnen();
$rechne2->plus(114,4098);
print $rechne2->ergebnis;

$rechne3 = new rechnen();
$rechne3->geteilt(1,7);
print $rechne3->ergebnis;
$rechne4 = new rechnen();
$rechne4->minus(55,40);
print $rechne4->ergebnis;

$rechne4->hoch(2,10);
print $rechne4->ergebnis;

$rechne4->rest(102,10);
print $rechne4->ergebnis;

print "<p>Das Programm ist zu Ende</p>\n"

?>

<p>Die Klasse meldet sich über __construct. Dort sind zwei Zähler eingebaut ('static'), einer für die Zahl der Objekte, einer für die Zahl der angewandten Methoden. Die __destruct-Anweisung wird erst am Ende ausgeführt. Sollte besser automatisch aufgerufen werden.</p>

<p>Funktioniert.</p>



<?php
require 'includes/uebungfooter.php';
?>

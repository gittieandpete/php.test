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

print '<h2>Merz Checklisten (aus den functions) überprüfen</h2>';

connect_merz();

// Merz-Umgebung:
$kategorie='gebraucht';

print "<p>Es geht um die Herstellerlisten und ...</p>";

$liste=herstellerliste($kategorie);
print_r($liste);

// die functions stehen inzwischen in functions ...


print "<p>... die Instrumentliste</p>";

$liste2=instrumentliste($kategorie);
print_r($liste2);


print '<p>Die Listen sind ok. Jetzt sollen die $_GET-Strings überprüft werden.</p>';

print '<ul>' . "\n";
print "\t" . '<li><a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?hersteller=Schimmel&amp;instrument=fluegel">Hersteller und Instrument setzen</a></li>' . "\n";
print "\t" . '<li><a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?instrument=piano">nur ein Instrument setzen</a></li>' . "\n";
print "\t" . '<li><a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?hersteller=Schiml&amp;instrument=piao">falschen Hersteller und falsches Instrument setzen</a></li>' . "\n";
print '</ul>' . "\n";

if (isset($_GET['hersteller']))
    {
    $liste=getcheckherst($_GET['hersteller'],$kategorie);
    print_r($liste);
}


print '<hr>';

if(isset($_GET['instrument']))
    {
    $liste=getcheckinstr($_GET['instrument'],$kategorie);
    print_r($liste);
}


print "<p>Nochmal die Globals zur Ansicht:</p>";

print_r($_GET);

?>


<?php
require 'includes/uebungfooter.php';
?>

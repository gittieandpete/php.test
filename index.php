<?php
$titel = "PHP, erster Versuch";
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

<p style="float:right;">Die Datei wurde (von Phase5) erneuert am <strong>31.12.2007.</strong></p>

<h2>Meine erste PHP-Seite</h2>

<?php echo 'Hallo Welt. Ausgabe einer Zeichenkette.'; ?>

<p>Die PHP-Installation kann man mit dieser Datei testen:<br>
<a href="info/php_testdatei.php">php_testdatei.php</a> (php-info)</p>

/* Dies ist ein PHP- oder CSS-Kommentar den man sieht. */
<!-- Dies ist ein HTML-Kommentar den man nicht sieht-->


<?php
/*Dies ist ein Kommentar den man nicht sieht. */

// Server-Adresse
$server = $_SERVER["HTTP_HOST"];
// URL aus der Server-Adresse
$url = "http://$server/";
// link aus der URL
$home = "<a href=\"$url\">$url</a>";
?>



<p>Fangen wir mal mit ein paar festen Variablen an:
Der anfordernde Browser ist <strong><?php echo $_SERVER["HTTP_USER_AGENT"]; ?></strong>.<br>
Der Server mit dem Namen <?php echo $_SERVER["SERVER_NAME"];?> hat die Adresse <strong><?php echo "$url"; ?></strong>.<br>
Das sollte auch anklickbar gehen: <?php echo "$home";?>.<br>
Die Seite hat die lokale Adresse <strong><?php echo $_SERVER["PHP_SELF"]; ?></strong>.<br>
Mehr davon bei den <a href="superglobals.php">Super-Globalen</a>.
</p>

<h2>Die End-Tags in PHP</h2>

<p>
<?php
    echo 'Semikolon am Zeilenende und End-Tag.';
?>
</p>

<h2>Konstanten</h2>

<p>Definition:<br>
define('K','5');</p>

<?php
define('K','5');
print K . '<br>';
print "K*5" . '<br>';
print "intval(K)*5" . '<br>';
// Konstanten und Variablen werden als String ausgegeben
print '$i = K*5:<br>';
$i = 4;
// Konstanten werden als String ausgegeben, Variable werden ersetzt durch ihren Wert
print "$i, K*5<br>";
// Rechnung mit K, aber nicht mit Variable
print "$i*" . K*5 . "<br>"; // ergibt 4*25, nicht 100
// Rechnung mit K und Variable:
print $i*K*5 . '<br>'; // ergibt 100
$i = K*8;
print "$i"  . '<br>'; // Zuweisung, $i = 5*8, Ausgabe: '40';



?>

<?php
require 'includes/uebungfooter.php';
?>

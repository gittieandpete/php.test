<?php
$titel = "Gästebuch und Zähler";
$menuitem = 'gaestebuch';


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

<ol start="1" type="1">
<li>Schreiben Sie in ein <a href="gaestebuch.php">Gästebuch</a>!

<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="textformular" method="POST">
<textarea name="text" cols="40" rows="10"></textarea><br>
<input type="submit" value="Eintragen ins Gästebuch!">
</form>

<?php
if (isset($_POST['text']))
    {
    $datum = date('d.m.y');
    $uhrzeit = date('H:i');
    $zeitangabe = "Eintrag vom $datum, $uhrzeit Uhr";
    $eintrag = & $_POST['text'];
    $eintrag = htmlspecialchars($eintrag);
    print "<p> Ihr Eintrag: </p><pre>$eintrag</pre>\n<p>Zeitangabe: $zeitangabe.</p>\n\n";
    $datei = fopen ("gaestebuch.php", "a");
    fwrite ($datei, "\n<p>$zeitangabe<br>$eintrag</p><hr>\n");
    fclose ($datei);
    print "<p class=\"meldung\"><a href=\"gaestebuch.php\">Zum Gästebuch</a></p>";
}
?>

</li>

<li>Schreiben Sie mit PHP einen Zähler (Counter) für eine Seite:<br>
Beim Aufruf der Seite wird eine Datei geöffnet. Die darin enthaltene Zahl wird nun
    <ol start="1" type="1">
    <li>gelesen,</li>
    <li>ausgegeben,</li>
    <li>um 1 erhöht und</li>
    <li>wieder in die Datei zurückgeschrieben.</li>
    </ol>

</li>
</ol>


<?php
// öffnet die Datei zahl (darin ist nur eine Zahl enthalten, sonst nix)
$datei = fopen("info/zahl.txt", "r");
// Dateiinhalt wird gelesen
$zahl = fgets($datei);
// Datei schließen
fclose($datei);
// Wieder öffnen, aber schreibend ('w'),
$datei = fopen("info/zahl.txt", "w");
$zahl = $zahl + 1;
fwrite($datei, "$zahl");
fclose($datei);

?>

<p>Diese Seite wurde <?php echo "$zahl";?> mal aufgerufen.</p>

<?php
require 'includes/uebungfooter.php';
?>

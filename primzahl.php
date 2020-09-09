<?php
$titel = "Primzahlen finden";
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

<p>Ein bestimmter Zahlenbereich wird durchsucht nach Primzahlen.</p>

<form action="primzahl.php" method="get">
<fieldset>
<legend>
Primzahl-Test
</legend>
<input type="text" name="primzahl" size="4" maxlength="10" value="">
<input type="submit" value=" Primzahl? ">
</fieldset>
</form>

<?php
if (isset($_GET['primzahl']))
    {
    $a = $_GET['primzahl'];
    // Umwandlung in positive Zahl
    $a = abs((int)$a);
    // Bereich
    $b = $a + 1000;
    if ($a != 0)
        {
        print "<p>Alle Primzahlen zwischen <strong>$a</strong> und <strong>$b</strong>:</p>\n";
    } else {
        print "<p>Gib eine Zahl größer als Null ein!</p>\n";
    }
    echo "<p>";
    while ($a < $b && $a != 0)
        {
        berechne($a);
        $a++;
    }
    echo "</p>";
}
?>


<p>Eine magische Zahl:<br>
4096 * 137 * 73 = 40964096<br>
wobei 137 und auch 73 Primzahlen sind.
</p>

<p>Eine andere magische Zahl:<br>
1010101 13837 73 101...siehe OOcalc-Tabelle.</p>



<?php
require 'includes/uebungfooter.php';
?>

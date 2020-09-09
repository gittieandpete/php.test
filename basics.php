<?php
$titel = "Basics";
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

<?php
$text = 'Fluch der Karibik';
?>

<ol>
<li>Schreiben Sie eine HTML-Seite, die einen PHP-Befehl enthält, der den Text:<br>
Fluch der Karibik<br>
ausgibt.

<?php
    echo '<ul>';
    echo "$text";
    echo '</ul><hr>';

$text = 'Wer das liest ist doof!';
$text2 = '
Abrakadabra
';

$zahl=50000;
$zahl2=3;
$zahl3=165;
$ergebnis=$zahl+$zahl2+$zahl3;
echo '<pre>';

echo $text;
print $text2;
echo $ergebnis;

echo '</pre>';
?>


</li>
<li>Schreiben Sie eine HTML-Seite, auf der 7 mal Fluch der Karibik geschrieben steht.
<?php

$i = 0;
echo '<ol>';
while ($i < 10)
    {
    echo "<li>i = $i: $text2</li>";
    $i = $i + 1;
}
echo '</ol><hr>';
?>

</li>
<li>Schreiben Sie ein HTML-Formular, in das man eine Zahl eingeben kann. Klickt man auf Abschicken, wird so oft der Text aus Aufgabe 3 ausgegeben, wie diese Zahl angibt.

<form action="basics.php" method="get">
<input type="Text" name="zahl" value="">
</form>

<?php
if (isset($_GET['zahl']))
    {
    $wieoft = $_GET['zahl'];
    echo '<ol>';
    $f = 0;
    while ($f < $wieoft)
        {
        echo "<li>$text</li>";
        $f++;
    }
echo '</ol><hr>';
}

?>

</li>

<li>PHP-Programm, das den Gesamtpreis eines Restaurantbesuchs ausrechnet<br>
<p>Warum '%2.2f' den Preis nicht nach rechts ausrichtet? 2.2 heißt nicht etwa <cite>2 Stellen vor und 2 Stellen nach dem Komma</cite>, sondern heißt <cite>2 Stellen mindestens insgesamt, 2 Stellen nach dem Komma</cite>. Formatierung also <code>%5.2f</code></p>

<?php
// setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge'); //steht jetzt in functions.php
$hamburger = 4.95;
$shake = 1.95;
$cola = 0.85;
$mwst = 19/100;
$trinkgeld = 10/100;

// netto
$netto = ($hamburger * 2) + $shake + $cola;
// Trinkgeld 10% von netto
$trinkgeld = $netto * $trinkgeld;
// Mehrwert = 16 von netto
$mwst = $netto * $mwst;
//Zwischensumme ohne Trinkgeld
$zwi = $netto + $mwst;
// Summe
$summe = $netto + $trinkgeld + $mwst;
print "<pre>";
printf("%d %10s, Stück %.2f, zus. %05.2f &euro;\n", 2, 'Hamburger', $hamburger, $hamburger * 2);
printf("%d %10s, Stück %.2f, zus. %05.2f &euro;\n", 1, 'Cola', $cola, $cola);
printf("%d %10s, Stück %.2f, zus. %05.2f &euro;\n", 1, 'Milchshake', $shake, $shake);
printf("%-29s  %05.2f &euro;\n", 'Gesamtsumme vor Steuern: ', $netto);
printf("%-29s  %05.2f &euro;\n", 'Mehrwertsteuer 19%: ', $mwst);
printf("%-29s  %05.2f &euro;\n", 'Zwischensumme: ', $zwi);
printf("%-29s  %05.2f &euro;\n", 'Bezahlt incl. Trinkgeld: ', $summe);
print "</pre>";
?>

<p>Hier als Html-Tabelle...</p>

<h1>Ristorante Vesuvio</h1>

<table class="rahmen">
<tr>
<th>No. Bestellung</th>
<th>Preis</th>
</tr>

<tr>
<td>2 Hamburger</td>
<td style="text-align:right;"><?php printf("%.2f", $hamburger * 2)?> &euro;</td>
</tr>

<tr>
<td>1 Milchshake</td>
<td style="text-align:right;"><?php printf('%.2f', $shake)?> &euro;</td>
</tr>

<tr>
<td>1 Cola</td>
<td style="text-align:right;"><?php printf('%.2f', $cola)?> &euro;</td>
</tr>

<tr>
<td>Gesammtsumme vor Steuern:</td>
<td style="text-align:right;"><?php printf('%.2f', $netto)?> &euro;</td>
</tr>

<tr>
<td>Mehrwertsteuer 16%:</td>
<td style="text-align:right;"><?php printf('%.2f', $mwst)?> &euro;</td>
</tr>

<tr>
<td>Insgesamt:</td>
<td style="text-align:right;"><?php printf('%.2f', $zwi) ?> &euro;</td>
</tr>

<tr>
<td>Bezahlt einschl. Trinkgeld:</td>
<td style="text-align:right;"><?php printf('%.2f', $summe) ?> &euro;</td>
</tr>

<tr>
<th colspan="2">Wir danke für Ihre Besuche!</th>
</tr>
</table>
<?php
// Ausgabe
printf('Ich habe da neulich im Restaurant wieder mal %.2f &euro; ausgegeben, sagenhaft teuer...<hr>', $summe);
?>
</li>
<li>Schreiben Sie ein Programm, das Ihren Vor- und Nachnamen als String ausgibt mit den Variablen $vorname und $nachname. Geben Sie auch die Länge dieses Stringes aus.<br>

<?php
$vorname = 'Petrosilius';
$nachname = 'Zwackelmann';
$name = "$vorname" . " " . "$nachname";
$laenge = strlen($vorname) + strlen($nachname);
print "<p>Ich heiße $name. Mein Name hat $laenge Buchstaben</p><hr>";
?>

</li>

<li>Schreiben Sie ein PHP-Programm, das den Inkrementierungsoperator (++) und den kombinierten Multiplikationsoperator (*=) verwendetn, um die Zahlen von 1 bis 5 und die Potenzen von 2 von 2 (2<sup>1</sup>) bis 32 (2<sup>5</sup>) auszugeben.<br>

<?php
print "<ol>\n";
for ($i = 1; $i <= 5; $i++)
    {
    print "\t<li>$i</li>\n";
}
print "</ol><hr>";
?>

<?php
print "<ol>\n";
$k = 2;
for ($i = 1; $i <= 4096; $i *= $k) // $i = $i * $k;
    {
    print "\t<li>$i</li>\n";
}
print "</ol><hr>";
?>


</li>

<li>Nutzen Sie while(), um eine Tabelle mit korrespondierenden Temperaturangaben in Celsius und Fahrenheit auszugeben. Der Tabellenbereich soll von -50 Grad F bis 50 Grad F reichen und in 5-Grad-Schritte unterteilt sein. Dann dasselbe nochmal mit for.

<pre>
32 &deg;F = 0 &deg;C
212 &deg;F = 100 &deg;C
Umrechnung: (&deg;F - 32)*5/9 = &deg;C
</pre>

<?php
$min = -48;
$max = 248;
$i = $min;
print "<table class=\"daten rechts\">\n";
print "<tr>\n\t<th>&deg;F</th>\n<th>&deg;C</th>\n</tr>\n";
while ($i <= $max)
    {
    print "<tr>\n";
    printf ("\t<td>%d</td>\n\t<td>%d</td>\n", $i, ($i - 32)*5/9);
    print "</tr>\n";
    $i = $i + 4;
}
print "</table>";
?>

<?php
print "<table class=\"daten\">\n";
print "<tr>\n\t<th>&deg;F</th>\n<th>&deg;C</th>\n</tr>\n";
for ($i = $min;$i <= $max;$i = $i + 4)
    {
    print "<tr>\n";
    printf ("\t<td>%d</td>\n\t<td>%d</td>\n", $i, ($i - 32)*5/9);
    print "</tr>\n";
}
print "</table>";
?>


</li>
</ol>



<?php
require 'includes/uebungfooter.php';
?>

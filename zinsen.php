<?php
$titel = "Zinsen für Ratenkredite";
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

<h2>Zinsrechnung/Kredittilgung</h2>

<p>Für eine Schuld S werden vom Schuldner jeweils am Ende einer Zinsperiode p % Zinsen verlangt.</p>

<p>Nach N Zinsperioden sei die Schuld vollständig getilgt.</p>

<p>Die Belastung eines Schuldners pro Zinsperiode setzt sich somit aus Zinsen und Tilgungsrate zusammen. Falls die Zinsperiode 1 Jahr beträgt, bezeichnet man den finanziellen Aufwand des Schuldners in dem betreffenden Jahr als Annuität.</p>

<p>Für die Tilgung einer Schuld gibt es verschiedene Möglichkeiten. So können z.B. die Rückzahlungen zu den Verzinsungszeitpunkten oder dazwischen erfolgen, die Rückzahlungsbeträge verschieden hoch oder während der gesamten Laufzeit konstant sein. </p>

<p>Folgende Fälle werden betrachtet:</p>

<h3>Gleiche Tilgungsraten</h3>

<p>Die Tilgung erfolgt unterjährig, es werde aber <strong>keine</strong> unterjährige Verzinsung mit Zinseszins vereinbart. Es werden folgende Bezeichnungen verwendet:</p>

<pre>

S Schuld, Verzinsung nachschüssig mit
p %.
T Tilgungsrate (konstant)

T = S / (m*N)

m Anzahl der Tilgungsraten pro Zinsperiode
  (z.B. m = 12, monatliche Raten, jährliche Verzinsung)
N Anzahl der Zinsperioden bis zur engültigen Tilgung der Schuld
Z(index n) Zinsen für die n-te Zinsperiode:

Z(index n) = p*S/100 *[1 - 1/N(n-{m+1}/{2*m})]; // 1.86a

</pre>

<p>Gesamtzinsen Z zur Tilgung einer Schuld S. Die Zahlung erfolge in m*N Raten bei N Zinsperioden zu p% Zinsen:</p>

<pre>
Z = p*S/100[(N-1)/2 + (m+1)/(2*m)]; // 1.86b
</pre>

<h3>Gleiche Annuitäten</h3>

<p>Bei gleichbleibenden Tilgungsraten nehmen die zusätzlich anfallenden Zinsen im Laufe der Zeit ab (s. voranstehendes Beispiel). Bei der Annuitätentilgung wird dagegen zu jedem Zinstermin die gleiche Annuität A, d.h. der gleiche Betrag für Zinsen + Tilgung erhoben. Damit ist die Belastung des Schuldners im gesamten Tilgungszeitraum konstant.</p>

<p>Es werden die folgenden Bezeichnungen verwendet:</p>

<pre>
S Schuld (Verzinsung mit pro p% Zinsperiode),
A Annuität pro Zinsperiode (A const),
a Tilgungsrate bei m Tilgungen pro Zinsperiode (a const),
q = 1 + p/100 Aufzinsungsfaktor
</pre>

<p>Als Restschuld S(index n) nach n Zinsperioden ergibt sich:</p>

<pre>
S(index n) = Sq(sup n) - a[m + (m-1)p/200]* (q(sup n) - 1)/(q - 1); // 1.87
</pre>

<p>Dabei beschreibt der Term Sq(sup n) (= hoch n) den Wert der Schuld S nach n Zinsperioden mit Zinseszins, der zweite Term gibt den Wert der unterjährigen Tilgungsraten a mit Zinseszins wieder.</p>

<p>Für die Annuität gilt:</p>

<pre>
A = a[m + (m-1)p/200]; // 1.88
</pre>

<p>Dabei entspricht die einmalige Zahlung von A den m Ratenzahltungen a. Aus der Gleichung folgt A >= m*a. Da nach N Zinsperioden die Schuld getilgt sein soll, folgt für S(index n) = 0</p>

<pre>
A = S*q(sup N)*(q-1)/(q{supN} - 1) = S*(q-1)/(1-q{sup-N}); // 1.89
</pre>

<p>Zur Lösung von Aufgaben der finanzmathematischen Praxis kann diese Gleichung nach einer der Größen A, S, q oder N aufgelöst werden, wenn die übrigen Größen bekannt sind.</p>

<h3>Beispiel A</h3>

<p>Eine Annuitätenschuld über 60 000.- Euro werde jährlich mit 8% verzinst und soll in 5 Jahren getilgt sein. Wie hoch sind jährliche Annuität A und monatliche Tilgungsrate a? Aus (1.89) bzw. (1.88) erhält man:</p>

<pre>
A = 60000 * [0,08/(1-1/1,08{sup5}) = 15027,39 Euro;
a = 15027,39/(12+11*8/200) = 1207,99 Euro.
</pre>


<p>Versuchen wir mal eine Formel, die die Zahlungen dieses Beispiels liefert. Als erstes berechnen wir die Annuität.</p>

<?php

$j = 5; // Zinsperioden in Jahren, Laufzeit
$p = 8.0; // Zinssatz in %
$m = 12; // Zahlungen pro Jahr, also hier Monatsraten
$k = 60000; // Kredit
$q = 1 + $p/100; // Aufzinsungsfaktor, Quotient

$ann = null; // Annuität
$til = null; // Tilgungsraten
$fin = null; // Finanzierungskosten

// A = S*(q-1)/(1-q{sup-N})

$ann = $k*($q-1)/(1-(pow($q,-$j)));
print $ann;

print "<p>Sehr gut. Als nächstes die monatlichen Tilgungen. Stimmt überein mit dem Beispiel von der Anleitung. Es handelt sich hier nicht um die Berechnung des Effektiv-Zinses. </p>";

// a = A/(m + {(m-1)p}/200)

$til = $ann/($m + ($m-1)*$p/200);
print $til;

print "<p>Auch in Ordnung. Die Finanzierungskosten sind einfach die Monatsraten mal Laufzeit minus '$k' (Kredit).</p>";

$fin = $til*$m*$j - $k;
print $fin;

print "<p>Die Ergebnisse gerundet:</p>";

$til = round($til,2);
$fin = round($fin,2);
print $til . '<br>';
print $fin;

print '<hr>';


// Das Merz-Formular dementsprechend:
// Währungs- und Zahlenformat anpassen, sind in functions
// setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');

// Variable setzen
$jahre = range(1,6);
$max = count($jahre);

// Zinssatz siehe oben
$m = 12; // Zahlungen pro Jahr, also hier Monatsraten
$q = 1 + $p/100; // Aufzinsungsfaktor, Quotient

$ann = null; // Annuität
$til = null; // Tilgungsraten
$fin = null; // Finanzierungskosten

// Entscheidung
if (isset($_POST['abgeschickt']) && $_POST['abgeschickt'] == 1)
    {
    process_credit_form($jahre,$max,$p,$m,$q);
} else	{
    show_credit_form($jahre,$max);
}

function show_credit_form($jahre,$max)
    {
    $k = null;
    $legend = 'Raten und Finanzierungskosten berechnen';
    template($jahre,$max,$k,$legend);
}

function process_credit_form($jahre,$max,$p,$m,$q)
    {
    // Jahre
    $j = $_POST['laufzeit'];
    $j = pruefezahl($j,1);
    // Kredit
    $k = $_POST['kreditsumme'];
    $k = pruefezahl($k,5);
    // Annuität
    $ann = $k*($q-1)/(1-(pow($q,-$j)));
    // monatliche Tilgung, Rate
    $til = $ann/($m + ($m-1)*$p/200);
    // Finanzierungskosten
    $fin = $til*$m*$j - $k;
    // runden
    $til = round($til,2);
    $fin = round($fin,2);
    // Formatieren
    $k = sprintf("%01.2f&euro;", $k);
    $til = sprintf("%01.2f&euro;", $til);
    $fin = sprintf("%01.2f&euro;", $fin);
    $p = sprintf("%01.2f%%", $p);

    if ($j == 1) $text = 'Jahr'; else $text = 'Jahre';
    // Ergebnis anzeigen
    print <<<HTML

<h2><a name="konditionen">Konditionen</a></h2>
<table class="tab">
<tr><td>Laufzeit</td><td class="rechts">$j $text</td></tr>
<tr><td>Kreditsumme</td><td class="rechts">$k</td></tr>
<tr><td><strong>monatliche Rate</strong></td><td class="rechts"><strong>$til</strong></td></tr>
<tr><td>Finanzierungskosten</td><td class="rechts">$fin</td></tr>
<tr><td>Zinssatz/Jahr</td><td class="rechts">$p</td></tr>
</table>


HTML;
    $legend = 'Neu berechnen';
    $k = (int)$k;
    template($jahre,$max,$k,$legend);
}

// Prüfen auf Zahl und Länge
function pruefezahl($str, $laenge=5)
    {
    $str = trim($str);
    $str = substr("$str",0,$laenge);
    $str = strip_tags($str);
    $str = (int)$str;
    return $str;
}

function template($jahre,$max,$k,$legend)
    {
    $url = htmlspecialchars($_SERVER['PHP_SELF']);
    print <<<HTML

<form action="{$url}#konditionen" method="post">
<fieldset class="kredit">
<legend>
$legend
</legend>

<table>
    <tr><td class="rechts"><label for="id_kreditsumme">Kreditsumme</label></td><td><input name="kreditsumme" id="id_kreditsumme" size="5" maxlength="5" value="$k"><span>&euro;</span></td></tr>
    <tr><td class="rechts"><label for="id_laufzeit">Laufzeit</label></td><td>
    <select size="1" width="8" name="laufzeit" id="id_laufzeit">
HTML;
// options-Liste bauen
for ($i = 0; $i < $max; $i++)
    {
    if ($i == 0) $text = 'Jahr'; else $text = 'Jahre';
    print "\t<option value=\"$jahre[$i]\"> $jahre[$i] $text</option>\n";
}

print <<<HTML
    </select></td></tr>
    <tr><td class="rechts"></td><td><input type="submit" value="berechnen"></td></tr>
    <input type="hidden" name="abgeschickt" value="1">
</table>
</fieldset>
</form>
HTML;
}



require 'includes/uebungfooter.php';
?>



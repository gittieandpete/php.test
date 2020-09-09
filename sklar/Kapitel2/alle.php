Beispiel 2-01: Here-Dokument
Beispiel 2-02: Ein Here-Dokument ausgeben
Beispiel 2-03: Die L�nge eines beschnittenen Strings pr�fen
Beispiel 2-04: Die L�nge eines beschnittenen Strings kompakter pr�fen
Beispiel 2-05: Strings mit dem Gleichoperator pr�fen
Beispiel 2-06: Strings ohne Ber�cksichtigung von Gro�-/Kleinschreibung vergleichen
Beispiel 2-07: Einen Preis mit printf() formatieren
Beispiel 2-08: Mit printf() mit Nullen auspolstern
Beispiel 2-09: Mit printf() Vorzeichen anzeigen
Beispiel 2-10: Die Gro�-/Kleinschreibung �ndern
Beispiel 2-11: Namen mit ucwords() versch�nern
Beispiel 2-12: Einen String mit substr() k�rzen
Beispiel 2-13: Mit substr() das Ende eines Strings herausziehen
Beispiel 2-14: str_replace() verwenden
Beispiel 2-15: Zahlen
Beispiel 2-16: Mathematische Operationen
Beispiel 2-17: Mit Variablen arbeiten
Beispiel 2-18: Kombinierte Zuweisung und Addition
Beispiel 2-19: Kombinierte Zuweisung und Verkn�pfung
Beispiel 2-20: Erh�hen und Vermindern
Beispiel 2-21: Variableninterpolation
Beispiel 2-22: In ein Here-Dokument interpolieren
Beispiel 2-23: Mit geschweiften Klammern interpolieren


<<<HTMLBLOCK
<html>
<head><title>Speisekarte</title></head>
<body bgcolor="#fffed9">
<h1>Abendessen</h1>
<ul>
  <li> Rindfleisch Chow-Fun
  <li> Sautierte Zuckerschoten
  <li> Nudeln in Sojasauce
  </ul>
</body>
</html>
HTMLBLOCK
print <<<HTMLBLOCK
<html>
<head><title>Speisekarte</title></head>
<body bgcolor="#fffed9">
<h1>Abendessen</h1>
<ul>
  <li> Rindfleisch Chow-Fun
  <li> Sautierte Zuckerschoten
  <li> Nudeln in Sojasauce
  </ul>
</body>
</html>
HTMLBLOCK;
// $_POST['plz'] speichert den Wert des �bergebenen Formularparameters "plz"
$plz = trim($_POST['plz']);
// Jetzt h�lt $plz den Wert minus eventuelle f�hrende oder anh�ngende Leerzeichen
// removed
$plz_laenge = strlen($plz);
// Beschweren, wenn die Postleitzahl nicht f�nf Zeichen lang ist
if ($plz_laenge != 5) {
    print "Bitte geben Sie eine Postleitzahl ein, die f�nf Zeichen lang ist.";
}
if (strlen(trim($_POST['plz'])) != 5) {
    print "Bitte geben Sie ein Postleitzahl ein, die f�nf Zeichen lang ist.";
}
if ($_POST['email'] == 'kanzler@kanzleramt.de') {
   print "Guten Tag Herr Bundeskanzler.";
}
if (strcasecmp($_POST['email'], 'kanzler@kanzleramt.de') == 0) {
    print "Sch�n, dass sie wieder da sind Herr Bundeskanzler.";
}<?php
$preis = 5; $steuer = 0.16;
printf('Das Gericht kostet %.2f EUR', $preis * (1 + $steuer));
?>
<?php
$plz = '6520';
$tag = 2;
$monat = 6;
$jahr = 2007;

printf("Die Postleitzahl ist %05d und das Datum %02d.%02d.%d",
        $plz, $tag, $monat, $jahr);
?>
<?php
$min = -40;
$max = 40;
printf("Der Computer kann zwischen %+d und %+d Grad Celsius betrieben werden.", $min, $max);
?>
<?php
print strtolower('Rindfleisch, HUHN, Schweinefleisch, enTE');
print strtoupper('Rindfleisch, HUHN, Schweinefleisch, enTE');
?><?php
print ucwords(strtolower('JOHN FRANKENHEIMER'));
?>// Die ersten 30 Zeichen aus $_POST['kommentare'] herausziehen
print substr($_POST['kommentare'], 0, 30);
// Auslassungspunkte hinzuf�gen
print '...';
print 'Karte: XX';
print substr($_POST['karte'],-4,4);
print str_replace('{class}',$mein_class_wert,
                  '<span class="{class}">Frittierter Tofu<span>
                   <span class="{class}">Fisch in �l</span>');
<?php
print 56;
print 56.3;
print 56.30;
print 0.774422;
print 16777.216;
print 0;
print -213;
print 1298317;
print -9912111;
print -12.52222;
print 0.00;
?><?php
print 2 + 2;
print 17 - 3.5;
print 10 / 3;
print 6 * 9;
?><?php
$preis = 3.95;
$steuersatz = 0.16;
$steuerbetrag = $preis * $steuersatz;
$gesamtpreis = $preis + $steuerbetrag;

$benutzername = 'james';
$domain = '@beispiel.com';
$email_adresse = $benutzername . $domain;

print 'Der Steuerbetrag ist ' . $steuerbetrag;
print "\n"; // Das gibt einen Zeilenumbruch aus
print 'Der Gesamtpreis ist ' .$gesamtpreis;
print "\n"; // Das gibt einen Zeilenumbruch aus
print $email_adresse;
?>
// Auf gew�hnliche Weise 3 hinzuf�gen
$preis = $preis + 3;
// Mit dem kombinierten Operator 3 hinzuf�gen
$preis += 3;
$benutzername = 'james';
$domain = '@beispiel.com';

// $domain auf gew�hnliche Weise an $benutzername anh�ngen
$benutzername = $benutzername . $domain;
// Mit dem kombinierten Operator anh�ngen
$benutzername .= $domain;
// $geburtstag 1 hinzuf�gen
$geburtstag = $geburtstag + 1;
// $geburtstag nochmal 1 hinzuf�gen
++$geburtstag;

// Von $verbleibende_jahre 1 abziehen
$verbleibende_jahre = $verbleibende_jahre - 1;
// Von $verbleibende_jahre nochmal 1 abziehen
--$verbleibende_jahre;
<?php
$email = 'jakob@beispiel.com';
print "Schicken Sie Ihre Anwort an: $email";
?><?php
$seitentitel = 'Speisekarte';
$fleisch = 'Schweinefleisch';
$gemuese = 'Sprossen';
print <<<SPEISEKARTE
<html>
<head><title>$seitentitel</title></head>
<body>
<ul>
<li> Gegrilltes $fleisch
<li> Geschnetzeltes $fleisch
<li> Ged�nstetes $fleisch mit $gemuese
</ul>
</body>
</html>
SPEISEKARTE;
?><?php
$zubereitung = 'Ged�nstet';
$fleisch = 'Rindfleisch';
print "{$zubereitung}es $fleisch mit Gem�se";
?>

<?php

$��u = array("��u" => "umls",
             "hal" => "rien");

print "Manchmal mit $��u[��u] und manchmal $��u[hal]";

$al������� = "hallo";
print $al�������;

?><<<HTMLBLOCK
<html>
<head><title>Speisekarte</title></head>
<body bgcolor="#fffed9">
<h1>Abendessen</h1>
<ul>
  <li> Rindfleisch Chow-Fun
  <li> Sautierte Zuckerschoten
  <li> Nudeln in Sojasauce
  </ul>
</body>
</html>
HTMLBLOCK

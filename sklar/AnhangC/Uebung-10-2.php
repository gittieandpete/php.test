<?php
$in_fh = fopen('adressen.txt','rb');

if (! $in_fh) {
    die("Kann adressen.txt nicht �ffnen: $php_errormsg");
}

// Die Adressen werden mit diesem Array gez�hlt
$adressen = array(  );

for ($zeile = fgets($in_fh); ! feof($in_fh); $zeile = fgets($in_fh)) {
    if ($zeile === false) {
        die("Fehler beim Lesen der Zeile: $php_errormsg");
    } else {
        $zeile = trim($zeile);
        // Die Adressen als Schl�ssel f�r $adresse verwenden,
        // der Wert ist die Anzahl von Vorkommen
        $adressen[$zeile] = $adressen[$zeile] + 1;
    }
}

if (! fclose($in_fh)) {
    die("Kann adressen.txt nicht schlie�en: $php_errormsg");
}

$out_fh = fopen('adressen-anzahl.txt','wb');
if (! $out_fh) {
    die("Kann adressen-anzahl.txt nicht �ffnen: $php_errormsg");
}

// $adressen in umgekehrter Reihenfolge �ber den Wert sortieren
arsort($adressen);

foreach ($adressen as $adresse => $anzahl) {
    // Den Zeilenumbruch nicht vergessen!
    if (fwrite($out_fh, "$anzahl,$adresse\n") === false) {
        die("Kann $anzahl,$adresse nicht schreiben: $php_errormsg");
    }
}

if (! fclose($out_fh)) {
    die("Kann adressen-anzahl.txt nicht schlie�en: $php_errormsg");
}
?>
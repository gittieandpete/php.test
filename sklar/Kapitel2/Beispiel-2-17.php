<?php
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

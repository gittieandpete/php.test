<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require 'kontaktformular_ver1.10_functions.php';
?>

<!DOCTYPE HTML>
<html lang="de">
<head>
<title>Mailformular</title>
<meta	charset="utf-8">
<meta	name="author"	content="Peter Müller">

</head>

<body>

<div id="outer">

<div id="content">

<?php

################ Version #################
/*

Version 1.10 mb_send_mail, formatierter Mailbody (wordwrap), \r\n statt \n (laut RFC), content-transfer-encoding 8bit gesetzt (http://tools.ietf.org/html/rfc2045#section-6.1);
Version 1.09 (pianoforte-Version). Mailadresse wird überprüft. Alle Felder vorhanden. Anrede und weiterer Formulartext als Konstanten im Formular verwandt, leicht übersetzbar (1 function für alle Sprachen).
Version 1.08 (Versionssprung wegen Namensgleichheit mit der Kurzversion) $_SERVER['PHP_SELF'] abgesichert, Anrede-PostWert wird geprüft
Version 1.06 ohne E-Mail Feld
Version 1.05 Prüfung auf E-Mail Absenderadresse abwählbar (siehe Einrichtung)
Version 1.04 Feld 'Anrede' als checkbox.
Version 1.03 Feld 'Anrede' hinzugefügt; Texte änderbar gemacht
Version 1.02 HTML-Fehler beseitigt (post statt POST), CSS verbessert
Version 1.01 Doctype-spezifische Endung für input /> hinzugefügt.

*/
################ Einrichtung ###########################
// Einrichtung des Formulars - bitte den Text, nicht die Konstante, wie gewünscht anpassen
// Beispiel define('KONSTANTE_NICHT_AENDERN','Text kannst du ändern');
// $testmodus später auf 0 setzen.

// Titel des Formulars
define('FORMULARTITEL','Mailformular');
// an welche Adresse soll die Nachricht aus dem Formular geschickt werden?
define('EIGENEMAIL','peter.mueller@c-major.de');
// welchen Betreff soll die Mail erhalten, die an dich geschickt wird? (das ist nicht der Betreff, den die Leute angeben)
define('BETREFF_CHEF','Mail vom Kontaktformular auf domainname');
// Fehlermeldungen (nicht löschen, ggf. Text ändern)
define('MAILADRESSEFEHLT','Bitte geben Sie eine Mailadresse ein, damit wir Ihnen antworten können!');
define('NACHRICHTFEHLT','Bitte geben Sie etwas ins Nachrichtenfeld ein!');
// Feldnamen - nicht löschen, nur Text ändern möglich!
define('ANREDE','Anrede');
define('VORNAME','Vorname');
define('NAME','Name');
define('STRASSE','Straße');
define('PLZ','PLZ');
define('ORT','Ort');
define('TEL','Telefon');
define('MAILABSENDER','E-Mail');
define('BETREFF','Betreff');
define('NACHRICHT','Nachricht');
// weiterer Text
define('MAILVERSENDET','Vielen Dank! Ihre Mail wurde erfolgreich versandt.');
define('MAILNICHTVERSENDET','Die Mail konnte nicht versendet werden.');
define('IHRENACHRICHT','Ihre Nachricht');
define('HERR','Herr');
define('FRAU','Frau');
define('SENDEN','Senden');
// Testmodus auf an (1) oder aus (0) setzen. Bei '0' werden Mails versandt, bei '1' werden sie auf der Seite selbst angezeigt zum Testen
$testmodus = 1;
// soll auf das Vorhandensein einer Mailadresse geprüft werden? Ja, dann 1 eintragen; Nein, dann 0 eintragen.
$mailabsenderadresse = 1;

################ Einrichtung fertig! ########################

if (!array_key_exists('abgeschickt',$_SESSION))
    {
    $_SESSION['abgeschickt'] = 0;
}

// zugrunde liegende Logik für das Formular
if (array_key_exists('abgeschickt', $_POST) && array_key_exists('challenge', $_SESSION) && $_POST['abgeschickt'] == $_SESSION['challenge'])
    {
    if ($formularfehler = validiere_mailformular())
        {
        zeige_mailformular($formularfehler);
    } else {
        verarbeite_mailformular();
    }
} else {
    zeige_mailformular();
}

if ($testmodus==1)
    {
    print "<p>Testmodus ist an, die Formulardaten werden hier ausgegeben.</p>";
    // Mails auf dem Testsystem landen in /var/mail/www-data.
}
?>

</div>
</div>

</body>
</html>

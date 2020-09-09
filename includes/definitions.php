<?php

// absolute Pfade angeben
define ('PASSWORT_AENDERN_SEITE','http://php.test/sessions+cookies/login3changepass.php');
define ('LOGINFORMULAR_SEITE','http://php.test/sessions+cookies/login.php');
define ('REGISTRIER_SEITE','http://php.test/sessions+cookies/registrieren.php');
define ('PASSWORT_VERGESSEN_SEITE','http://php.test/sessions+cookies/passwortvergessen.php');

// für crypt
define ('SALT','ef+oi(hh');

// setlocale (LC_TIME, 'de_DE.iso-8859-1');
// setlocale(LC_ALL,'de_DE.iso-8859-1','de_DE','de','ge');
date_default_timezone_set('Europe/Berlin');

// für leere Posts in Formularfeldern
define('DEFAULTWERT','n.n.');

// Admin-Rechte (zusätzlich auch über admin-Feld in DB regelbar)
// jeder der eingeloggt ist
// define('ZUGANG','jeder');
// nur admin hat Zugang: Mailadresse des Admin eintragen
define('ZUGANG','peter.mueller@c-major.de');
// für registrieren.php, falls Fragen
define('ADMINMAIL','peter.mueller@c-major.de');

// betrifft session+cookies
// live auf Null setzen...

define('FEHLERSUCHE','1');
header('Content-Type: text/html; charset=utf-8');

?>
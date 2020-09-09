<?php
$titel = "Registrieren";
$menuitem = 'sessions';


require '../../../files/php/login_web330.php';
require '../includes/definitions.php';
require '../includes/functions.php';
connect ();
session_start();
require '../includes/uebunghead.php';
require '../includes/uebungkopf.php';
require '../includes/uebungnavi.php';

print "<h1>$titel</h1>";

// Domain: reg_ registrieren

if (isset($_SESSION['login']) && $_SESSION['login']==1)
    {
    if (iswech('sent'))
        {
        if ($formularfehler = reg_validiere_formular())
            {
            reg_zeige_formular($formularfehler);
        } else {
            reg_verarbeite_formular();
        }
    } else {
        reg_zeige_formular();
    }
} else {
    print '<p>Bitte zuerst <a href="' . LOGINFORMULAR_SEITE . '">einloggen</a>!</p>';
}

function reg_zeige_formular($fehler = '')
    {
    print "<form method=\"POST\" action=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "\">\n";
    print "<fieldset>\n";
    print "\t<legend>Registrieren</legend>\n";
    if ($fehler) {
        print "<ul class=\"meldung\">\n";
        print "\t<li>" . implode("</li>\n\t<li>",$fehler) . "</li>\n";
        print "</ul>\n\n";
    }
    print "<table>\n";
    // Benutzername
    if (iswech('sent'))
        {
        input_text_post('mail', $_POST, 'Mailadresse');
        input_text_post('vorname', $_POST, 'Vorname');
        input_text_post('name', $_POST, 'Name');
    } else {
        input_text('mail', 'Mailadresse');
        input_text('vorname', 'Vorname');
        input_text('name', 'Name');
    }


    // Submit
    input_submit('absenden','Registrieren');

    print "</table>\n\n";
    input_hidden('sent');
    print "</fieldset>\n";
    print "</form>\n\n";
}

function reg_validiere_formular()
    {
    $fehler = array();
    if ($_SESSION['admin']!=1)
        {
        $fehler[]='Registrieren ist nur Admins gestattet.';
        return $fehler;
    }
    $postuser = mysql_real_escape_string($_POST['mail']);
    $abfrage = "select distinct user from studio_user where user = '$postuser'";
    $abfrage = mysql_query($abfrage);
    while ($liste = mysql_fetch_array($abfrage, MYSQL_ASSOC))
        {
        foreach ($liste as $inhalt)
            {
            $dbuser = $liste['user'];
        }
    }
    if (isset($dbuser) && $postuser == $dbuser)
        {
        $fehler[] = "Diese Mailadresse ist bereits registriert. Bitte gehe zur <a href=\"" . LOGINFORMULAR_SEITE . "\">Login-Seite</a>!";
        return $fehler;
    }
    if (strlen($_POST['mail']) > 100)
        {
        $fehler[] = 'Die Mail-Adresse ist zu lang';
    }
    if (strlen($_POST['vorname']) > 100)
        {
        $fehler[] = 'Der Vorname ist zu lang';
    }
    if (strlen($_POST['name']) > 100)
        {
        $fehler[] = 'Der Name ist zu lang';
    }
    $text = $_POST['mail'];
    // simples selbstgestricktes Muster
    $muster = '/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/';
    $at = preg_match($muster, $text);
    if (!$at)
        {
        $fehler[] = 'Bitte geben Sie eine gültige Mailadresse ein';
    }
    return $fehler;
}


function reg_verarbeite_formular()
    {
    // für die Datenbank
    $mail = mysql_real_escape_string($_POST['mail']);
    $vorname = mysql_real_escape_string($_POST['vorname']);
    $name = mysql_real_escape_string($_POST['name']);

    $kons = array (
        'B',
        'D',
        'F',
        'G',
        'K',
        'L',
        'M',
        'N',
        'P',
        'R',
        'S',
        'T',
        'V',
        'W',
        'Z');
    $voc = array (
        'E',
        'I',
        'O',
        'U');
    $k1 = rand(1,count($kons)) - 1;
    $k2 = rand(1,count($kons)) - 1;
    $k3 = rand(1,count($kons)) - 1;
    $v1 = rand(1,count($voc)) - 1;
    $v2 = rand(1,count($voc)) - 1;
    $v3 = rand(1,count($voc)) - 1;

    $pass = $kons[$k1] . $voc[$v1] . $kons[$k2] . $voc[$v2] . $kons[$k3] . $voc[$v3];
    // Mail senden
    $strEmpfaenger =& $mail;

    # Welchen Betreff soll die Mail erhalten?
    $strSubject  = 'Login';

    # Mail-Layout
    $kopf = "Hallo $vorname $name,\n";
    $inhalt = "vielen Dank für die Registrierung! Dein vorläufiges Passwort ist $pass. \nBitte gehe auf unsere Seite \n" . LOGINFORMULAR_SEITE . ", \nlogge Dich ein und ändere dann das Passwort!\n\nMailadresse/User:\t$mail\nPasswort:\t$pass\n\nFalls Du noch Fragen hast, wende Dich bitte an unseren Admin, " . ADMINMAIL . "!\n\n";
    $fuss = "Viele Grüße,\n\n\tPeter\n";
    $header = "From: " . ADMINMAIL . "\nReply-To: " . ADMINMAIL . "\nContent-type: text/plain; charset=ISO-8859-1\n";


    $mailtext = $kopf . $inhalt . $fuss;

    // abschicken
    // mail($strEmpfaenger, $strSubject, $mailtext, $header) or die("<p>Die Mail konnte nicht versendet werden. </p>");
    print "<p>Die eben gesandte Mail erhielt folgenden Text:</p>\n";
    print "<pre>An: $strEmpfaenger<br>\nBetreff: $strSubject<br>\nText: $mailtext\n(Header: $header)</pre>\n";

    // SALT siehe definitions.php
    $dbpass = crypt($pass,SALT);
    // pass_changed ist default 0;
    $insert = "insert into studio_user (user, vorname, name, pass) values ('$mail', '$vorname', '$name', '$dbpass')";
    mysql_query($insert);
    // debug
    $erfolgreich = mysql_affected_rows();
    $salat = mysql_client_encoding();
    $insert_id=mysql_insert_id();
    fehlersuche($erfolgreich,'txt','geänderte Zeilen');
    fehlersuche($salat,'txt','Encoding');
    fehlersuche($insert_id,'txt','ID');

    $tabelle = "select
        id,
        name as 'Name',
        vorname as 'Vorname',
        user as 'Mail (user)',
        admin as 'Admin',
        pass as 'Passwort(crypt)',
        pass_changed as 'geändert (p_c)'
        from studio_user
        where id=$insert_id";
    $tabelle=mysql_query($tabelle);
    mysql_out($tabelle,'Zuletzt eingetragener User:');
}

require '../includes/uebungfooter.php';
?>

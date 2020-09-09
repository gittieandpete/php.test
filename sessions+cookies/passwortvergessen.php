<?php
$titel = "Passwort vergessen";
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

// Domain pv_ Passwort vergessen

// testausgabe oder mailen?
$mailscharf = 0;

print "<p>
Seite für Leute, die das Passwort vergessen haben. Es wird geprüft, ob die Mailadresse eingetragen ist. Dann wird ein neues Passwort gebildet und an die Useradresse gemailt. pass_changed wird auf 0 gesetzt.
</p>\n\n";

// zugrunde liegende Logik für das Formular
if (iswech('sent'))
    {
    if ($formularfehler = pv_validiere_formular())
        {
        pv_zeige_formular($formularfehler);
    } else {
        pv_verarbeite_formular();
    }
} else
    {
    pv_zeige_formular();
}

// $fehler = '' ist default und wird z.B. durch zeige_formular($formularfehler) überschrieben
// mit dem Inhalt von $formularfehler
function pv_zeige_formular($fehler = '')
    {
    print "<form method=\"POST\" action=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "\">\n";
    print "<fieldset>\n";
    print "\t<legend>Passwort vergessen</legend>\n";
    if ($fehler) {
        print "<ul class=\"meldung\">\n";
        print "\t<li>" . implode("</li>\n\t<li>",$fehler) . "</li>\n";
        print "</ul>\n\n";
    }
    print "<table>\n";
    // Benutzername
    if (iswech('sent'))
        {
        input_text_post('user', $_POST, 'Mailadresse');
    } elseif (isset($_SESSION['user']))
        {
        input_text_post('user', $_SESSION, 'Mailadresse');
    } else {
        input_text('user', 'Mailadresse');
    }

    // Submit
    input_submit('absenden','Passwort anfordern');

    print "</table>\n\n";
    input_hidden('sent');
    print "</fieldset>\n";
    print "</form>\n\n";
}

function pv_validiere_formular()
    {
    $fehler = array();
    if (!isset($_POST['user']))
        {
        $fehler[]="<p>Bitte gib deine Mailadresse ein!</p>";
        return $fehler;
    }
    $user = mysql_real_escape_string($_POST['user']);
    $abfrage = "select distinct user from studio_user where user = '$user'";
    $abfrage = mysql_query($abfrage);
    while ($liste = mysql_fetch_array($abfrage, MYSQL_ASSOC))
        {
        foreach ($liste as $inhalt)
            {
            $dbuser = $liste['user'];
        }
    }
    if (!isset($dbuser))
        {
        $fehler[] = "Die Mailadresse ist noch nicht registriert. Bitte gehe auf die <a href=\"" . REGISTRIER_SEITE . "\">Registrier-Seite</a> oder wende dich an den Admin!";
    }
    return $fehler;
}


function pv_verarbeite_formular()
    {
    if (isset($_POST['user'])) $user = mysql_real_escape_string($_POST['user']);
    if (isset($_SESSION['user'])) $user = mysql_real_escape_string($_SESSION['user']);

    // 216000 Möglichkeiten
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
    $strEmpfaenger =& $user;

    # Welchen Betreff soll die Mail erhalten?
    $strSubject  = 'Neues Passwort';

    # Mail-Layout
    $kopf = "Hallo,\n";
    $inhalt = "Dein vorläufiges Passwort ist \n$pass. Bitte gehe auf unsere Seite \n" . LOGINFORMULAR_SEITE . "\nund ändere beim ersten Mal das Passwort!\n\nMailadresse: $user\nPasswort: $pass\n\n";
    $fuss = "Viele Grüße,\n\nPeter\n";

    $mailtext = $kopf . $inhalt . $fuss;

    if ($GLOBALS['mailscharf']==1)
        {
        // abschicken
        mail($strEmpfaenger, $strSubject, $mailtext) or die ("<p>Die Mail konnte nicht versendet werden. </p>");
    } else	{
        print "An: $strEmpfaenger<br>\nBetreff: $strSubject<br>\nText: $mailtext<br>";
    }

    $dbpass = crypt($pass,SALT);
    $update = "update studio_user set pass = '$dbpass', pass_changed = '0' where user = '$user' limit 1";
    $ok = mysql_query($update);
    if ($ok)
        {
        print "<p class=\"meldung\">Ein neues Passwort ist generiert worden und per Mail unterwegs die angegebene Adresse.</p>\n\n";
    } else {
        print "<p class=\"meldung\">Ein Fehler ist passiert. Bitte probiere es nochmals oder wende dich per Mail an peter.mueller@c-major.de</p>\n\n";
        pv_zeige_formular();
    }
}

fehlersuche($_SESSION,'ul','Session:');
fehlersuche($_POST,'ul','Post');

require '../includes/uebungfooter.php';
?>

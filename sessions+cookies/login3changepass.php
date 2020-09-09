<?php
$titel = "Passwort ändern";
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

// Domain: cp_ change pass

if (isset($_SESSION['login']))
    {
    if ($_SESSION['login']==1 && $_SESSION['p_c']==0)
        {
        print "<p>Hallo " . $_SESSION['vorname'] . ", <br>du solltest hier dein Passwort ändern - das alte wurde per Mail verschickt und ist nicht sicher.</p>";
    }
}

if (isset($_SESSION['login']) && $_SESSION['login']==1)
    {
    if (iswech('sent'))
        {
        if ($formularfehler = cp_validiere_formular())
            {
            cp_zeige_formular($formularfehler);
        } else {
            cp_verarbeite_formular();
        }
    } else
        {
        cp_zeige_formular();
    }
} else {
    print '<p>Bitte zuerst <a href="' . LOGINFORMULAR_SEITE . '">einloggen</a>!</p>';
}

fehlersuche($_POST,'ul','Inhalt von $_POST');
fehlersuche($_SESSION,'ul','Inhalt von $_SESSION');

############## functions ####################

// $fehler = '' ist default und wird z.B. durch zeige_formular($formularfehler) überschrieben
// mit dem Inhalt von $formularfehler
function cp_zeige_formular($fehler = '')
    {
    print "<form method=\"POST\" action=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "\">\n";
    print "<fieldset>\n";
    print "\t<legend>Passwort ändern</legend>\n";
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

    // altes Passwort
    input_passwort('pass_old', 'altes Passwort');
    // Passwort
    input_passwort('passwort', 'neues Passwort');
    input_passwort('passwort_control', 'neues Passwort');
    // Submit
    input_submit('absenden','Passwort ändern');

    print "</table>\n\n";
    input_hidden('sent');
    print "</fieldset>\n";
    print "</form>\n\n";
}

function cp_validiere_formular() {
    $fehler = array();
    // Positiv-Liste
    $abfrage2 = mysql_query("select user, pass from studio_user");
    while ($liste2 = mysql_fetch_array($abfrage2, MYSQL_ASSOC))
        {
        foreach ($liste2 as $inhalt)
            {
            $user = $liste2['user'];
            $pass = $liste2['pass'];
        }
        // Array herstellen, wie ich es unten brauche
        // z.B. $user[peter@c-major.de] => 'peterspasswort'
        $userliste[$user] = $pass;
    }
    fehlersuche($userliste,'ul','abgefragte user: ');
    // Sicherstellen, dass der Benutzername gültig ist
    $fehlermeldung = 'Bitte geben Sie einen gültigen Benutzernamen und ein gültiges Passwort ein.';
    if (!array_key_exists($_POST['user'], $userliste))
        {
        $fehler[0] = $fehlermeldung;
    } elseif ($userliste[$_POST['user']] != crypt($_POST['pass_old'],SALT))
        {
        // Prüfen, ob das Passwort korrekt ist
        // gespeichertes Passwort = $userliste[$_POST['user']];
        // Fehlermeldung gleich+wird ggf. überschrieben, erlaubt keine Rückschlüsse
        $fehler[0] = $fehlermeldung;
    }
    if ($_POST['passwort'] != $_POST['passwort_control'])
        {
        $fehler[] = "Bitte geben Sie zwei mal dasselbe neue Passwort ein!";
    }
    return $fehler;
}


function cp_verarbeite_formular()
    {
    $_SESSION['p_c'] = 1;
    $user = $_SESSION['user'];
    $frage3 = "select vorname, name from studio_user where user = '$user'";
    $frage3	= mysql_query($frage3);
    // fehlersuche($frage3,'mysql','Mysql Frage3');
    // Vorsicht, Zeiger nach fehlersuche ist hinten, die while-Schleife liefert dann nichts.
    while ($liste3 = mysql_fetch_array($frage3, MYSQL_ASSOC))
            {
            foreach ($liste3 as $inhalt)
                {
                $vorname = $liste3['vorname'];
                $name = $liste3['name'];
            }
    }
    $dbpass = crypt($_POST['passwort'],SALT);
    $abfrage4 = "update studio_user set pass = '$dbpass', pass_changed = '1' where user = '$user' limit 1";
    $ok = mysql_query($abfrage4);
    if ($ok)
        {
        print "<p class='meldung'>Hallo " . htmlentities($vorname) . ' ' . htmlentities($name) . ", <br><strong>das Passwort</strong> für $user <strong>wurde erfolgreich geändert</strong>!</p>\n\n";
    } else {
        print "Ein Fehler (Db + Passwort ändern) ist passiert. Bitte versuch es noch mal oder wende dich per Mail an peter.mueller@c-major.de!";
        zeige_formular();
    }
}
require '../includes/uebungfooter.php';
?>

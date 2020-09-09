<?php
$titel="Login";
$menuitem='sessions';


require '../../../files/php/login_web330.php';
require '../includes/definitions.php';
require '../includes/functions.php';
connect ();
session_start();
require '../includes/uebunghead.php';
require '../includes/uebungkopf.php';
require '../includes/uebungnavi.php';

print "<h1>$titel</h1>";

// gesetzte Variablen

if (!isset ($_SESSION['login']))
    {
    $_SESSION['login']=0;
    $_SESSION['logout']=1;
    $_SESSION['p_c']=0;
}

// Login
if (iswech('weg') && $_SESSION['login']==0)
    {
    if ($formularfehler=sc_validiere_login())
        {
        fehlersuche('<p>1. validiere login</p>', 'txt');
        sc_zeige_login($formularfehler);
    } else {
        fehlersuche('<p>2. else verarbeite login</p>', 'txt');
        sc_verarbeite_login();
    }
} elseif ($_SESSION['login']==0 )
    {
    fehlersuche('<p>3. elseif zeige login</p>', 'txt');
    sc_zeige_login();
    print "<ul>";
    print "<li><a href=\"" . PASSWORT_VERGESSEN_SEITE . "\">Passwort vergessen?</a></li>";
    print "</ul>";
}

if ($_SESSION['login']==1)
    {
    print "<p class=\"meldung\">Hallo " . $_SESSION['vorname']. "!</p>\n\n";
}

// Logout

if (iswech('logout') && $_SESSION['logout']==0)
    {
    if ($formularfehler=sc_validiere_logout())
        {
        fehlersuche($formularfehler,'txt','Fall 1, Fehler Logoutformular');
        sc_zeige_logout($formularfehler);
    } else	{
        fehlersuche('verarbeite logout','txt');
        sc_verarbeite_logout();
    }
} elseif ($_SESSION['logout']==0)
    {
fehlersuche('Session "logout"==0','txt','Fall 3, Logoutformular');
sc_zeige_logout();
}


fehlersuche ($_POST,'ul','Post-Daten');
fehlersuche ($_SESSION,'ul','Session-Daten');

print "<ul>
<li>htmlentities() hinzugefügt; </li>
<li>Die Functions brauchen jetzt einen Feldnamen, die $_POST-Werte und ein Label. </li>
<li>Nachträglich eingebaut: die Abfrage nach pass_changed. Wenn 0, dann redirect auf die entsprechende Seite. </li>
<li>Wichtig: <strong>keys für Session und Post müssen übereinstimmen</strong> (wegen der Ausgabe in einigen Formularen)</li>
<li>Domain (sc_ session+cookies) für die functions hinzugefügt</li>
<li>crypt statt md5, viel sicherer</li>
<li>Login-Logout-Logik verbessert</li>
<li>hidden-Feld function verallgemeinert</li>
<li>Fehlerfunktion hinzugefügt, über definitions ein- und ausschalten</li>
</ul>\n\n";

// Domain: sc_ session+cookies

// salt siehe definitions.php


// test für crypt und konstante

define('PASS','1234');
define('SALTTEST','xy_verschieden');

print "<p>bei geändertem 'SALTTEST' sollte sich ja auch der hash ändern! Außerdem gibt der Algorithmus die ersten 2 Stellen des SALT zurück, daran kann man auch sehen, ob alles richtig ist. 'SAirgendwas ist also falsch.</p>";
out(PASS,'richtig');
out(SALTTEST,'richtig');
out(PASS,'keine hochkommata, richtig: ');
out('SALTTEST','hochkommata, falsch: ');

$test1=crypt(PASS,SALTTEST);
$test2=crypt('PASS','SALTTEST');

out($test1,'richtig');
out($test2,'falsch');


$select = "select id,name as 'Name',vorname as 'Vorname',user as 'Mail (user)',admin as 'Admin',pass as 'Passwort(crypt)',pass_changed as 'geändert (p_c)' from studio_user order by name,vorname";
$tab = mysql_query($select);
fehlersuche($tab,'mysql','Kleiner Überblick');
fehlersuche('Fehlersuche verdirbt den header!','txt');




// $fehler='' ist default und wird z.B. durch sc_zeige_login($formularfehler) überschrieben mit dem Inhalt von $formularfehler
function sc_zeige_login($fehler='')
    {
    print "<form method=\"POST\" action=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "\">\n";
    print "<fieldset>\n";
    print "\t<legend>Login</legend>\n";
    if ($fehler) {
        print "<ul class=\"meldung\">\n";
        print "\t<li>" . implode("</li>\n\t<li>",$fehler) . "</li>\n";
        print "</ul>\n\n";
    }
    print "<table>\n";
    // Benutzername
    input_text('benutzer', 'Mailadresse');
    // Passwort
    input_passwort('passwort', 'Passwort');
    // Submit
    print "\t<tr>\n";
    input_submit('absenden','Login');
    print "\t</tr>\n\n";
    print "</table>\n\n";
    // Defaultwert für den Feldnamen ist 'abgeschickt';
    input_hidden('weg');
    print "</fieldset>\n";
    print "</form>\n\n";
}

function sc_validiere_login()
    {
    $fehler=array();
    $fehler=sc_validiere_post($_POST,$fehler);
    // Positiv-Liste
    $abfrage=mysql_query("select user, pass, pass_changed from studio_user");
    while ($liste=mysql_fetch_array($abfrage, MYSQL_ASSOC))
        {
        foreach ($liste as $inhalt)
            {
            $benutzer=$liste['user'];
            $pass=$liste['pass'];
            $pass_changed=$liste['pass_changed'];
        }
        // Array herstellen, wie ich es unten brauche
        // z.B. $benutzer[peter] => 'peterspasswort'
        $user[$benutzer]=$pass;
        $p_c[$benutzer]=$pass_changed;
    }
    fehlersuche($user, 'ul', 'validiere Login, User');
    fehlersuche($p_c, 'ul', 'validiere Login, Pass changed');
    $fehlermeldung='Bitte gib einen gültigen Benutzernamen und ein gültiges Passwort ein.';
    if (isset($_POST['benutzer']) && isset($user))
        {
        // Sicherstellen, dass der Benutzername gültig ist
        if (! array_key_exists($_POST['benutzer'], $user))
            {
            $fehler[1]=$fehlermeldung;
        } elseif ($user[$_POST['benutzer']] != crypt($_POST['passwort'],SALT))
            // Prüfen, ob das Passwort korrekt ist
            // gespeichertes Passwort=$user[$_POST['benutzer']];
            {
            // Fehlermeldung gleich+wird ggf. überschrieben, erlaubt keine Rückschlüsse
            fehlersuche($user[$_POST['benutzer']],'ul','Post[benutzer]');
            $crypt=crypt($_POST['passwort'],SALT);
            fehlersuche($crypt,'txt','Passwort+crypt+salt');
            $fehler[1]=$fehlermeldung;
        }
    } else	{
        $fehler[1]=$fehlermeldung . 'else+debug';
    }
    return $fehler;
}

function sc_verarbeite_login()
    {
    // siehe http://www.web-tuts.de/php-session-sicherheit-session-fixation.html
    session_regenerate_id();
    // Muss das Passwort geändert werden?
    $user=mysql_real_escape_string($_POST['benutzer']);
    $frage3="select user, vorname, name, pass_changed, admin from studio_user where user='$user'";
    $frage3	= mysql_query($frage3);
    while ($liste3=mysql_fetch_array($frage3, MYSQL_ASSOC))
            {
            foreach ($liste3 as $inhalt)
                {
                $user=$liste3['user'];
                $vorname=$liste3['vorname'];
                $name=$liste3['name'];
                $p_c=$liste3['pass_changed'];
                $admin=$liste3['admin'];
            }
    }
    // Der Session den Benutzernamen hinzufügen
    // wichtig: POST und SESSION müssen dieselben keys haben;
    // also, wenn 'benutzer' bei $_SESSION, dann auch 'benutzer' bei $_POST.
    // Brauche ich für die Rückgabe von bereits eingegebenen Werten in Formularen.
    // benutzer eingeloggt
    $_SESSION['login']=1;
    $_SESSION['user']=$user;
    $_SESSION['name']=$name;
    $_SESSION['vorname']=$vorname;
    $_SESSION['logout']=0;
    $_SESSION['p_c']=$p_c;
    $_SESSION['admin']=$admin;
    if ($p_c==0)
        {
        // Redirect-Ziel
        header("Location: " . PASSWORT_AENDERN_SEITE . "");
    }

}

// prüft nur Länge und Null-string. Ändert nicht $_POST
function sc_validiere_post($post,$fehler)
    {
    foreach($post as $key => $value)
        {
        if (strlen($value) > 300)
            {
            $fehler[]="Die Eingabe <pre>'" . htmlentities(substr($value, 0, 50)) . "...'</pre> ist zu lang.";
        }
        if (strlen(trim($value))==0)
            {
            $fehler[]="Bitte gib etwas ein ins Feld &bdquo;" . htmlentities(substr($key, 0, 50)) . "&ldquo;!";
        }
        if (strlen($key) > 300 || strlen(trim($key))==0)
            {
            $fehler[]="Bitte fülle das Formular richtig aus!";
        }
    }
    return $fehler;
}

function sc_validiere_logout()
    {
    if (isset($_POST['logout']) &&  $_POST['logout'] != 1)
        {
        $formularfehler='Der Logout hat nicht funktioniert.';
    }
}

function sc_verarbeite_logout()
    {
    // testen (1.10.2014):
    // session_destroy();
    unset($_SESSION['user'], $_SESSION['name'], $_SESSION['vorname'], $_SESSION['admin'], $_SESSION['p_c']);
    $_SESSION['login']=0;
    $_SESSION['logout']=1;
    // Redirect-Ziel
    header("Location: " . LOGINFORMULAR_SEITE . "");
}


function sc_zeige_logout()
    {
    print "<form method=\"POST\" action=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "\">\n";
    print "<fieldset>\n";
    print "\t<legend>Logout</legend>\n";
    print "<table>\n";
    input_submit('abmelden','Logout');
    print "</table>\n\n";
    input_hidden('logout');
    print "</fieldset>\n";
    print "</form>\n\n";
}


require '../includes/uebungfooter.php';
?>

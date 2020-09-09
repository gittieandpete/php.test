<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

################ Einrichtung ###########################
// Einrichtung des Formulars - bitte lösche mail@abc.de und trage dafür deine Mailadresse ein!

define('EIGENEMAIL','borumat@gmx.de');
################ Einrichtung fertig! ########################

print <<<HTML
<!DOCTYPE HTML>
<html lang="de">
<head>
<title>Kontaktformular</title>
<meta	charset="utf-8">
<meta	name="author"	content="Peter Müller, Andreas Borutta">
<style>
.bor_meldung
    {
    color:	red;
    font-weight:	bold;
}
#bor_versenkung
    {
    display: none;
}
</style>
</head>

<body>
HTML;


// Titel des Formulars
define('FORMULARTITEL','Kontaktformular');
// an welche Adresse soll die Nachricht aus dem Formular geschickt werden?
define('BETREFF_CHEF','Mail vom Kontaktformular auf ' . htmlspecialchars($_SERVER['HTTP_HOST']));
// Fehlermeldungen (nicht löschen, ggf. Text ändern)
define('MAILADRESSEFEHLT','Bitte geben Sie eine Mailadresse ein!');
define('NACHRICHTFEHLT','Bitte geben Sie etwas ins Nachrichtenfeld ein!');
define('TELFEHLT','Bitte geben Sie eine Telefonnummer an (optional)!');
// Feldnamen - nicht löschen, nur Text ändern möglich!
define('TEL','Telefon');
define('MAILABSENDER','E-Mail');
define('NACHRICHT','Nachricht');
// weiterer Text
define('MAILVERSENDET','Vielen Dank! Ihre Mail wurde erfolgreich versandt.');
define('MAILNICHTVERSENDET','Die Mail konnte nicht versendet werden.');
// Text der Überschrift über dem einzugebenden Nachrichtentext
define('IHRENACHRICHT','Ihre Nachricht');
define('SENDEN','Senden');
// Testmodus auf an (1) oder aus (0) setzen. Bei '0' werden Mails versandt, bei '1' werden sie auf der Seite selbst angezeigt zum Testen
$testmodus = 0;
// im Testmodus ist das HTML nicht standardkonform
// soll auf das Vorhandensein einer Mailadresse geprüft werden? Ja, dann 1 eintragen; Nein, dann 0 eintragen.
// prf=Prüfung. Prüfung auf:
$prf_mailabsenderadresse = 1;
$prf_nachricht = 1;
// sollte in functions stehen, allgemein
mb_internal_encoding('UTF-8');
// für mb_send_mail http://www.php.net/manual/de/function.mb-language.php
mb_language('uni');

################ Version #################
/*
Version 1.14 Vereinfachte Fassung (2 bis 3 Felder) nach Andreas Borutta
Version 1.13 Viele Doku-Texte hinzugefügt. require auskommentiert, damit das Formular auch standalone funktioniert. Regex Mailadresse verbessert. input types hinzugefügt
Version 1.12 + sleep für höhere Sicherheit.
Version 1.11 zusätzliche Prüfung auf eingegebenen (Nach-)Namen und Ort; functions sind wieder hier in dieser Datei, ist praktischer
Version 1.10 mb_send_mail, formatierter Mailbody (wordwrap), \r\n statt \n (laut RFC), content-transfer-encoding 8bit gesetzt (http://tools.ietf.org/html/rfc2045#section-6.1);
Version 1.09 (pianoforte-Version). Mailadresse wird überprüft. Alle Felder vorhanden. Anrede und weiterer Formulartext als Konstanten im Formular verwandt, leicht übersetzbar (1 function für alle Sprachen).
Version 1.08 (Versionssprung wegen Namensgleichheit mit der Kurzversion) $_SERVER['PHP_SELF'] abgesichert, Anrede-PostWert wird geprüft
Version 1.06 ohne E-Mail Feld
Version 1.05 Prüfung auf E-Mail Absenderadresse abwählbar (siehe Einrichtung)
Version 1.04 Feld 'Anrede' als checkbox.
Version 1.03 Feld 'Anrede' hinzugefügt; Texte änderbar gemacht
Version 1.02 HTML-Fehler beseitigt (post statt POST), CSS verbessert
Version 1.01 Doctype-spezifische Endung für input /> hinzugefügt.

benötigt folgende functions (s.u.):
bor_formatiere
bor_input_submit
bor_input_text
bor_input_text_post
bor_textarea
bor_textarea_post
validiere_mailformular
verarbeite_mailformular
versenkung
zeige_mailformular
*/
################ Ende Version #################


if (!array_key_exists('abgeschickt',$_SESSION))
    {
    $_SESSION['abgeschickt'] = 0;
    $_SESSION['sleep'] = 1;
}

// zugrunde liegende Logik für das Formular
// wenn $_SESSION['challenge'] nicht stimmt, wird bei F5 (aktualisieren im Browserfenster) _nach_ dem Abschicken ein neues Formular angezeigt, und nicht das alte wieder und wieder versandt.
if (array_key_exists('abgeschickt', $_POST) && array_key_exists('challenge', $_SESSION) && $_POST['abgeschickt'] == $_SESSION['challenge'])
    {
    // wenn $formularfehler nicht gleich Null ist, (Null=falsch), wird das Formular mit den Fehlern wieder angezeigt
    if ($formularfehler = validiere_mailformular())
        {
        zeige_mailformular($formularfehler);
    } else {
        // wenn keine Fehler vorhanden sind, werden die eingegebenen Daten verarbeitet
        verarbeite_mailformular();
    }
} else {
    zeige_mailformular();
}

if ($testmodus==1)
    {
    // Zur Info soll der Dateiname dieser Datei ausgegeben werden
    $this_file = pathinfo($_SERVER['PHP_SELF'])['basename'];
    // wenn $testmodus==1, wird keine Mail versandt. Die Mail erscheint auf der Seite
    print "<p>Testmodus ist an, die Formulardaten von $this_file werden hier ausgegeben. Es wird keine Mail verschickt.</p>";
}

function zeige_mailformular($fehler = '')
    {
    if (!array_key_exists('challenge', $_SESSION)  && $_SESSION['abgeschickt'] != 1)
        {
        $_SESSION['challenge'] = rand(2,1000);
        $_SESSION['sleep'] = 1;
    }
    print '<h2>' . FORMULARTITEL . '</h2>' . "\n";
    // 'PHP_SELF' sorgt dafür, dass das Formular dieselbe Seite wieder aufruft, auf der das Formular sich befindet
    print '<form class="mailform" method="post" accept-charset="UTF-8" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '">' . "\n";
    print "<fieldset>\n";
    print "\t<legend>" . IHRENACHRICHT . "</legend>\n";
    if ($fehler) {
        print "<ul class=\"bor_meldung\">\n";
        print "\t<li>" . implode("</li>\n\t<li>",$fehler) . "</li>\n";
        print "</ul>\n\n";
    }
    print "<table class=\"bor_kontakt\">\n\n";
    // wenn schon versandt, soll nach F5 ein leeres Formular angezeigt werden.
    if (isset($_POST['abgeschickt']) && $_POST['abgeschickt'] == $_SESSION['challenge'])
        {
        // $feldname, $werte, $label = 'Eingabe', $type = 'text'
        bor_input_text_post('bor_telefon',$_POST,TEL,'tel');
        bor_input_text_post('zfh3k_feld',$_POST,MAILABSENDER,'email');
        // name, POST, Label, rows, cols
        bor_textarea_post('bor_nachricht',$_POST,NACHRICHT,'8','35');
        } else {
        bor_input_text('bor_telefon',TEL,'tel');
        bor_input_text('zfh3k_feld',MAILABSENDER,'email');
        // name, Label, rows, cols
        bor_textarea('bor_nachricht',NACHRICHT,'8','35');
    }

    // Submit
    bor_input_submit('absenden',SENDEN);

    print "</table>\n\n";
    // POST['abgeschickt'] bekommt den Wert von SESSION['challenge']
    print '<input type="hidden" name="abgeschickt" value="' . $_SESSION['challenge'] . '">' . "\n";
    // per css ausgeblendet, für die robots
    // mailto sieht der Robot, füllt was aus, und dann wird die Mail nicht verschickt.
    print '<input id="bor_versenkung" name="mailto">' . "\n";
    print "</fieldset>\n";
    print "</form>\n\n";
}

function validiere_mailformular()
    {
    global $prf_mailabsenderadresse,
        $prf_nachricht
    ;
    if ($versenkung = bor_formatiere($_POST['mailto']))
        {
        // $versenkung ist display:none per CSS und wird von keinem Menschen ausgefüllt
        // $versenkung sollte im Testmodus zu sehen sein
        versenkung();
        return;
    }

    $fehler = array();
    if (strlen(trim($_POST['zfh3k_feld'])) > 500)
        {
        $fehler[0] = MAILADRESSEFEHLT;
    }
    if(strlen(trim($_POST['bor_telefon'])) == 0 && strlen(trim($_POST['zfh3k_feld'])) == 0)
        {
        $fehler[0] = MAILADRESSEFEHLT;
        $fehler[] = TELFEHLT;
    }

    if ($prf_mailabsenderadresse && strlen(trim($_POST['bor_telefon'])) == 0)
        {
        $text = trim($_POST['zfh3k_feld']);
        // Muster, das auch die Browser intern benutzen
        $muster = '/[a-zA-Z0-9.!#$%&’*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*/';
        $at = preg_match($muster,$text);
        if (!$at)
            {
            // überschreibt die erste Fehlermeldung, ein Meldungstext reicht
            $fehler[0] = MAILADRESSEFEHLT;
        }
    }
    if ($prf_nachricht)
        {
        if(strlen(trim($_POST['bor_nachricht'])) == 0)
            {
            $fehler[] = NACHRICHTFEHLT;
        }
    }

    // erneutes Ausfüllen soll immer länger dauern. Spamabwehr
    $wait=$_SESSION['sleep']=$_SESSION['sleep']+0.2;
    sleep(intval($wait));
    return $fehler;
}

function verarbeite_mailformular()
    {
    $telefon = bor_formatiere($_POST['bor_telefon']);
    $absender = bor_formatiere($_POST['zfh3k_feld']);
    $nachricht = bor_formatiere($_POST['bor_nachricht']);

    $strEmpfaenger = EIGENEMAIL;

    $strSubject  = BETREFF_CHEF;

    $datum = date('d F Y H:i:s');

    # Mail-Layout

    $kopf = "Tel:\t$telefon\r\nMail:\t$absender\r\n--  \r\n";
    $inhalt = "$nachricht\r\n--  \r\n";
    $fuss ="Datum:\t$datum";

    $mailbody =
        $kopf .
        $inhalt .
        $fuss;

    $header = "From: " . FORMULARTITEL . "\r\nContent-type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\n";

    // abschicken
    if ($GLOBALS['testmodus']==0)
        {
        mb_send_mail (
            $strEmpfaenger,
            $strSubject,
            $mailbody,
            $header)
        or die ("<p>" . MAILNICHTVERSENDET . "</p>\n\n");
        print "<p class=\"bor_meldung\">" . MAILVERSENDET . "</p>\n\n";
    } elseif ($GLOBALS['testmodus']==1)
        {
        print "<h3>Mail verarbeitet, Testmodus ist an.</h3>\n\n";
        print "<pre>Empfänger:\t$strEmpfaenger\nBetreff:\t$strSubject\nBody der Mail:\n$mailbody\nHeader der Mail:\n$header</pre>";
    } else {
        print "<p>Bitte das Formular einrichten: Testmodus auf 1 oder 0 setzen!</p>";
    }
    // sorgt für die falsche challenge bei F5 ($_POST bleibt, $_SESSION ändert sich)
    $_SESSION['challenge'] = rand(2,1000);
    // (leeres Formular nach F5)
    $_SESSION['abgeschickt'] = '1';
}

function versenkung()
    {
    print 	"<h2 class=\"bor_meldung\">
            Vielen Dank! Ihre Mail wurde soeben versandt!
            </h2>";
    // sorgt für die falsche challenge ($_POST bleibt, $_SESSION ändert sich)
    $_SESSION['challenge'] = rand(2,1000);
}

// Ein input-(text,email)-feld ausgeben mit $_POST-Werten
function bor_input_text_post($feldname, $werte, $label = 'Eingabe', $type = 'text')
    {
    print "\t<tr>\n\t<td class=\"bor_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><input type=\"$type\" name=\"$feldname\" id=\"$feldname\" value=\"" . htmlspecialchars(substr($werte[$feldname],0,300),ENT_QUOTES,'UTF-8') .  "\" size=\"25\" maxlength=\"100\"></td>\n";
    print "\t</tr>\n\n";
}

// Ein input-(text,email)-feld ausgeben ohne $_POST-Werte
function bor_input_text($feldname, $label= 'Eingabe', $type = 'text')
    {
    print "\t<tr>\n\t<td class=\"bor_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><input type=\"$type\" name=\"$feldname\" id=\"$feldname\" size=\"25\" maxlength=\"100\"";
    print "></td>\n";
    print "\t</tr>\n\n";
}

// Ein input-(number)-feld ausgeben mit $_POST-Werten
// PLZ zwischen 0 und 99.999
function bor_input_number_post($feldname, $werte, $label = 'Eingabe', $min = '0', $max = '99999', $step = '1')
    {
    print "\t<tr>\n\t<td class=\"bor_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><input type=\"number\" name=\"$feldname\" id=\"$feldname\" value=\"" . htmlspecialchars(substr($werte[$feldname],0,300),ENT_QUOTES,'UTF-8') .  "\" size=\"25\" min=\"$min\" max=\"$max\"></td>\n";
    print "\t</tr>\n\n";
}

// Ein input-(number)-feld ausgeben ohne $_POST-Werte
function bor_input_number($feldname, $label = 'Eingabe', $min = '0', $max = '99999', $step = '1')
    {
    print "\t<tr>\n\t<td class=\"bor_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><input type=\"number\" name=\"$feldname\" id=\"$feldname\" size=\"25\" min=\"$min\" max=\"$max\"";
    print "></td>\n";
    print "\t</tr>\n\n";
}

// Eine Textarea ausgeben mit $_POST-Werten
function bor_textarea_post($feldname, $werte, $label = 'Text', $rows = '1', $cols = '20')
    {
    print "\t<tr>\n\t<td class=\"bor_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><textarea name=\"$feldname\" id=\"$feldname\" rows=\"$rows\" cols=\"$cols\">" . htmlspecialchars(substr($werte[$feldname],0,1000),ENT_QUOTES,'UTF-8') . "</textarea></td>\n";
    print "\t</tr>\n\n";
}

// Eine Textarea ausgeben ohne $_POST-Werte
function bor_textarea($feldname, $label= 'Text', $rows = '1', $cols = '20')
    {
    print "\t<tr>\n\t<td class=\"bor_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><textarea name=\"$feldname\" id=\"$feldname\" rows=\"$rows\" cols=\"$cols\">";
    print "</textarea></td>\n";
    print "\t</tr>\n\n";
}

// Einen Absenden-Button ausgeben
function bor_input_submit($feldname, $label = 'Absenden')
    {
    print "\t<tr>\n";
    print "\t<td></td>\n";
    print "\t<td><input type=\"submit\" name=\"$feldname\" id=\"$feldname\" value=\"$label\"></td>\n";
    print "\t</tr>\n\n";
}

function bor_formatiere ($text)
    {
    $text = substr ($text, 0, 2000);
    $text = strip_tags (trim ($text));
    $text = wordwrap ($text,75,"\r\n",75);
    return $text;
}

function bor_debug($fehler)
    {
    print '<pre>' . "\n\t";
    print_r($fehler);
    print "\n" . '</pre>' . "\n\n";
}

?>

</body>
</html>
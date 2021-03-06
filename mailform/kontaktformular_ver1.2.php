<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

// die folgenden Funktionen braucht man nur, um es in bestehende Projekte einzubinden
// require '../includes/definitions.php';
// require '../includes/functions.php';

// require '../includes/uebunghead.php';
// require '../includes/uebungkopf.php';
// require '../includes/uebungnavi.php';

// PHP Here-Form. Löschen oder auskommentieren, wenn man es in andere Projekte einbindet.
print <<<HTML
<!DOCTYPE HTML>
<html lang="de">
<head>
<title>Mailformular</title>
<meta	charset="utf-8">
<meta	name="author"	content="Peter Müller">
<style>
.domain_meldung
    {
    color:	red;
    font-weight:	bold;
}
</style>
</head>

<body>
HTML;
// Ende Here-Form

// bestimmte Variablen ausgeben, damit man eventuelle Fehler erkennt
dev_debug($_SESSION);
// dev_debug($_SERVER);

// sicherstellen, dass
mb_internal_encoding('UTF-8');
// für mb_send_mail http://www.php.net/manual/de/function.mb-language.php
mb_language('uni');
// (global in der Haupt-functions-Datei gesetzt sind
// dann obiges ebenfalls löschen

################ Version #################
/*
Version 1.2.1 Umgestellt auf Layout ohne <table>
Version 1.2   Regex Mailadresse verbessert. input types hinzugefügt
Version 1.1.3 Viele Doku-Texte hinzugefügt. require auskommentiert, damit das Formular auch standalone funktioniert.
Version 1.1.2 + sleep für höhere Sicherheit.
Version 1.1.1 zusätzliche Prüfung auf eingegebenen (Nach-)Namen und Ort; functions sind wieder hier in dieser Datei, ist praktischer
Version 1.1.0 mb_send_mail, formatierter Mailbody (wordwrap), \r\n statt \n (laut RFC), content-transfer-encoding 8bit gesetzt (http://tools.ietf.org/html/rfc2045#section-6.1);
Version 1.0.9 (pianoforte-Version). Mailadresse wird überprüft. Alle Felder vorhanden. Anrede und weiterer Formulartext als Konstanten im Formular verwandt, leicht übersetzbar (1 function für alle Sprachen).
Version 1.0.8 (Versionssprung wegen Namensgleichheit mit der Kurzversion) $_SERVER['PHP_SELF'] abgesichert, Anrede-PostWert wird geprüft
Version 1.0.6 ohne E-Mail Feld
Version 1.0.5 Prüfung auf E-Mail Absenderadresse abwählbar (siehe Einrichtung)
Version 1.0.4 Feld 'Anrede' als checkbox.
Version 1.0.3 Feld 'Anrede' hinzugefügt; Texte änderbar gemacht
Version 1.0.2 HTML-Fehler beseitigt (post statt POST), CSS verbessert
Version 1.0.1 Doctype-spezifische Endung für input /> hinzugefügt.

benötigt folgende functions (s.u.):
dev_debug
dev_formatiere
dev_input_number
dev_input_number_post
dev_input_submit
dev_input_text
dev_input_text_post
dev_textarea
dev_textarea_post
validiere_mailformular
verarbeite_mailformular
versenkung
zeige_mailformular
*/
################ Ende Version #################

################ Einrichtung ###########################
// Einrichtung des Formulars - bitte den Text, nicht die Konstante, wie gewünscht anpassen
// Beispiel define('KONSTANTE_NICHT_AENDERN','Text kannst du ändern');
// $testmodus später auf 0 setzen.

// Titel des Formulars
define('FORMULARTITEL','Mailformular');
// an welche Adresse soll die Nachricht aus dem Formular geschickt werden?
define('EIGENEMAIL','peter.mueller@c-major.de');
// welchen Betreff soll die Mail erhalten, die an dich geschickt wird? (das ist nicht der Betreff, den die Leute angeben)
define('BETREFF_CHEF','Mail vom Kontaktformular auf ' . htmlspecialchars($_SERVER['HTTP_HOST']));
// Fehlermeldungen (nicht löschen, ggf. Text ändern)
define('MAILADRESSEFEHLT','Bitte geben Sie eine Mailadresse ein, damit wir Ihnen antworten können!');
define('NACHRICHTFEHLT','Bitte geben Sie etwas ins Nachrichtenfeld ein!');
define('NAMEFEHLT','Bitte tragen Sie Ihren Nachnamen ein!');
define('ORTFEHLT','Bitte geben Sie einen Ort an!');
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
// Text der Überschrift über dem einzugebenden Nachrichtentext
define('IHRENACHRICHT','Ihre Nachricht');
define('HERR','Herr');
define('FRAU','Frau');
define('SENDEN','Senden');
// Testmodus auf an (1) oder aus (0) setzen. Bei '0' werden Mails versandt, bei '1' werden sie auf der Seite selbst angezeigt zum Testen
$testmodus = 0;
// im Testmodus ist das HTML nicht standardkonform
// soll auf das Vorhandensein einer Mailadresse geprüft werden? Ja, dann 1 eintragen; Nein, dann 0 eintragen.
// prf=Prüfung. Prüfung auf:
$prf_mailabsenderadresse = 1;
$prf_name = 0;
$prf_ort = 0;
$prf_nachricht = 1;


################ Einrichtung fertig! ########################

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
    print "<p>Testmodus ist an, die Formulardaten von $this_file werden hier ausgegeben.</p>";
    // Mails auf dem Testsystem (Debian) landen in /var/mail/www-data.
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
        print "<ul class=\"domain_meldung\">\n";
        print "\t<li>" . implode("</li>\n\t<li>",$fehler) . "</li>\n";
        print "</ul>\n\n";
    }
    print "<table class=\"domain_kontakt\">\n\n";
    // wenn schon versandt, soll nach F5 ein leeres Formular angezeigt werden.
    if (isset($_POST['abgeschickt']) && $_POST['abgeschickt'] == $_SESSION['challenge'])
        {
        // name, POST, Label
        print "\t<tr>\n\t" . '<td class="domain_rechts">' . ANREDE . '</td>' . "\n\t" . '<td><input type="radio" name="domain_anrede" value="' . HERR . '"';
            if (isset($_POST['domain_anrede']))
                {
                if ($_POST['domain_anrede']==HERR) print 'checked="checked"';
            }
        print '> ' . HERR . '&emsp;<input type="radio" name="domain_anrede" value="' . FRAU . '"';
            if (isset($_POST['domain_anrede']))
                {
                if ($_POST['domain_anrede']==FRAU) print 'checked="checked"';
            }
        print '> ' . FRAU . "</td>\n\t</tr>\n\n";
        // $feldname, $werte, $label = 'Eingabe', $type = 'text'
        // Felder, die man nicht braucht, hier (und entsprechend unten) auskommentieren. Wenn man möchte, kann man auch die entsprechenden Texte unter Mail-Layout löschen.
        dev_input_text_post('domain_vorname',$_POST,VORNAME);
        dev_input_text_post('domain_name',$_POST,NAME);
        dev_input_text_post('domain_strasse',$_POST,STRASSE);
        dev_input_number_post('domain_plz',$_POST,PLZ,'0','99999');
        dev_input_text_post('domain_ort',$_POST,ORT);
        dev_input_text_post('domain_telefon',$_POST,TEL,'tel');
        dev_input_text_post('zfh3k_feld',$_POST,MAILABSENDER,'email');
        dev_input_text_post('domain_betreff',$_POST,BETREFF);
        // name, POST, Label, rows, cols
        dev_textarea_post('domain_nachricht',$_POST,NACHRICHT,'8','35');
        } else {
        // name, Label
        print "\t<tr>\n\t" . '<td class="domain_rechts">' . ANREDE . "</td>\n\t" . '<td><input type="radio" name="domain_anrede" value="' . HERR . '" checked="checked"> ' . HERR . ' <input type="radio" name="domain_anrede" value="' . FRAU . '"> ' . FRAU . "</td>\n\t</tr>\n\n";
        dev_input_text('domain_vorname',VORNAME);
        dev_input_text('domain_name',NAME);
        dev_input_text('domain_strasse',STRASSE);
        dev_input_number('domain_plz',PLZ,'0','99999');
        dev_input_text('domain_ort',ORT);
        dev_input_text('domain_telefon',TEL,'tel');
        dev_input_text('zfh3k_feld',MAILABSENDER,'email');
        dev_input_text('domain_betreff',BETREFF);
        // name, Label, rows, cols
        dev_textarea('domain_nachricht',NACHRICHT,'8','35');
    }

    // Submit
    dev_input_submit('absenden',SENDEN);

    print "</table>\n\n";
    // POST['abgeschickt'] bekommt den Wert von SESSION['challenge']
    print '<input type="hidden" name="abgeschickt" value="' . $_SESSION['challenge'] . '">' . "\n";
    // per css ausgeblendet, für die robots
    // mailto sieht der Robot, füllt was aus, und dann wird die Mail nicht verschickt.
    print '<input id="domain_versenkung" name="mailto">' . "\n";
    print "</fieldset>\n";
    print "</form>\n\n";
}

function validiere_mailformular()
    {
    global $prf_mailabsenderadresse,
        $prf_name,
        $prf_ort,
        $prf_nachricht
    ;
    if ($versenkung = dev_formatiere($_POST['mailto']))
        {
        // $versenkung ist display:none per CSS und wird von keinem Menschen ausgefüllt
        // $versenkung sollte im Testmodus zu sehen sein
        versenkung();
        return;
    }
    $fehler = array();
    if (strlen($_POST['zfh3k_feld']) > 500)
        {
        $fehler[0] = MAILADRESSEFEHLT;
    }
    if ($prf_mailabsenderadresse)
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
        if(strlen(trim($_POST['domain_nachricht'])) == 0)
            {
            $fehler[] = NACHRICHTFEHLT;
        }
    }
    if ($prf_name)
        {
        if(strlen($_POST['domain_name']) == 0)
            {
            $fehler[] = NAMEFEHLT;
        }
    }
    if ($prf_ort)
        {
    if(strlen($_POST['domain_ort']) == 0)
            {
            $fehler[] = ORTFEHLT;
        }
    }
    // erneutes Ausfüllen soll immer länger dauern. Spamabwehr
    $wait=$_SESSION['sleep']=$_SESSION['sleep']+0.2;
    sleep(intval($wait));
    // nur zur Entwicklung sollen bestimme Werte angezeigt werden.
    dev_debug($wait);
    return $fehler;
}

function verarbeite_mailformular()
    {
    $anrede = dev_formatiere($_POST['domain_anrede']);
    $vorname = dev_formatiere($_POST['domain_vorname']);
    $name = dev_formatiere($_POST['domain_name']);
    $strasse = dev_formatiere($_POST['domain_strasse']);
    $plz = dev_formatiere($_POST['domain_plz']);
    $ort = dev_formatiere($_POST['domain_ort']);
    $telefon = dev_formatiere($_POST['domain_telefon']);
    $absender = dev_formatiere($_POST['zfh3k_feld']);
    $betreff = dev_formatiere($_POST['domain_betreff']);
    $nachricht = dev_formatiere($_POST['domain_nachricht']);
    $versenkung = dev_formatiere($_POST['mailto']);

    $strEmpfaenger = EIGENEMAIL;

    $strSubject  = BETREFF_CHEF;

    $datum = date('d F Y H:i:s');

    # Mail-Layout

    $kopf = "Von:\t$anrede $vorname $name\r\nAdr.:\t$strasse\r\n$plz  $ort\r\nTel:\t$telefon\r\nMail:\t$absender\r\nBetr.:\t$betreff\r\n--  \r\n";
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
        print "<p class=\"domain_meldung\">" . MAILVERSENDET . "</p>\n\n";
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
function dev_input_text_post($feldname, $werte, $label = 'Eingabe', $type = 'text')
    {
    print "\t<tr>\n\t<td class=\"domain_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><input type=\"$type\" name=\"$feldname\" id=\"$feldname\" value=\"" . htmlspecialchars(substr($werte[$feldname],0,300),ENT_QUOTES,'UTF-8') .  "\" size=\"25\" maxlength=\"100\"></td>\n";
    print "\t</tr>\n\n";
}

// Ein input-(text,email)-feld ausgeben ohne $_POST-Werte
function dev_input_text($feldname, $label= 'Eingabe', $type = 'text')
    {
    print "\t<tr>\n\t<td class=\"domain_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><input type=\"$type\" name=\"$feldname\" id=\"$feldname\" size=\"25\" maxlength=\"100\"";
    // füllt im Testmodus automatisch die Felder aus. $feldname produziert eine Fehlermeldung bei der Mailadresse
    if ($GLOBALS['testmodus']==1) print " value=\"$feldname\"";
    print "></td>\n";
    print "\t</tr>\n\n";
}

// Ein input-(number)-feld ausgeben mit $_POST-Werten
function dev_input_number_post($feldname, $werte, $label = 'Eingabe', $min = '0', $max = '99999', $step = '1')
    {
    print "\t<tr>\n\t<td class=\"domain_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><input type=\"number\" name=\"$feldname\" id=\"$feldname\" value=\"" . htmlspecialchars(substr($werte[$feldname],0,300),ENT_QUOTES,'UTF-8') .  "\" size=\"25\" min=\"$min\" max=\"$max\"></td>\n";
    print "\t</tr>\n\n";
}

// Ein input-(number)-feld ausgeben ohne $_POST-Werte
function dev_input_number($feldname, $label = 'Eingabe', $min = '0', $max = '99999', $step = '1')
    {
    print "\t<tr>\n\t<td class=\"domain_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><input type=\"number\" name=\"$feldname\" id=\"$feldname\" size=\"25\" min=\"$min\" max=\"$max\"";
    // füllt im Testmodus automatisch die Felder aus.
    if ($GLOBALS['testmodus']==1) print " value=\"$min\"";
    print "></td>\n";
    print "\t</tr>\n\n";
}

// Eine Textarea ausgeben mit $_POST-Werten
function dev_textarea_post($feldname, $werte, $label = 'Text', $rows = '1', $cols = '20')
    {
    print "\t<tr>\n\t<td class=\"domain_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><textarea name=\"$feldname\" id=\"$feldname\" rows=\"$rows\" cols=\"$cols\">" . htmlspecialchars(substr($werte[$feldname],0,1000),ENT_QUOTES,'UTF-8') . "</textarea></td>\n";
    print "\t</tr>\n\n";
}

// Eine Textarea ausgeben ohne $_POST-Werte
function dev_textarea($feldname, $label= 'Text', $rows = '1', $cols = '20')
    {
    print "\t<tr>\n\t<td class=\"domain_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><textarea name=\"$feldname\" id=\"$feldname\" rows=\"$rows\" cols=\"$cols\">";
    if ($GLOBALS['testmodus']==1) print "$feldname äöü ÄÖÜ \\{{// usw. <h1>Überschrift</h1> ";
    print "</textarea></td>\n";
    print "\t</tr>\n\n";
}

// Einen Absenden-Button ausgeben
function dev_input_submit($feldname, $label = 'Absenden')
    {
    print "\t<tr>\n";
    print "\t<td></td>\n";
    print "\t<td><input type=\"submit\" name=\"$feldname\" id=\"$feldname\" value=\"$label\"></td>\n";
    print "\t</tr>\n\n";
}

function dev_formatiere ($text)
    {
    $text = substr ($text, 0, 2000);
    $text = strip_tags (trim ($text));
    $text = wordwrap ($text,75,"\r\n",75);

    return $text;
}

function dev_debug($fehler)
    {
    print '<pre>' . "\n\t";
    print_r($fehler);
    print "\n" . '</pre>' . "\n\n";
}

print '<h2 id="quelltext">Quelltext dieser Seite</h2>';

if (!isset($_GET['highlight']) || $_GET['highlight']==0)
    {
    print "<p>Wenn gewünscht: ";
    print '<a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?highlight=1#quelltext">highlight file</a> (Quelltext anzeigen)</p>';
}

if (isset($_GET['highlight']) && $_GET['highlight']==1)
    {
    print "<p>highlight file ";
    print '<a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?highlight=0#quelltext">ausschalten.</a></p>';
    $datei = basename (htmlspecialchars($_SERVER['PHP_SELF']));
    // GET-Anhang loswerden
    $datei = preg_replace('/\?.*/','',$datei);
    highlight_file ($datei);
}
?>

</body>
</html>
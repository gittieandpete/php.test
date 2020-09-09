<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
$titel='Kontaktformular';

// die folgenden Funktionen braucht man nur, um es in bestehende Projekte einzubinden
require '../includes/definitions.php';
require '../includes/functions.php';

require '../includes/uebunghead.php';
require '../includes/uebungkopf.php';
require '../includes/uebungnavi.php';

// Löschen oder auskommentieren, wenn man es in andere Projekte einbindet.
?>
<!DOCTYPE HTML>
<html lang="de">
<head>
<title>Mailformular HTML</title>
<meta	charset="utf-8">
<meta	name="author"	content="Peter Müller">
<link rel="stylesheet" type="text/css" href="mailformular.css">
</head>

<body>


<?php
// bestimmte Variablen ausgeben, damit man eventuelle Fehler erkennt
// dev_debug($_SESSION);
// dev_debug($_SERVER['SCRIPT_NAME']);
// dev_debug($_POST);

// sicherstellen, dass
mb_internal_encoding('UTF-8');
// für mb_send_mail http://www.php.net/manual/de/function.mb-language.php
mb_language('uni');
// (global in der Haupt-functions-Datei gesetzt sind
// dann obiges ebenfalls löschen

################ Version #################
/*
Version 1.2.2 CSS für das Formular steht jetzt in mailformular.css, Header entsprechend angepasst. HTML nicht mehr mit PHP ausgegeben.
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
Version 1.0.1 Doctype-spezifische Endung für input hinzugefügt.

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
    // Zur Info soll der Dateiname dieser Datei ausgegeben werden
    $this_file = pathinfo($_SERVER['PHP_SELF'])['basename'];
    // wenn $testmodus==1, wird keine Mail versandt. Die Mail erscheint auf der Seite
    // Mails auf dem Testsystem (Debian) landen in /var/mail/www-data.
    ?>
    <p>Testmodus ist an, die Formulardaten von <?php print "$this_file";?> werden hier ausgegeben.</p>
<?php }

// ok getestet
function zeige_mailformular($fehler = '')
    {
    if (!array_key_exists('challenge', $_SESSION)  && $_SESSION['abgeschickt'] != 1)
        {
        $_SESSION['challenge'] = rand(2,1000);
        $_SESSION['sleep'] = 1;
    }
    ?>
    <h2><?php print FORMULARTITEL;?></h2>
    <form class="mailform" method="post" accept-charset="UTF-8" action="<?php print htmlspecialchars($_SERVER['PHP_SELF']);?>">
    <fieldset>
    <legend><?php print IHRENACHRICHT;?></legend>
    <?php if ($fehler)
        {
        ?>
        <ul class="domain_fehlermeldung">
        <li><?php print implode("</li>\n<li>",$fehler);?></li>
        </ul>
    <?php
    }

    // wenn schon versandt, soll nach F5 ein leeres Formular angezeigt werden.
    if (isset($_POST['abgeschickt']) && $_POST['abgeschickt'] == $_SESSION['challenge'])
        {
        ?>
        <label for="<?php print HERR;?>"><?php print HERR;?></label><input type="radio" name="domain_anrede" value="<?php print HERR;?>"
              <?php if (isset($_POST['domain_anrede']))
                  {
                  if ($_POST['domain_anrede']==HERR) print ' checked="checked"';
              }?>>
        <label for="<?php print FRAU;?>"><?php print FRAU;?>: </label><input type="radio" name="domain_anrede" value="<?php print FRAU;?>"
        <?php if (isset($_POST['domain_anrede']))
            {
            if ($_POST['domain_anrede']==FRAU) print 'checked="checked"';
        }?>>
        <?php
        // print 'post';
        // $feldname, $werte, $label = 'Eingabe', $type = 'text'
        // Felder, die man nicht braucht, hier (und entsprechend unten) auskommentieren. Wenn man möchte, kann man auch die entsprechenden Texte unter Mail-Layout löschen.
        dev_input_text_post('domain_vorname',$_POST,VORNAME);
        dev_input_text_post('domain_name',$_POST,NAME);
        dev_input_text_post('domain_strasse',$_POST,STRASSE);
        dev_input_number_post('domain_plz',$_POST,PLZ,'0','99999');
        dev_input_text_post('domain_ort',$_POST,ORT);
        dev_input_text_post('domain_telefon',$_POST,TEL,'tel');
        dev_input_text_post('domain_mail',$_POST,MAILABSENDER,'email');
        dev_input_text_post('domain_betreff',$_POST,BETREFF);
        // name, POST, Label, rows, cols
        dev_textarea_post('domain_nachricht',$_POST,NACHRICHT,'8','35');
    } else {
        ?>
        <label for="<?php print HERR;?>"><?php print HERR;?></label><input type="radio" name="domain_anrede" value="<?php print HERR;?>" checked="checked">
        <label for="<?php print FRAU;?>"><?php print FRAU;?></label><input type="radio" name="domain_anrede" value="<?php print FRAU;?>">
        <?php
        dev_input_text('domain_vorname',VORNAME);
        dev_input_text('domain_name',NAME);
        dev_input_text('domain_strasse',STRASSE);
        dev_input_number('domain_plz',PLZ,'0','99999');
        dev_input_text('domain_ort',ORT);
        dev_input_text('domain_telefon',TEL,'tel');
        dev_input_text('domain_mail',MAILABSENDER,'email');
        dev_input_text('domain_betreff',BETREFF);
        // name, Label, rows, cols
        dev_textarea('domain_nachricht',NACHRICHT,'8','35');
    }

    // Submit
    dev_input_submit('absenden',SENDEN);

    // POST['abgeschickt'] bekommt den Wert von SESSION['challenge']
    ?>
    <input type="hidden" name="abgeschickt" value="<?php print $_SESSION['challenge']?>">
    <!-- per css ausgeblendet, für die robots -->
    <!-- mailto sieht der Robot, füllt was aus, und dann wird die Mail nicht verschickt. -->
    <input id="domain_versenkung" name="mailto">
    </fieldset>
    </form>
<?php }

// ok getestet
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
    if (strlen($_POST['domain_mail']) > 500)
        {
        $fehler[0] = MAILADRESSEFEHLT;
    }
    if ($prf_mailabsenderadresse)
        {
        $text = trim($_POST['domain_mail']);
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
    // dev_debug($fehler);
    return $fehler;
}

// ok getestet
function verarbeite_mailformular()
    {
    $anrede = dev_formatiere($_POST['domain_anrede']);
    $vorname = dev_formatiere($_POST['domain_vorname']);
    $name = dev_formatiere($_POST['domain_name']);
    $strasse = dev_formatiere($_POST['domain_strasse']);
    $plz = dev_formatiere($_POST['domain_plz']);
    $ort = dev_formatiere($_POST['domain_ort']);
    $telefon = dev_formatiere($_POST['domain_telefon']);
    $absender = dev_formatiere($_POST['domain_mail']);
    $betreff = dev_formatiere($_POST['domain_betreff']);
    $nachricht = dev_formatiere($_POST['domain_nachricht']);
    $versenkung = dev_formatiere($_POST['mailto']);

    $strEmpfaenger = EIGENEMAIL;

    $strSubject  = BETREFF_CHEF;

    $datum = date('d F Y H:i:s');

    # Mail-Layout

    $kopf =
'Von: ' . $anrede .' ' . $vorname . ' ' . $name . "\n" .
'Adr.: ' . $strasse . ' ' . "\n" .
        $plz . ' ' .   $ort . "\n" .
'Tel: ' . $telefon . "\n" .
'Mail: ' . $absender . "\n" .
'Betr.: ' . $betreff . "\n" .
'-- ';
    $inhalt =
'Nachricht: ' . $nachricht . "\n" .
'--  ' . "\n";
    $fuss =
'Datum: ' . $datum . "\n";

    $mailbody =
        $kopf .
        $inhalt .
        $fuss;

    $header =
'From: ' . FORMULARTITEL . "\n" .
'Content-type: text/plain;
charset=UTF-8
Content-Transfer-Encoding: 8bit';

    // abschicken
    if ($GLOBALS['testmodus']==0)
        {
        $ok = mb_send_mail (
            $strEmpfaenger,
            $strSubject,
            $mailbody,
            $header);
        if (!$ok)
            {
            ?>
            <p><?php print MAILNICHTVERSENDET;?></p>
        <?php
        } else {
        ?>
        <p class="meldung"><?php print MAILVERSENDET;?></p>
        <?php
        }
    }

    if ($GLOBALS['testmodus']==1)
        {
        ?>
        <h3>Mail verarbeitet, Testmodus ist an.</h3>
        <pre>
        Empfänger: <?php print "$strEmpfaenger";?>
        Betreff: <?php print "$strSubject";?>
        Body der Mail: <?php print "$mailbody";?>
        Header der Mail:
        <?php print "$header";?>
        </pre>
        <?php
    } else {
        ?>
        <p>Bitte das Formular einrichten: Testmodus auf 1 oder 0 setzen!</p>
        <?php
    }


    // sorgt für die falsche challenge bei F5 ($_POST bleibt, $_SESSION ändert sich)
    // (leeres Formular nach F5)
    $_SESSION['challenge'] = rand(2,1000);
    $_SESSION['abgeschickt'] = '1';
}

function versenkung()
    {?>
        <h2 class="domain_fehlermeldung">Vielen Dank! Ihre Mail wurde soeben versandt!</h2>
    <?php
    // sorgt für die falsche challenge ($_POST bleibt, $_SESSION ändert sich)
    $_SESSION['challenge'] = rand(2,1000);
}

// Ein input-(text,email)-feld ausgeben mit $_POST-Werten
function dev_input_text_post($feldname, $werte, $label = 'Eingabe', $type = 'text')
    {?>
    <label for="<?php print "$feldname";?>"><?php print $label;?>: </label>
    <input type="<?php print "$type";?>" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" value="<?php print htmlspecialchars(substr($werte[$feldname],0,300),ENT_QUOTES,'UTF-8');?>" size="25" maxlength="100">
<?php }

// Ein input-(text,email)-feld ausgeben ohne $_POST-Werte
// füllt im Testmodus automatisch die Felder aus. $feldname produziert eine Fehlermeldung bei der Mailadresse
function dev_input_text($feldname, $label= 'Eingabe', $type = 'text')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?>: </label>
    <input type="<?php print "$type";?>" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" size="25" maxlength="100" <?php if ($GLOBALS['testmodus']==1) {?> value="<?php print "$feldname";}?>">
<?php }

// Ein input-(number)-feld ausgeben mit $_POST-Werten
function dev_input_number_post($feldname, $werte, $label = 'Eingabe', $min = '0', $max = '99999', $step = '1')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?>: </label>
    <input type="number" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" value="<?php print htmlspecialchars(substr($werte[$feldname],0,300),ENT_QUOTES,'UTF-8');?>" size="25" inputmode="numeric" min="<?php print "$min";?>" max="<?php print "$max";?>">
<?php }

// Ein input-(number)-feld ausgeben ohne $_POST-Werte
// füllt im Testmodus automatisch die Felder aus.
function dev_input_number($feldname, $label = 'Eingabe', $min = '0', $max = '99999', $step = '1')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?>: </label>
    <input type="number" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" size="25" inputmode="numeric" min="<?php print "$min";?>" max="<?php print "$max";?>"<?php if ($GLOBALS['testmodus']==1)?> value="<?php print "$min";?>">
<?php }

// Eine Textarea ausgeben mit $_POST-Werten
function dev_textarea_post($feldname, $werte, $label = 'Text', $rows = '1', $cols = '20')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?>: </label>
    <textarea name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" rows="<?php print "$rows";?>" cols="<?php print "$cols";?>"><?php print htmlspecialchars(substr($werte[$feldname],0,1000),ENT_QUOTES,'UTF-8');?></textarea>
<?php }

// Eine Textarea ausgeben ohne $_POST-Werte
// + Textausgabe mit Sonderzeichen im Testmodus
function dev_textarea($feldname, $label= 'Text', $rows = '1', $cols = '20')
    {
    $sonderzeichen = 'äöü ÄÖÜ \\ // <h1>Überschrift</h1>';?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?>: </label>
    <textarea name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" rows="<?php print "$rows";?>" cols="<?php print "$cols";?>"><?php if ($GLOBALS['testmodus']==1) print $feldname . $sonderzeichen;?></textarea>
<?php }

// Einen Absenden-Button ausgeben
function dev_input_submit($feldname, $label = 'Absenden')
    {?>
    <input type="submit" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" value="<?php print "$label";?>">
<?php }

function dev_formatiere ($text)
    {
    $text = substr ($text, 0, 2000);
    $text = strip_tags (trim ($text));
    $text = wordwrap ($text,75,"\r\n",75);
    return $text;
}

function dev_debug($fehler)
    {?>
    <pre>
    <?php print_r($fehler)?>
    </pre>
<?php }

require '../includes/uebungfooter.php';
?>
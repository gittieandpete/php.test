<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
$titel='Mailformular';
?>
<!DOCTYPE HTML>
<html lang="de">
<head>
<title><?php print "$titel";?></title>
<meta	charset="utf-8">
<meta	name="author"	content="Peter Müller">
<link rel="stylesheet" type="text/css" href="mailformular.css">
</head>

<body>


<?php
// bestimmte Variablen ausgeben, damit man eventuelle Fehler erkennt

// debug($_SESSION);
// debug($_SERVER['HTTP_HOST']);
// debug($_POST);


mb_internal_encoding('UTF-8');
mb_language('uni');

################ Version #################
/*
Version 1.2.4 input[number] und input[email] verwenden; Testversion raus; Session[bot] gesetzt.
Version 1.2.3 Fehler in functions behoben. require auskommentiert zum Einbau in andere Projekte. CSS ist im selben Ordner. mb_send_mail sendet ungefragt in BASE64, mail() sendet richtige Header.
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
button_submit
debug
formatiere
input_number
input_number_post
input_radio
input_radio_post
input_text
input_text_post
textarea
textarea_post
validiere_mailformular
verarbeite_mailformular
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
define('NACHRICHT','Nachricht');
// weiterer Text
define('MAILVERSENDET','Vielen Dank! Ihre Mail wurde erfolgreich versandt.');
define('MAILNICHTVERSENDET','Die Mail konnte nicht versendet werden.');
// Text der Überschrift über dem einzugebenden Nachrichtentext
define('IHRENACHRICHT','Ihre Nachricht');
define('HERR','Herr');
define('FRAU','Frau');
define('SENDEN','Senden');
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
        <ul class="phptest_fehlermeldung">
        <li><?php print implode("</li>\n<li>",$fehler);?></li>
        </ul>
    <?php
    }

    // wenn schon versandt, soll nach F5 ein leeres Formular angezeigt werden.
    if (isset($_POST['abgeschickt']) && $_POST['abgeschickt'] == $_SESSION['challenge'])
        {?>
        <label for="<?php print HERR;?>"><?php print HERR;?></label><input type="radio" name="phptest_anrede" value="<?php print HERR;?>"
            <?php if (isset($_POST['phptest_anrede']))
                {
                if ($_POST['phptest_anrede']==HERR) print 'checked="checked"';
            }?>>
        <label for="<?php print FRAU;?>"><?php print FRAU;?>: </label><input type="radio" name="phptest_anrede" value="<?php print FRAU;?>"
        <?php if (isset($_POST['phptest_anrede']))
            {
            if ($_POST['phptest_anrede']==FRAU) print 'checked="checked"';
        }?>>
        <?php
        // Felder, die man nicht braucht, hier (und entsprechend unten) auskommentieren. Auch die entsprechenden Texte unter Mail-Layout löschen.
        input_text_post('phptest_vorname',$_POST,VORNAME);
        input_text_post('phptest_name',$_POST,NAME);
        input_text_post('phptest_strasse',$_POST,STRASSE);
        input_number_post('phptest_plz',$_POST,PLZ,'0','99999');
        input_text_post('phptest_ort',$_POST,ORT);
        input_text_post('phptest_telefon',$_POST,TEL,'tel');
        input_text_post('phptest_mail',$_POST,MAILABSENDER,'email');
        // name, POST, Label, rows, cols
        textarea_post('phptest_nachricht',$_POST,NACHRICHT,'8','35');
    } else {?>
        <label for="<?php print HERR;?>"><?php print HERR;?></label><input type="radio" name="phptest_anrede" value="<?php print HERR;?>">
        <label for="<?php print FRAU;?>"><?php print FRAU;?></label><input type="radio" name="phptest_anrede" value="<?php print FRAU;?>">
        <?php
        input_text('phptest_vorname',VORNAME);
        input_text('phptest_name',NAME);
        input_text('phptest_strasse',STRASSE);
        input_number('phptest_plz',PLZ,'0','99999');
        input_text('phptest_ort',ORT);
        input_text('phptest_telefon',TEL,'tel');
        input_text('phptest_mail',MAILABSENDER,'email');
        // name, Label, rows, cols
        textarea('phptest_nachricht',NACHRICHT,'8','35');
    }

    // Submit
    button_submit('absenden',SENDEN);

    // POST['abgeschickt'] bekommt den Wert von SESSION['challenge']
    ?>
    <input type="hidden" name="abgeschickt" value="<?php print $_SESSION['challenge']?>">
    <input id="phptest_versenkung" name="mailto">
    </fieldset>
    </form>
<?php
}

function validiere_mailformular()
    {
    global $prf_mailabsenderadresse,
        $prf_name,
        $prf_ort,
        $prf_nachricht
    ;
    if ($versenkung = formatiere($_POST['mailto']))
        {
        ?>
        <h2 class="mailformular_fehlermeldung">Vielen Dank! Ihre Mail wurde soeben versandt!</h2>
        <?php $_SESSION['challenge'] = rand(2,1000);
        $_SESSION['bot'] = 1;
        return;
    }
    $_SESSION['bot'] = 0;
    $fehler = array();
    if (strlen($_POST['phptest_mail']) > 500)
        {
        $fehler[0] = MAILADRESSEFEHLT;
    }
    if ($prf_mailabsenderadresse)
        {
        $text = trim($_POST['phptest_mail']);
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
        if(strlen(trim($_POST['phptest_nachricht'])) == 0)
            {
            $fehler[] = NACHRICHTFEHLT;
        }
    }
    if ($prf_name)
        {
        if(strlen($_POST['phptest_name']) == 0)
            {
            $fehler[] = NAMEFEHLT;
        }
    }
    if ($prf_ort)
        {
    if(strlen($_POST['phptest_ort']) == 0)
            {
            $fehler[] = ORTFEHLT;
        }
    }
    // erneutes Ausfüllen soll immer länger dauern. Spamabwehr
    $wait=$_SESSION['sleep']=$_SESSION['sleep']+0.2;
    sleep(intval($wait));
    // nur zur Entwicklung sollen bestimme Werte angezeigt werden.
    // debug($fehler);
    return $fehler;
}

function verarbeite_mailformular()
    {
    if ($_SESSION['bot'] == 1)
        {
        return;
    }

    $anrede = formatiere($_POST['phptest_anrede']);
    $vorname = formatiere($_POST['phptest_vorname']);
    $name = formatiere($_POST['phptest_name']);
    $strasse = formatiere($_POST['phptest_strasse']);
    $plz = formatiere($_POST['phptest_plz']);
    $ort = formatiere($_POST['phptest_ort']);
    $telefon = formatiere($_POST['phptest_telefon']);
    $absender = formatiere($_POST['phptest_mail']);
    $nachricht = formatiere($_POST['phptest_nachricht']);
    $versenkung = formatiere($_POST['mailto']);

    $strEmpfaenger = EIGENEMAIL;

    $strSubject  = BETREFF_CHEF;

    $datum = date('d F Y H:i:s');

    # Mail-Layout

    $kopf =
'Von: ' . $anrede .' ' . $vorname . ' ' . $name . "\n" .
'Adr.: ' . $strasse . ' ' . "\n" .
        $plz . ' ' .   $ort . "\n" .
'Tel: ' . $telefon . "\n" .
'Mail: ' . $absender . "\n"
;
    $inhalt =
'Nachricht: ' . $nachricht . "\n" .
'--  ' . "\n";
    $fuss =
'Datum: ' . $datum . "\n";

    $mailbody =
        $kopf .
        $inhalt .
        $fuss;

    $header = array('From' => FORMULARTITEL . ' von ' . $_SERVER['HTTP_HOST'],
    'Content-type' => 'text/plain',
    'charset' => 'UTF-8',
    'Content-Transfer-Encoding' => '8bit'
    );

    // debug($header);
    // debug($mailbody);

    // abschicken
    $ok = mail (
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

    // sorgt für die falsche challenge bei F5 ($_POST bleibt, $_SESSION ändert sich)
    // (leeres Formular nach F5)
    $_SESSION['challenge'] = rand(2,1000);
    $_SESSION['abgeschickt'] = '1';
}

// Ein input-(text,email)-feld ausgeben mit $_POST-Werten
function input_text_post($feldname, $werte, $label = 'Eingabe', $type = 'text')
    {?>
    <label for="<?php print "$feldname";?>"><?php print $label;?></label>
    <input type="<?php print "$type";?>" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" value="<?php print htmlspecialchars(substr($werte[$feldname],0,300),ENT_QUOTES,'UTF-8');?>">
<?php
}

// Ein input-(text,email)-feld ausgeben ohne $_POST-Werte
function input_text($feldname, $label= 'Eingabe', $type = 'text')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?></label>
    <input type="<?php print "$type";?>" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>">
<?php
}

// Ein input-(number)-feld ausgeben mit $_POST-Werten
function input_number_post($feldname, $werte, $label = 'Eingabe', $min = '0', $max = '99999', $step = '1')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?></label>
    <input type="number" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" value="<?php print htmlspecialchars(substr($werte[$feldname],0,300),ENT_QUOTES,'UTF-8');?>" inputmode="numeric" min="<?php print "$min";?>" max="<?php print "$max";?>">
<?php
}

// Ein input-(number)-feld ausgeben ohne $_POST-Werte
function input_number($feldname, $label = 'Eingabe', $min = '0', $max = '99999', $step = '1')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?></label>
    <input type="number" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" inputmode="numeric" min="<?php print "$min";?>" max="<?php print "$max";?>">
<?php
}

// input[radio] ausgeben
function input_radio($feldname, $value, $label)
    {?>
    <label for="<?php print $feldname;?>"><?php print $label;?></label><input type="radio" name="<?php print "$feldname";?>" value="<?php print "$label";?>">
<?php
}

// Eine Textarea ausgeben mit $_POST-Werten
function textarea_post($feldname, $werte, $label = 'Text', $rows = '1', $cols = '20')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?></label>
    <textarea name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" rows="<?php print "$rows";?>" cols="<?php print "$cols";?>"><?php print htmlspecialchars(substr($werte[$feldname],0,1000),ENT_QUOTES,'UTF-8');?></textarea>
<?php
}

// Eine Textarea ausgeben ohne $_POST-Werte
function textarea($feldname, $label= 'Text', $rows = '1', $cols = '20')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?></label>
    <textarea name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" rows="<?php print "$rows";?>" cols="<?php print "$cols";?>"></textarea>
<?php
}

// Einen input[submit] ausgeben
function input_submit($feldname, $label = 'Absenden')
    {?>
    <input type="submit" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" value="<?php print "$label";?>">
<?php
}

// Einen Button[submit] ausgeben
function button_submit($feldname, $label = 'Absenden')
    {?>
    <button type="submit" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>"><?php print "$label";?></button>
<?php
}

function formatiere ($text)
    {
    $text = substr ($text, 0, 2000);
    $text = strip_tags (trim ($text));
    $text = wordwrap ($text,75,"\r\n",75);
    return $text;
}

function debug($fehler,$text='')
    {?>
    <pre>
    <?php
    print $text;
    print_r($fehler);
    ?>
    </pre>
<?php
}

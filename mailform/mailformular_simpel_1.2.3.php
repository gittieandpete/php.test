<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');
mb_language('uni');
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


################ Einrichtung ###########################

// an welche Adresse soll die Nachricht aus dem Formular geschickt werden?
define('EIGENEMAIL','borumat@gmx.de');

################ Einrichtung fertig! ########################

// Titel des Formulars
define('FORMULARTITEL','Mailformular');
// welchen Betreff soll die Mail erhalten, die an dich geschickt wird? (das ist nicht der Betreff, den die Leute angeben)
define('BETREFF_CHEF','Mail vom Kontaktformular auf ' . htmlspecialchars($_SERVER['HTTP_HOST']));
// Fehlermeldungen (nicht löschen, ggf. Text ändern)
define('MAILADRESSEFEHLT','Bitte geben Sie eine Mailadresse ein, damit wir Ihnen antworten können!');
define('NACHRICHTFEHLT','Bitte geben Sie etwas ins Nachrichtenfeld ein!');
define('NAMEFEHLT','Bitte tragen Sie Ihren Nachnamen ein!');
define('ORTFEHLT','Bitte geben Sie einen Ort an!');
define('MAILABSENDER','E-Mail');
define('NACHRICHT','Nachricht');
// weiterer Text
define('MAILVERSENDET','Vielen Dank! Ihre Mail wurde erfolgreich versandt.');
define('MAILNICHTVERSENDET','Die Mail konnte nicht versendet werden.');
// Text der Überschrift über dem einzugebenden Nachrichtentext
define('IHRENACHRICHT','Ihre Nachricht');
define('SENDEN','Senden');
// soll auf das Vorhandensein einer Mailadresse geprüft werden? Ja, dann 1 eintragen; Nein, dann 0 eintragen.
// prf=Prüfung. Prüfung auf:
$prf_mailabsenderadresse = 1;
$prf_nachricht = 1;

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
    <h1>Mailformular</h1>
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
        // $feldname, $werte, $label = 'Eingabe', $type = 'text'
        dev_input_text_post('domain_mail',$_POST,MAILABSENDER,'email');
        // name, POST, Label, rows, cols
        dev_textarea_post('domain_nachricht',$_POST,NACHRICHT,'8','35');
    } else {
        dev_input_text('domain_mail',MAILABSENDER,'email');
        dev_textarea('domain_nachricht',NACHRICHT,'8','35');
    }

    // Submit
    dev_input_submit('absenden',SENDEN);

    // POST['abgeschickt'] bekommt den Wert von SESSION['challenge']
    ?>
    <input type="hidden" name="abgeschickt" value="<?php print $_SESSION['challenge']?>">
    <input id="domain_versenkung" name="mailto">
    </fieldset>
    </form>
<?php }

function validiere_mailformular()
    {
    global $prf_mailabsenderadresse,
        $prf_nachricht
    ;
    if ($versenkung = dev_formatiere($_POST['mailto']))
        {
        // $versenkung ist display:none per CSS und wird von keinem Menschen ausgefüllt
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
    // erneutes Ausfüllen soll immer länger dauern. Spamabwehr
    $wait=$_SESSION['sleep']=$_SESSION['sleep']+1;
    sleep(intval($wait));
    return $fehler;
}

function verarbeite_mailformular()
    {
    $absender = dev_formatiere($_POST['domain_mail']);
    $nachricht = dev_formatiere($_POST['domain_nachricht']);
    $versenkung = dev_formatiere($_POST['mailto']);

    $strEmpfaenger = EIGENEMAIL;

    $strSubject  = BETREFF_CHEF;

    $datum = date('d F Y H:i:s');

    # Mail-Layout

    $kopf =
'Mail: ' . $absender . "\n" .
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

function versenkung()
    {?>
        <h2 class="domain_fehlermeldung">Vielen Dank! Ihre Mail wurde soeben versandt!</h2>
    <?php
    $_SESSION['challenge'] = rand(2,1000);
}

// Ein input-(text,email)-feld ausgeben mit $_POST-Werten
function dev_input_text_post($feldname, $werte, $label = 'Eingabe', $type = 'text')
    {?>
    <label for="<?php print "$feldname";?>"><?php print $label;?>: </label>
    <input type="<?php print "$type";?>" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" value="<?php print htmlspecialchars(substr($werte[$feldname],0,300),ENT_QUOTES,'UTF-8');?>" size="25" maxlength="100">
<?php }

// Ein input-(text,email)-feld ausgeben ohne $_POST-Werte
function dev_input_text($feldname, $label= 'Eingabe', $type = 'text')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?>: </label>
    <input type="<?php print "$type";?>" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" size="25" maxlength="100">
<?php }

// Ein input-(number)-feld ausgeben mit $_POST-Werten
function dev_input_number_post($feldname, $werte, $label = 'Eingabe', $min = '0', $max = '99999', $step = '1')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?>: </label>
    <input type="number" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" value="<?php print htmlspecialchars(substr($werte[$feldname],0,300),ENT_QUOTES,'UTF-8');?>" size="25" inputmode="numeric" min="<?php print "$min";?>" max="<?php print "$max";?>">
<?php }

// Ein input-(number)-feld ausgeben ohne $_POST-Werte
function dev_input_number($feldname, $label = 'Eingabe', $min = '0', $max = '99999', $step = '1')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?>: </label>
    <input type="number" name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" size="25" inputmode="numeric" min="<?php print "$min";?>" max="<?php print "$max";?>">
<?php }

// Eine Textarea ausgeben mit $_POST-Werten
function dev_textarea_post($feldname, $werte, $label = 'Text', $rows = '1', $cols = '20')
    {?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?>: </label>
    <textarea name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" rows="<?php print "$rows";?>" cols="<?php print "$cols";?>"><?php print htmlspecialchars(substr($werte[$feldname],0,1000),ENT_QUOTES,'UTF-8');?></textarea>
<?php }

// Eine Textarea ausgeben ohne $_POST-Werte
function dev_textarea($feldname, $label= 'Text', $rows = '1', $cols = '20')
    {
    ?>
    <label for="<?php print "$feldname";?>"><?php print "$label";?>: </label>
    <textarea name="<?php print "$feldname";?>" id="<?php print "$feldname";?>" rows="<?php print "$rows";?>" cols="<?php print "$cols";?>"></textarea>
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
?>

</body>
</html>
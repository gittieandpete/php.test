<?php

date_default_timezone_set('Europe/Berlin');
setlocale(LC_TIME, "de_DE", "de_DE@euro", "de", "ge");
// für strpos, strlen usw.
mb_internal_encoding('UTF-8');
// für mb_send_mail http://www.php.net/manual/de/function.mb-language.php
mb_language('uni');


function zeige_mailformular($fehler = '')
    {
    if (!array_key_exists('challenge', $_SESSION)  && $_SESSION['abgeschickt'] != 1)
        {
        $_SESSION['challenge'] = rand(2,1000);
    }
    print '<h2>' . FORMULARTITEL . '</h2>' . "\n";
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
        input_text_post('domain_vorname',$_POST,VORNAME);
        input_text_post('domain_name',$_POST,NAME);
        input_text_post('domain_strasse',$_POST,STRASSE);
        input_text_post('domain_plz',$_POST,PLZ);
        input_text_post('domain_ort',$_POST,ORT);
        input_text_post('domain_telefon',$_POST,TEL);
        input_text_post('zfh3k_feld',$_POST,MAILABSENDER);
        input_text_post('domain_betreff',$_POST,BETREFF);
        // name, POST, Label, rows, cols
        input_textarea_post('domain_nachricht',$_POST,NACHRICHT,'8','35');
        } else {
        // name, Label
        print "\t<tr>\n\t" . '<td class="domain_rechts">' . ANREDE . "</td>\n\t" . '<td><input type="radio" name="domain_anrede" value="' . HERR . '" checked="checked"> ' . HERR . ' <input type="radio" name="domain_anrede" value="' . FRAU . '"> ' . FRAU . "</td>\n\t</tr>\n\n";
        input_text('domain_vorname',VORNAME);
        input_text('domain_name',NAME);
        input_text('domain_strasse',STRASSE);
        input_text('domain_plz',PLZ);
        input_text('domain_ort',ORT);
        input_text('domain_telefon',TEL);
        input_text('zfh3k_feld',MAILABSENDER);
        input_text('domain_betreff',BETREFF);
        // name, Label, rows, cols
        input_textarea('domain_nachricht',NACHRICHT,'8','35');
    }

    // Submit
    input_submit('absenden',SENDEN);

    print "</table>\n\n";
    // POST['abgeschickt'] bekommt den Wert von SESSION['challenge']
    print '<input type="hidden" name="abgeschickt" value="' . $_SESSION['challenge'] . '">' . "\n";
    // per css ausgeblendet, für die robots
    print '<input id="domain_versenkung" name="mailto">' . "\n";
    print "</fieldset>\n";
    print "</form>\n\n";
}

function validiere_mailformular()
    {
    global $mailabsenderadresse;
    $fehler = array();
    if (strlen($_POST['zfh3k_feld']) > 300)
        {
        $fehler[0] = MAILADRESSEFEHLT;
    }
    if ($mailabsenderadresse)
        {
        $text = trim($_POST['zfh3k_feld']);
        // simples selbstgestricktes Muster
        $muster = '/^[^@]+@[a-zA-Z0-9._\-]+\.[a-zA-Z]+$/';
        $at = preg_match($muster,$text);
        if (!$at)
            {
            $fehler[0] = MAILADRESSEFEHLT;
        }
    }
    if (strlen(trim($_POST['domain_nachricht'])) == 0)
        {
        $fehler[] = NACHRICHTFEHLT;
    }
    return $fehler;
}


function verarbeite_mailformular()
    {
    $anrede = formatiere($_POST['domain_anrede']);
    $vorname = formatiere($_POST['domain_vorname']);
    $name = formatiere($_POST['domain_name']);
    $strasse = formatiere($_POST['domain_strasse']);
    $plz = formatiere($_POST['domain_plz']);
    $ort = formatiere($_POST['domain_ort']);
    $telefon = formatiere($_POST['domain_telefon']);
    $absender = formatiere($_POST['zfh3k_feld']);
    $betreff = formatiere($_POST['domain_betreff']);
    $nachricht = formatiere($_POST['domain_nachricht']);
    $versenkung = formatiere($_POST['mailto']);

    // $versenkung ist display:none per CSS und wird von keinem Menschen ausgefüllt
    if ($versenkung)
        {
        print 	"<h2 class=\"domain_meldung\">
                Vielen Dank! Ihre Mail wurde soeben versandt!
                </h2>";
        // sorgt für die falsche challenge ($_POST bleibt, $_SESSION ändert sich)
        $_SESSION['challenge'] = rand(2,1000);
        return;
    }

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

// Ein Textfeld ausgeben mit $_POST-Werten
function input_text_post($feldname, $werte, $label = 'Textfeld')
    {
    print "\t<tr>\n\t<td class=\"domain_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><input type=\"text\" name=\"$feldname\" id=\"$feldname\" value=\"" . htmlspecialchars(substr($werte[$feldname],0,300),ENT_QUOTES,'UTF-8') .  "\" size=\"25\" maxlength=\"100\"></td>\n";
    print "\t</tr>\n\n";
}

// Ein Textfeld ausgeben ohne $_POST-Werte
function input_text($feldname, $label= 'Textfeld')
    {
    print "\t<tr>\n\t<td class=\"domain_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><input type=\"text\" name=\"$feldname\" id=\"$feldname\" size=\"25\" maxlength=\"100\"";
    if ($GLOBALS['testmodus']==1) print " value=\"$feldname\"";
    print "></td>\n";
    print "\t</tr>\n\n";
}

// Eine Textarea ausgeben mit $_POST-Werten
function input_textarea_post($feldname, $werte, $label = 'Text', $rows = '1', $cols = '20')
    {
    print "\t<tr>\n\t<td class=\"domain_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><textarea name=\"$feldname\" id=\"$feldname\" rows=\"$rows\" cols=\"$cols\">" . htmlspecialchars(substr($werte[$feldname],0,1000),ENT_QUOTES,'UTF-8') . "</textarea></td>\n";
    print "\t</tr>\n\n";
}

// Eine Textarea ausgeben ohne $_POST-Werte
function input_textarea($feldname, $label= 'Text', $rows = '1', $cols = '20')
    {
    print "\t<tr>\n\t<td class=\"domain_rechts\"><label for=\"$feldname\">$label</label></td>\n";
    print "\t<td><textarea name=\"$feldname\" id=\"$feldname\" rows=\"$rows\" cols=\"$cols\">";
    if ($GLOBALS['testmodus']==1) print "$feldname äöü ÄÖÜ \\{{// usw. ";
    print "</textarea></td>\n";
    print "\t</tr>\n\n";
}

// Einen Absenden-Button ausgeben
function input_submit($feldname, $label = 'Absenden')
    {
    print "\t<tr>\n";
    print "\t<td></td>\n";
    print "\t<td><input type=\"submit\" name=\"$feldname\" id=\"$feldname\" value=\"$label\"></td>\n";
    print "\t</tr>\n\n";
}

function formatiere ($text)
    {
    $text = substr ($text, 0, 2000);
    $text = strip_tags (trim ($text));
    $text = wordwrap ($text,75,"\r\n",75);

    return $text;
}

?>

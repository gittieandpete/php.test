<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');
mb_language('uni');
?>
<!DOCTYPE HTML>
<html lang="de">
<head>
<title>Mailformular</title>
<meta	charset="utf-8">
<meta	name="author"	content="Peter Müller, Andreas Borutta">
<link rel="stylesheet" type="text/css" href="mailformular.css">
</head>

<body>

<?php


################ Einrichtung ###########################

// an welche Adresse soll die Nachricht aus dem Formular geschickt werden?
define('EIGENEMAIL','peter.mueller@c-major.de');

// später debug() löschen
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
    <form method="post" action="<?php print htmlspecialchars($_SERVER['PHP_SELF']);?>">
    <?php if ($fehler)
        {
        ?>
        <ul class="mailformular_fehlermeldung">
        <li><?php print implode("</li>\n<li>",$fehler);?></li>
        </ul>
    <?php
    }

    // wenn schon versandt, soll ein leeres Formular angezeigt werden.
    if (isset($_POST['abgeschickt']) && $_POST['abgeschickt'] == $_SESSION['challenge'])
        {
        ?>
        <label for="mailformular_mail">E-Mail</label>
        <input type="email" name="mailformular_mail" id="mailformular_mail" value="<?php print htmlspecialchars(substr($_POST['mailformular_mail'],0,1000),ENT_QUOTES,'UTF-8');?>">
        <label for="mailformular_nachricht">Nachricht</label>
        <textarea name="mailformular_nachricht" id="mailformular_nachricht"><?php print htmlspecialchars(substr($_POST['mailformular_nachricht'],0,1000),ENT_QUOTES,'UTF-8');?></textarea>
        <?php
    } else {
        ?>
        <label for="mailformular_mail">E-Mail</label>
        <input type="email" name="mailformular_mail" id="mailformular_mail">
        <label for="mailformular_nachricht">Nachricht</label>
        <textarea name="mailformular_nachricht" id="mailformular_nachricht"></textarea>
        <?php
    }
    ?>
    <button type="submit" name="absenden" id="absenden">Senden</button>
    <input type="hidden" aria-hidden="true" name="abgeschickt" value="<?php print $_SESSION['challenge']?>">
    <input aria-hidden="true" id="mailformular_versenkung" name="mailto">
    </form>
<?php }

function validiere_mailformular()
    {
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
    if (strlen($_POST['mailformular_mail']) > 500)
        {
        $fehler[0] = 'Bitte geben Sie eine Mailadresse ein, damit wir Ihnen antworten können!';
    }
    $text = trim($_POST['mailformular_mail']);
    // Muster, das auch die Browser intern benutzen
    $muster = '/[a-zA-Z0-9.!#$%&’*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*/';
    $at = preg_match($muster,$text);
    if (!$at)
        {
        // überschreibt die erste Fehlermeldung, ein Meldungstext reicht
        $fehler[0] = 'Bitte geben Sie eine Mailadresse ein, damit wir Ihnen antworten können!';
    }
    if(strlen(trim($_POST['mailformular_nachricht'])) == 0)
        {
        $fehler[] = 'Bitte geben Sie etwas ins Nachrichtenfeld ein!';
    }

    // erneutes Ausfüllen soll immer länger dauern. Spamabwehr
    $wait=$_SESSION['sleep']=$_SESSION['sleep']+1;
    sleep(intval($wait));
    return $fehler;
}

function verarbeite_mailformular()
    {
    if ($_SESSION['bot'] == 1)
        {
        return;
    }
    $absender = formatiere($_POST['mailformular_mail']);
    $nachricht = formatiere($_POST['mailformular_nachricht']);

    $strEmpfaenger = EIGENEMAIL;

    $strSubject  = 'Nachricht vom Kontaktformular von ' . $_SERVER['HTTP_HOST'];

    # Mail-Layout

    /*
    Wunschergebnis von Andreas:
    Subject: Nachricht vom Mailformular von example.tld
    From: homer@simp.son

    Body:
    Moin.
    Was geht?
    Gruß, Homer
    */

    $header = array('From' => $absender,
    'Content-type' => 'text/plain',
    'charset' => 'UTF-8',
    'Content-Transfer-Encoding' => '8bit'
    );

    // abschicken

    // testen:
    $mail = array($strEmpfaenger,
        $strSubject,
        $nachricht,
        $header
    );

    debug($mail);

    /*
    $ok = mail (
        $strEmpfaenger,
        $strSubject,
        $nachricht,
        $header);
    */
    if (!$ok)
        {
        ?>
        <p>Die Mail konnte nicht versendet werden.</p>
    <?php
    } else {
    ?>
    <p class="meldung">Vielen Dank! Ihre Mail wurde erfolgreich versandt.</p>
    <?php
    }

    // sorgt für die falsche challenge bei F5 ($_POST bleibt, $_SESSION ändert sich)
    // (leeres Formular nach F5)
    $_SESSION['challenge'] = rand(2,1000);
    $_SESSION['abgeschickt'] = '1';
}

function formatiere($text)
    {
    $text = substr ($text, 0, 2000);
    $text = strip_tags (trim ($text));
    $text = wordwrap ($text,75,"\r\n",75);
    return $text;
}

// später löschen
function debug($var)
    {
    print '<pre>';
    print_r($var);
    print '</pre>';
}

?>

</body>
</html>
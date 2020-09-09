<?php
$titel = "Sessions, 1";
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

print "<p>Schreiben Sie ein PHP_Programm, das ein Formular anzeigt, ... Lieblingsfarbe auswählen ... speichern in Session...</p>\n\n";

print "<p>Auf dieser Seite soll die vorher ausgesuchte Lieblingsfarbe angezeigt werden.</p>\n\n";

if (isset ($_SESSION['farbe']))
    {
    $lieblingsfarbe = & $_SESSION['farbe'];

print <<<HTML
<div style="width:25%;padding:30px;background-color:$lieblingsfarbe">
<p style="padding:20px;background-color:#fff;"><strong>Lieblingsfarbe: $lieblingsfarbe</strong></p>
</div>
HTML;
}

print "<h2>Aufgabe 3 (Sklar, S. 181), Bestellformular</h2>\n";

$kleidung = array (
    'Hosen',
    'Socken',
    'Schuhe',
    'Hemden',
    'Krawatten',
    'Jacken'
    );

schreibe_formular($kleidung);

function schreibe_formular($elemente)
    {
    print '<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="POST">
    <fieldset class="route">
    <legend>
    Bestellformular
    </legend>

    <table>';
    foreach($elemente as $wert)
        {
        print '<tr>
            <td class="rechts"><label for="id_' . $wert . '">' . $wert . ': </label></td>
            <td><input name="' . $wert . '" type="text" size="2" maxlength="2"></td>
        </tr>';
    }
    print '	<tr>
            <td></td>
            <td><input type="submit" value="bestellen"></td>
    </tr>
    </table>

    <input type="hidden" name="abgeschickt" value="1">
    </fieldset>
    </form>';
    if (isset ($_POST['abgeschickt']) && $_POST['abgeschickt'] == 1)
        {
        unset ($_POST['abgeschickt']);
        $_SESSION['bestellung'] = $_POST;
        print "<p>Zur <a href='session2.php'>nächsten Seite</a>, Bestellung anzeigen!</p>\n";
    }
}

var_dump($_POST);
print '<hr>';
var_dump($_SESSION);

require '../includes/uebungfooter.php';
?>

<?php
$titel = "Sessions, 2: Bestellung anzeigen";
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

print "<h2>Aufgabe 4 (Sklar, S. 181), Bestellformular</h2>\n";

if (isset ($_SESSION['bestellung']))
    {
    $bestellung = & $_SESSION['bestellung'];
    print '<ul>';
    foreach($bestellung as $name => $wert)
        {
        print '<li>' . $name . ': ' . $wert . '</li>';
    }
    print '</ul>';
}

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

    if (isset($_SESSION['bestellung']))
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
                <td><input name="' . $wert . '" type="text" size="2" maxlength="2" value="' . intval($_SESSION['bestellung'][$wert]) . '"></td>
            </tr>';
        }
        print '	<tr>
                <td></td>
                <td><input type="submit" value="löschen"></td>
        </tr>
        </table>
        <input type="hidden" name="loeschen" value="1">
        </fieldset>
        </form>';

    } else {
        print '<p>Bitte bestellen Sie etwas auf <a href="session1.php">dieser Seite</a></p>';
    }

}

if (isset ($_POST['loeschen']) && $_POST['loeschen'] == 1)
    {
    unset ($_SESSION['bestellung']);
    print "<p>Ihre Bestellung wurde gelöscht!</p>\n";
}

print_r($_POST);
print '<hr>';
print_r($_SESSION);

require '../includes/uebungfooter.php';
?>

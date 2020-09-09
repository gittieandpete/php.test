<?php
$titel = "Cookies";
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

if (!isset($_COOKIE['user01']))
    {
    $i = 1;
    # user, wert, Dauer (0 heißt Standard, verfällt nach Schließen des Clients), Pfad
    setcookie('user01',$i,'0','/');
} elseif ($_COOKIE['user01'] < 11)
    {
    // $i = intval($_COOKIE['user01']) geht auch
    $i = (int)$_COOKIE['user01'] + 1;
    setcookie('user01',$i,'0','/');
} else {
    // cookie löschen, no2 auf '' setzten, alle anderen Angaben wiederholen
    setcookie('user01','','0','/');
    $i = 12;
}


print <<<HTML
<h2>Cookies setzen und lesen</h2>
    <p>1. Schreiben Sie eine Webseite, die Cookies verwendet usw... Sklar, Seite 181</p>
    <p>Cookie ausgeben: Diese Seite hast du $i mal besucht. </p>
    <p> 2. Modifizieren Sie die Seite (besondere Nachrichten alle 5 mal, nach dem 12. Mal Cookie löschen)...</p>
HTML;

if ($i%5 == 0)
print "<p>Jubiläum! Du warst schon <strong>$i</strong> mal hier!</p>";
if ($i == 12)
print "<p>So, das Cookie wird jetzt gelöscht.</p>";

print "<p>Schreiben Sie ein PHP_Programm, das ein Formular anzeigt, ... Lieblingsfarbe auswählen ... speichern in Session...</p>";

?>

<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
<fieldset class="route">
<legend>
Lieblingsfarbe aussuchen
</legend>

<table>
    <tr>
        <td class="rechts"><label for="id_farbe">Farbe</label></td>
        <td>
            <select size="1" name="farbe" id="id_farbe">

<?php

$farbe = array (
    'gelb'	 => 'yellow',
    'rot'	 => 'red',
    'grün'	 => 'green',
    'blau'	 => 'blue',
    'braun'	 => 'maroon',
    'orange'	 => 'orange',
    'lila'	 => 'purple',
    'hellgrün'	 => 'lime',
    'grau'	 => 'silver'
    );

foreach($farbe as $name => $wert)
    print "\t<option value=\"$wert\">$name</option>\n";
?>

            </select>
            </td>
</tr>
<tr>
    <td></td>
    <td><input type="submit" value="ok"></td>
</tr>
</table>

<input type="hidden" name="abgeschickt" value="1">
</fieldset>
</form>

<?php

if (isset ($_POST['abgeschickt']) && $_POST['abgeschickt'] == 1)
    {
    $_SESSION['farbe'] = $_POST['farbe'];
    var_dump($_SESSION['farbe']);
    print "<p>Zur <a href='session1.php'>nächsten Seite</a>, Lieblingsfarbe anzeigen!</p>\n";
}





require '../includes/uebungfooter.php';
?>

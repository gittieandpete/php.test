<?php
$titel = "T9";
$menuitem = '';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php';

print "<h1>$titel</h1>";


print "<p>Beispiel: 4376</p>";

print "<form method=\"POST\" action=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "\">\n";
print "<fieldset>\n";
print "\t<legend>T9, Zahlen eingeben</legend>\n";
    input_text('t9', 'Eingabe');
    input_submit('los', 'Abschicken');
print "</fieldset>\n";
print "</form>\n\n";

if (isset($_POST['t9']))
    {
    $zahl = intval(substr($_POST['t9'],0,7));
    $treffer = t9($zahl);
    if ($treffer)
        {
        print "<p>Ergebnisse für $zahl: ";
        foreach ($treffer as $wort)
            {
            print "$wort, ";
        }
        print "</p>\n\n";
    }
}

function t9($zahl)
{
    $t9datei = 'info/wortliste.txt';
    $t9 = array(
        2 => array('a', 'b', 'c', 'ä'),
        3 => array('d', 'e', 'f'),
        4 => array('g', 'h', 'i'),
        5 => array('j', 'k', 'l'),
        6 => array('m', 'n', 'o', 'ö'),
        7 => array('p', 'q', 'r', 's', 'ß'),
        8 => array('t', 'u', 'v', 'ü'),
        9 => array('w', 'x', 'y', 'z')
    );
    $seite = file_get_contents($t9datei);
    $wortliste = preg_split("/[\n]/", $seite);
    // print_r($wortliste);

    $zahl_arr = str_split($zahl);
    if (in_array('1',$zahl_arr) || in_array('0',$zahl_arr))
        {
        print 'Gib eine richtige Zahl ein (auf der Null oder Eins sind keine Buchstaben...)!';
        return false;
    }
    if (count($zahl_arr) < 2)
        {
        print 'Gib bitte mehr als eine Zahl ein!';
        return false;
    }
    for ($i = 0; $i < count($zahl_arr); $i++)
        {
        // ausgabe($zahl_arr[$i], "$i. Zahl");
        $buchstaben_arr = $t9[$zahl_arr[$i]];
        // ausgabe($buchstaben_arr);
        for ($k = 0; $k < count($buchstaben_arr); $k++)
            {
            // ausgabe($buchstaben_arr[$k], "$k. Buchstabe");
            if ($i == 0)
                {
                $suchmuster = "^$buchstaben_arr[$k].+";
                // ausgabe($suchmuster,'Suchmuster');
                foreach($wortliste as $wort)
                    {
                    if(preg_match("|$suchmuster|i",$wort)) $liste[$i][] = $wort;
                }
            } elseif (isset($liste[$i-1]) && count($liste[$i-1]) > 0)
                {
                $suchmuster = '^.{' . $i . "}$buchstaben_arr[$k].*$";
                foreach($liste[$i-1] as $wort)
                    {
                    if(preg_match("|$suchmuster|i",$wort)) $liste[$i][] = $wort;
                }
                if (isset($liste[$i]) && count($liste[$i]) > 0)
                    {
                $ergebnis = $liste[$i];
                }
            }
        }
    }
return ($ergebnis);
}

require 'includes/uebungfooter.php';
?>

<?php
$titel = "Kakuro";
$menuitem = 'kakuro';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php';

print "<h1>$titel</h1>";

print "<p>Dies ist die Endfassung, die Vorgänger siehe Menü</p>";

$max = 9;
$liste = array();

for ($i=1;$i<=$max;$i++)
    {
    $liste[]=$i;
}

kakuro($liste);

function kakuro($liste)
    {
    $neueliste = array();
    for ($k=0;$k<count($liste);$k++)
        {
        for ($i=1;$i<=$GLOBALS['max'];$i++)
            {
            // Leerzeichen für explode in summieren()
            if (substr($liste[$k],0,1) > $i) $neueliste[] = "$i " . $liste[$k];
        }
    }
    summieren($neueliste);
    // Rekursion
    if (count($neueliste)>1) kakuro($neueliste);
}

function summieren($liste)
    {
    $summe=0;
    foreach($liste as $wert)
        {
        $summanden=explode(' ',$wert);
        foreach($summanden as $summand)
            {
            $summe+=$summand;
        }
        $neueliste[$summe][]= "$wert";
        $summe=0;
    }
    kakuroausgabe($neueliste);
}

function kakuroausgabe($liste)
    {
    static $a = 2;
    $lfdnr = 0;
    $anzahlspalten=1;
    print '<p id="stellen' . $a . '">' . "\n";
    for ($i=2;$i<=$GLOBALS['max'];$i++)
        {
        print "\t" . '<a href="#stellen' . $i . '">' . $i . "</a>\n";
    }
    print "</p>\n\n";
    print '<table class="kakuro4">' . "\n";
    print "\t<tr>\n\t" . '<th colspan="' . $anzahlspalten*2 . '">' . $a . ' Stellen</th></tr>' . "\n\n";
    print "\t<tr>\n";
    foreach($liste as $schluessel => $wert)
        {
        $lfdnr++;
        sort($wert);
        print "\t<td>\n\t" . '<pre class="rot">' . $schluessel . "</pre>\n\t</td>\n\t<td>\n\t<pre>";
        foreach($wert as $kombi)
            {
            print str_replace(' ','',$kombi) . "\n";
        }
        print "</pre></td>\n";
        if ($lfdnr%$anzahlspalten==0) print "\t</tr><tr>\n";
    }
    print "</table>\n\n";
    $a++;
}

print "<div style='clear:both;'></div>";

require 'includes/uebungfooter.php';
?>

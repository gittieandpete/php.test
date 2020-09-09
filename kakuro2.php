<?php
$titel = "Kakuro improved";
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

print '<pre>

Konzept:

123456789
1 als string davorsetzen:
(11)12 13 14 15 16 17 18 19
2+
    23 24 25 26 27 28 29
3+
    34 35 36 37 38 39
usw
1+
123 124 125
2+

</pre>';

$max = 9;
$liste = array();

for ($i=1;$i<=$max;$i++)
    {
    $liste[]=$i;
}

kakuro($liste);

print "\t</tr>\n</table>\n\n";

function kakuro($liste)
    {
    static $a = 0;
    $a++;
    if ($a > 1000) return;
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
    // sort($neueliste);
    // kakuroausgabe($neueliste);
    // print "Safety: $a\n\n";
    print "Elemente in Liste (Pascal): " . count($neueliste) . "\n\n";
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
        $neueliste[]=str_pad($summe,2,0,STR_PAD_LEFT) . ": $wert";
        $summe=0;
    }
    sort($neueliste);
    kakuroausgabe($neueliste);
}

function kakuroausgabe ($liste)
    {
    $anzahlspalten=4;
    static $lfdnr = 0;
    if ($lfdnr==0) print "\n\n<table class=\"kakuro\">\n\t<tr>\n";
    if ($lfdnr%$anzahlspalten==0 && $lfdnr>0) print "\t</tr>\n\n\t<tr>\n";
    print "\t<td><pre>\n";
    foreach ($liste as $wert)
        {
        print "$wert\n";
    }
    print "\t</pre></td>\n\n";
    $lfdnr++;
}


print "<div style='clear:both;'></div>";

require 'includes/uebungfooter.php';
?>

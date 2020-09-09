<?php
$titel = "Kakuro, Ausgabe verbessert";
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

function kakuroausgabe ($liste)
    {
    static $a = 2;
    static $lfdnr = 0;
    $anzahlspalten=8;
    print "<table class=\"kakuro ";
    if ($lfdnr%$anzahlspalten==0 && $lfdnr>0) print " kakurobreak\">\n"; else print "\">\n";
    print "\t<tr>\n\t<th colspan=\"2\">$a Stellen</th></tr>\n\n";
    foreach($liste as $schluessel => $wert)
        {
        sort($wert);
        print "\t<tr>\n\t<td>\n\t<pre>$schluessel</pre>\n\t</td>\n\t<td>\n\t<pre>";
        foreach($wert as $kombi)
            {
            print str_replace(' ','',$kombi) . "\n";
        }
        print "</pre></td></tr>\n\n";
    }
    print "</table>\n\n";
    $a++;
    $lfdnr++;
}

print "<div style='clear:both;'></div>";

require 'includes/uebungfooter.php';
?>

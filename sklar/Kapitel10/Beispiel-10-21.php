<?php
$fh = fopen('leute.txt','rb');
if (! $fh) {
    print "Fehler beim �ffnen von leute.txt: $php_errormsg";
} else {
    for ($zeile = fgets($fh); ! feof($fh); $zeile = fgets($fh)) {
        if ($zeile === false) {
            print "Fehler beim Lesen der Zeile: $php_errormsg";
        } else {
            $zeile = trim($zeile);
            $info = explode('|', $zeile);
            print '<li><a href="mailto:' . $info[0] . '">' . $info[1] ."</li>\n";
        }
    }
    if (! fclose($fh)) {
        print "Fehler beim Schlie�en von leute.txt: $php_errormsg";
    }
}
?>
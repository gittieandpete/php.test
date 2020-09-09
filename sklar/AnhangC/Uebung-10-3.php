<?php
$fh = fopen('csvdaten.csv', 'rb');

if (! $fh) {
    die("Kann csvdaten.csv nicht öffnen: $php_errormsg");
}

print "<table>\n";
       
for ($zeile = fgetcsv($fh, 1024); ! feof($fh); $zeile = fgetcsv($fh, 1024)) {
    // implode() wie in Example 4.21 verwenden
    print '<tr><td>' . implode('</td><td>', $zeile) . "</td></tr>\n";
}

print '</table>';
?>
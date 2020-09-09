<?php
print '<table>';
print '<tr><th>Jahr</th><th>Tag der Arbeit</th></tr>';
for ($jahr = 2004; $jahr <= 2020; $jahr++) {
    // Den Zeitstempel für den 1. September von $jahr abrufen
    $zeitstempel = mktime(12,0,0,9,1,$jahr);
    // Zum ersten Montag vorrücken
    $zeitstempel = strtotime('monday', $zeitstempel);
    print "<tr><td>$jahr</td><td>";
    print date('j', $zeitstempel).'. '.date('F', $zeitstempel);
    print "</td></tr>\n";
}
print '</table>';
?>
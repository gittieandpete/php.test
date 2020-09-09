<?php
$zeilenfarbe = array('red','green');
$abendessen = array('Mais und Spargel',
                    'Zitronen-Huhn',
                    'Gedünstete Bambuspilze');
print "<table>\n";

for ($i = 0, $anzahl_gerichte = count($abendessen); $i < $anzahl_gerichte; $i++) {
    print '<tr bgcolor="' . $zeilenfarbe[$i % 2] . '">';
    print "<td>Element $i</td><td>$abendessen[$i]</td></tr>\n";
}
print '</table>';
?>
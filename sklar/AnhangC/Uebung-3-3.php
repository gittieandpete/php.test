<?php
$fahr = -50;
$fahr_grenze = 50;
print '<table>';
print '<tr><th>Fahrenheit</th><th>Celsius</th></tr>';
while ($fahr <= $fahr_grenze) {
    $celsius = ($fahr - 32) * 5 / 9;
    print "<tr><td>$fahr</td><td>$celsius</td></tr>";
    $fahr += 5;
}
print '</table>';
?>
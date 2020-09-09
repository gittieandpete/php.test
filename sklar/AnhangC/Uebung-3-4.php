<?php
print '<table>';
print '<tr><th>Fahrenheit</th><th>Celsius</th></tr>';
for ($fahr = -50; $fahr <= 50; $fahr += 5) {
    $celsius = ($fahr - 32) * 5 / 9;
    print "<tr><td>$fahr</td><td>$celsius</td></tr>";
}
print '</table>';
?>
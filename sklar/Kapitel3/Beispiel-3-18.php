<?php
$i = 1;
print '<select name="leute">';
while ($i <= 10) {
    print "<option>$i</option>\n";
    $i++;
}
print '</select>';
?>
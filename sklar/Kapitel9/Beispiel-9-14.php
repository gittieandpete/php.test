<?php
print '<select name="stunde">';
for ($stunde = 1; $stunde <= 24; $stunde++) {
    print '<option value="' . $stunde . '">' . $stunde ."</option>\n";
}
print "</select>:";

print '<select name="minute">';
for ($minute = 0; $minute < 60; $minute += 5) {
    printf('<option value="%02d">%02d</option>', $minute, $minute);
}
print "</select> \n";
?>
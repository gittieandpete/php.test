<?php
$monate = array(1 => 'Januar', 2 => 'Februar', 3 => 'M�rz', 4 => 'April', 
                5 => 'Mai', 6 => 'Juni', 7 => 'Juli', 8 => 'August',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 
                12 => 'Dezember');

print '<select name="tag">';
// Eine Wahlm�glichkeit f�r jeden Tag von 1 bis 31
for ($i = 1; $i <= 31; $i++) {
    print '<option value="' . $i . '">' . $i ."</option>\n";
}
print "</select> \n";

print '<select name="monat">';
// Eine Wahlm�glichkeit f�r jedes Element in $monate
foreach ($monate as $nummer => $monatsname) {
    print '<option value="' . $nummer . '">' . $monatsname ."</option>\n";
}
print "</select> \n";

print '<select name="jahr">';
// Eine Wahlm�glichkeit f�r jedes Jahr von letztem Jahr an bis in f�nf Jahren
for ($jahr = date('Y') -1, $max_jahr = date('Y') + 5; $jahr < $max_jahr; $jahr++) {
    print '<option value="' . $jahr . '">' . $jahr ."</option>\n";
}
print "</select> \n";
?>
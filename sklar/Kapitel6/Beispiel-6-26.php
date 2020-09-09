<?php
$suesswaren = array('windbeutel' => 'Sesam-Windbeutel',
                    'happen' => 'Kokosnuss-Gelee-Happen',
                    'toertchen' => 'Karamell-Törtchen',
                    'reisfleisch' => 'Süßer Reis mit Fleisch');

print '<select name="suesswaren">';
// $option ist der Optionswert, $label der angezeigte Optionstext
foreach ($suesswaren as $option => $label) {
    print '<option value="' .$option .'"';
    if ($option == $standardwert['suesswaren']) {
        print ' selected="selected"';
    }
    print "> $label</option>\n";
}
print '</select>';
?>
<?php

// Ein Textfeld ausgeben
function input_text($elementname, $werte) {
    print '<input type="text" name="' . $elementname .'" value="';
    print htmlentities($werte[$elementname]) . '">';
}

// Einen Absenden-Button ausgeben
function input_submit($elementname, $label) {
    print '<input type="submit" name="' . $elementname .'" value="';
    print htmlentities($label) .'"/>';
}

// Ein mehrzeiliges Textfeld ausgeben
function input_textarea($elementname, $werte) {
    print '<textarea name="' . $elementname .'">';
    print htmlentities($werte[$elementname]) . '</textarea>';
}

// Einen Radiobutton oder eine Checkbox ausgeben
function input_radiocheck($typ, $elementname, $werte, $elementwert) {
    print '<input type="' . $typ . '" name="' . $elementname .'" value="' . $elementwert . '" ';
    if ($elementwert == $werte[$elementname]) {
        print ' checked="checked"';
    }
    print '/>';
}

// Ein <select>-Men� ausgeben
function input_select($elementname, $ausgewaehlt, $optionen, $multiple = false) {
    // Das <select>-Tag ausgeben
    print '<select name="' . $elementname;
    // Wenn mehrere Auswahlen m�glich sind, das multiple-Attribut 
    // hinzuf�gen und an das Ende des Tag-Namens ein [  ] anh�ngen
    if ($multiple) { print '[]" multiple="multiple'; }
    print '">';

    // Die Liste der ausw�hlbaren Dinge einrichten
    $ausgewaehlte_optionen = array(  );
    if ($multiple) {
        foreach ($ausgewaehlt[$elementname] as $wert) {
            $ausgewaelte_optionen[$wert] = true;
        }
    } else {
        $ausgewaelte_optionen[ $ausgewaehlt[$elementname] ] = true;
    }

    // Die <option>-Tags ausgeben
    foreach ($optionen as $option => $label) {
        print '<option value="' . htmlentities($option) . '"';
        if ($ausgewaelte_optionen[$option]) {
            print ' selected="selected"';
        }
        print '>' . htmlentities($label) . '</option>';
    }
    print '</select>';
}

?>
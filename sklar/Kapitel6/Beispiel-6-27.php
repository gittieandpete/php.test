<?php
$hauptgerichte = array('gurke' => 'Ged�nstete Seegurke',
                       'magen' => "Sautierter Schweinemagen",
                       'kutteln' => 'Sautierte Kutteln in Calvados',
                       'taro' => 'Geschmortes Schwein mit Taro',
                       'gaense' => 'Geschmortes G�nseklein mit Salz', 
                       'abalone' => 'Abalone mit Mark und Entenf��en');

print '<select name="hauptgericht[  ]" multiple="multiple">';

$gewaehlte_optionen = array(  );
foreach ($standardwert['hauptgericht'] as $option) {
    $gewaehlte_option[$option] = true;
}

// Die <option>-Tags ausgeben
foreach ($hauptgerichte as $option => $label) {
    print '<option value="' . htmlentities($option) . '"';
    if ($selected_options[$option]) {
        print ' selected="selected"';
    }
    print '>' . htmlentities($label) . '</option>';

    print "\n";
}
print '</select>';
?>
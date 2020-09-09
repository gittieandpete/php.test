function validiere_formular(  ) {
    $fehler = array(  );
    // Die Ausgabe von var_dump(  ) mit Ausgabepufferung einfangen
    ob_start(  );
    var_dump($_POST);
    $vars = ob_get_contents(  );
    ob_end_clean(  );
    // Die Ausgabe ins Fehlerprotokoll schicken
    error_log($vars);
    // Operand 1 muss numerisch sein
    if (! strlen($_POST['operand_1'])) {
        $fehler[  ] = 'Geben Sie eine Zahl für den ersten Operanden ein.';
    } elseif (! floatval($_POST['operand_1']) == $_POST['operand_1']) {
        $fehler[  ] = "Der erste Operand muss numerische sein.";
    }
    // Operand 2 muss numerisch sein
    if (! strlen($_POST['operand_2'])) {
        $fehler[  ] = 'Geben Sie eine Zahl für den zweiten Operanden ein.';
    } elseif (! floatval($_POST['operand_2']) == $_POST['operand_2']) {
        $fehler[  ] = "Der zweite Operand muss numerisch sein.";
    }
    // Der Operator muss gültig sein
    if (! in_array($_POST['operator'], $GLOBALS['ops'])) {
        $fehler[  ] = "Wählen Sie einen gültigen Operator.";
    }
    return $fehler;
}

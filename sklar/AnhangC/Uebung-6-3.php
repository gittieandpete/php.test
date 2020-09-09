<?php
$ops = array('+','-','*','/');
if ($_POST['_abgeschickt_test']) {
    // Wenn validiere_formular(  ) Fehler liefert, übergebe
    // sie an zeige_formular(  )
    if ($formularfehler = validiere_formular(  )) {
        zeige_formular($formularfehler);
    } else {
        // Sind die übermittelten Daten gültig, verarbeite sie
        verarbeite_formular(  );
    }
} else {
    // Kein Formular übermittelt, also zeige es an
    zeige_formular(  );
}
function zeige_formular($fehler = '') {
    if ($fehler) {
        print 'Bitte beheben Sie die folgenden Fehler: <ul><li>';
        print implode('</li><li>',$fehler);
        print '</li></ul>';
    }
    // Der Anfang des Formulars
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    // Der erste Operand
    print '<input type="text" name="operand_1" size="5" value="';
    print htmlspecialchars($_POST['operand_1']) .'"/>';
    // Der Operator
    print '<select name="operator">';
    foreach ($GLOBALS['ops'] as $op) {
        print '<option';
        if ($_POST['operator'] == $op) { print ' selected="selected"'; }
        print "> $op</option>";
    }
    print '</select>';
    // Der zweite Operand
    print '<input type="text" name="operand_2" size="5" value="';
    print htmlspecialchars($_POST['operand_2']) .'"/>';
    // Der Absenden-Button
    print '<br/><input type="submit" value="Berechnen"/>';
    // Die verborgene Variable _abgeschickt_test
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    // Das Ende des Formulars
    print '</form>';
}
function validiere_formular(  ) {
    $fehler = array(  );
    // Operand 1 muss numerisch sein
    if (! strlen($_POST['operand_1'])) {
        $fehler[  ] = 'Geben Sie eine Zahl für den ersten Operanden ein.';
    } elseif (! strval(floatval($_POST['operand_1'])) == $_POST['operand_1']) {
        $fehler[  ] = "Der erste Operand muss numerisch sein.";
    }
    // Operand 2 muss numerisch sein
    if (! strlen($_POST['operand_2'])) {
        $fehler[  ] = 'Geben Sie eine Zahl für den zweiten Operanden ein.';
    } elseif (! strval(floatval($_POST['operand_2'])) == $_POST['operand_2']) {
        $fehler[  ] = "Der zweite Operand muss numerisch sein.";
    }
    // Der Operator muss gültig sein
    if (! in_array($_POST['operator'], $GLOBALS['ops'])) {
        $fehler[  ] = "Bitte wählen Sie einen gültigen Operator.";
    }
    return $fehler;
}
function verarbeite_formular(  ) {
    if ('+' == $_POST['operator']) {
        $gesamt = $_POST['operand_1'] + $_POST['operand_2'];
    } elseif ('-' == $_POST['operator']) {
        $gesamt = $_POST['operand_1'] - $_POST['operand_2'];
    } elseif ('*' == $_POST['operator']) {
        $gesamt = $_POST['operand_1'] * $_POST['operand_2'];
    } elseif ('/' == $_POST['operator']) {
        $gesamt = $_POST['operand_1'] / $_POST['operand_2'];
    }
    print "$_POST[operand_1] $_POST[operator] $_POST[operand_2] = $gesamt";
}
?>
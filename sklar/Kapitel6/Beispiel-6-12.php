if ($_POST['preis'] != strval(floatval($_POST['preis']))) {
    $fehler[  ] = 'Bitte geben Sie einen gültigen Preis ein.';
}

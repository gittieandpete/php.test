if (! array_key_exists($_POST['bestellung'], $GLOBALS['suesswaren'])) {
    $fehler[  ] = 'Bitte wählen Sie ein Gericht aus der Liste aus.';
}

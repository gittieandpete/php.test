if (! array_key_exists($_POST['bestellung'], $GLOBALS['suesswaren'])) {
    $fehler[  ] = 'Bitte w�hlen Sie ein Gericht aus der Liste aus.';
}

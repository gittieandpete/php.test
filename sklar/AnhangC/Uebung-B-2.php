if (! preg_match('/^[a-z0-9]$/i', $_POST['benutzername'])) {
    $fehler[  ] = "Benutzernamen d�rfen nur aus Buchstaben und Ziffern bestehen.";
}
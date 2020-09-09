if (! preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', 
                 $_POST['email'])) {
    $fehler[  ] = 'Bitte geben Sie eine gültige E-Mail-Adresse ein';
}

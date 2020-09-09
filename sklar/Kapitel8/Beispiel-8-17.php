function validiere_formular(  ) {
    global $db;

    $fehler = array(  );

    $verschluesseltes_passwort = $db->getOne('SELECT passwort FROM benutzer WHERE benutzername = ?',
                                      array($_POST['benutzername']));
   
    if ($verschluesseltes_passwort != crypt($_POST['passwort'], $verschluesseltes_passwort)) {
        $fehler[  ] = 'Bitte geben Sie gültigen Benutzernamen und Passwort ein.';
    }

    return $fehler;
}
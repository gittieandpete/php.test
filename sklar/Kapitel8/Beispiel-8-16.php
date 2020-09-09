function validiere_formular(  ) {
    $fehler = array(  );

    // Beispiele für Benutzer mit verschlüsselten Passwörtern
    $benutzer = array('alice'    => '$1$LdB0G7jx$zVu.6YDfT2M3PcIq3xUdD0',
                      'richard'  => '$1$YY/mMevB$6KEH9LLrjZnuemGml9GRE/',
                      'karlchen' => '$1$q.hxaUR9$Pu/NxLQeyMgF7lmCJ3FBo/');
 
     // Sicherstellen, dass der Benutzername gültig ist
    if (! array_key_exists($_POST['benutzername'], $benutzer)) {
        $fehler[  ] = 'Bitte geben Sie gültigen Benutzernamen und Passwort ein.';
    }
                                   
    // Prüfen, ob das Passwort korrekt ist
    $gespeichertes_passwort = $benutzer[ $_POST['benutzername'] ];
    if ($gespeichertes_passwort != crypt($_POST['benutzername'], $gespeichertes_passwort)) {
        $fehler[  ] = 'Bitte geben Sie gültigen Benutzernamen und Passwort ein.';
    }

    return $fehler;
}

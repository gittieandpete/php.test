// Ein zu verschlüsselnder String
$daten = 'Kontonummer: 213-1158238-23; PIN: 2837';
// Der geheime Schlüssel, mit dem er verschlüsselt werden soll
$schluessel  = "Vielleicht sollte man darauf verzichten, Quecksilber zu trinken.";

// Einen Algorithmus und einen Verschlüsselungmodus auswählen
$algorithmus = MCRYPT_BLOWFISH;
$modus = MCRYPT_MODE_CBC;
// Einen Initialisierungsvektor erzeugen
$iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithmus,$modus),
                       MCRYPT_DEV_URANDOM);

// Die Daten verschlüsseln
$verschluesselte_daten = mcrypt_encrypt($algorithmus, $schluessel, 
                                        $daten, $modus, $iv);

// Die Daten entschlüsseln
$entschluesselte_daten = mcrypt_decrypt($algorithmus, $schluessel, 
                                        $verschluesselte_daten, $modus, $iv);

print "Die entschlüsselten Daten sind $entschluesselte_daten";

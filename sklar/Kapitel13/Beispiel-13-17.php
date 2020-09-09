// Ein zu verschl�sselnder String
$daten = 'Kontonummer: 213-1158238-23; PIN: 2837';
// Der geheime Schl�ssel, mit dem er verschl�sselt werden soll
$schluessel  = "Vielleicht sollte man darauf verzichten, Quecksilber zu trinken.";

// Einen Algorithmus und einen Verschl�sselungmodus ausw�hlen
$algorithmus = MCRYPT_BLOWFISH;
$modus = MCRYPT_MODE_CBC;
// Einen Initialisierungsvektor erzeugen
$iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithmus,$modus),
                       MCRYPT_DEV_URANDOM);

// Die Daten verschl�sseln
$verschluesselte_daten = mcrypt_encrypt($algorithmus, $schluessel, 
                                        $daten, $modus, $iv);

// Die Daten entschl�sseln
$entschluesselte_daten = mcrypt_decrypt($algorithmus, $schluessel, 
                                        $verschluesselte_daten, $modus, $iv);

print "Die entschl�sselten Daten sind $entschluesselte_daten";

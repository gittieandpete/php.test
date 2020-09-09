// Führe zuerst das gewöhnliche Quoting der Werte durch
$gericht = $db->quoteSmart($_POST['gerichtsuche']);
// Stelle dann den Unterstrichen und Prozentzeichen Backslashes voran
$gericht = strtr($gericht, array('_' => '\_', '%' => '\%'));
// Jetzt wurde $gericht gesäubert und kann direkt in die Abfrage interpoliert werden
$treffer = $db->getAll("SELECT gerichtname, preis FROM gerichte
                        WHERE gerichtname LIKE $gericht");

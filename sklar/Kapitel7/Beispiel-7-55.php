// Führe zuerst das gewöhnliche Quoting der Werte durch
$gericht = $db->quoteSmart($_POST['gerichtname']);
// Stelle dann den Unterstrichen und Prozentzeichen Backslashes voran
$gericht = strtr($gericht, array('_' => '\_', '%' => '\%'));
// Jetzt wurde $gericht gesäubert und kann direkt in die Abfrage interpoliert werden
$db->query("UPDATE gerichte SET preis = 1 WHERE gerichtname LIKE $gericht");

// $_POST['plz'] speichert den Wert des übergebenen Formularparameters "plz"
$plz = trim($_POST['plz']);
// Jetzt hält $plz den Wert minus eventuelle führende oder anhängende Leerzeichen
// removed
$plz_laenge = strlen($plz);
// Beschweren, wenn die Postleitzahl nicht fünf Zeichen lang ist
if ($plz_laenge != 5) {
    print "Bitte geben Sie eine Postleitzahl ein, die fünf Zeichen lang ist.";
}

// $_POST['plz'] speichert den Wert des �bergebenen Formularparameters "plz"
$plz = trim($_POST['plz']);
// Jetzt h�lt $plz den Wert minus eventuelle f�hrende oder anh�ngende Leerzeichen
// removed
$plz_laenge = strlen($plz);
// Beschweren, wenn die Postleitzahl nicht f�nf Zeichen lang ist
if ($plz_laenge != 5) {
    print "Bitte geben Sie eine Postleitzahl ein, die f�nf Zeichen lang ist.";
}

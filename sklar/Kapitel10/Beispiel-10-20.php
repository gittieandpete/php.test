$seite = file_get_contents('seitenschablone.php');
// Beachten Sie die drei Gleichheitszeichen im Vergleichsausdruck
if ($seite === false) {
   print "Konnte die Schablone nicht laden: $php_errormsg";
} else {
   // ... verarbeiten Sie hier die Schablone
}

// Aus benutzer die Schrägstriche entfernen
$benutzer = str_replace('/', '', $_POST['benutzer']);
// .. aus benutzer entfernen
$benutzer = str_replace('..', '', $benutzer);

print 'Benutzerprofil für ' . htmlentities($benutzer) .': <br/>';
print file_get_contents("/usr/local/data/$benutzer");

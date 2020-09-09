<?php
$_POST[benutzer] = lars;
$dateiname = realpath("/usr/local/data/$_POST[benutzer]");
print $dateiname."\n";
print substr($dateiname, 0, 16)."\n";
// Sicherstellen, dass $dateiname unterhalb von /usr/local/data liegt
if ('/usr/local/data/' == substr($dateiname, 0, 16)) {
    print 'Benutzerprofil für ' . htmlentities($_POST['benutzer']) .': <br/>';
    print file_get_contents($dateiname);
} else {
    print "Es wurde ein ungültiger Benutzer eingegeben. ";
}
?>
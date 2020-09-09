<?php
function seiten_kopf() {
    print '<html><head><title>Willkommen auf meiner Website</title></head>';
    print '<body bgcolor="#ffffff">';
}

seiten_kopf();
print "Willkommen $benutzer";
seiten_fuss();

function seiten_fuss() {
    print '<hr>Vielen Dank für Ihren Besuch.';
    print '</body></html>';
}
?>
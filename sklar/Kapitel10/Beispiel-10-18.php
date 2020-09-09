<?php
$log_datei = '/var/log/users.log';
if (is_writeable($log_datei)) {
    $fh = fopen($log_datei,'ab');
    fwrite($fh, $_SESSION['benutzername'] . ' um ' . strftime('%c') . "\n");
    fclose($fh);
} else {
    print "Kann nicht in Log-Datei schreiben.";
}
?>
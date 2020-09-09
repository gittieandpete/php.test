<?php
session_start(  );

$_SESSION['zaehler'] = $_SESSION['zaehler'] + 1;

print "Sie haben diese Seite " . $_SESSION['zaehler'] . ' Mal besucht.';
?>

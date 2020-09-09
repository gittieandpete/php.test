<?php
$schablonendatei = 'seitenschablone.php';
if (is_readable($schablonendatei)) {
    $schablone = file_get_contents($schablonendatei);
} else {
    print "Kann Schablonendatei nicht lesen.";
}
?>
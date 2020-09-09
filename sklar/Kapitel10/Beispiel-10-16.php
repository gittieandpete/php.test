<?php
if (file_exists('/usr/local/htdocs/index.php')) {
    print "Es gibt eine Index-Datei.";
} else {
    print "In /usr/local/htdocs gibt es keine Index-Datei.";
}
?>
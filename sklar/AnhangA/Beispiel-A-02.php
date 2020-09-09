<?php
require 'DB.php';
if (class_exists('DB')) {
    print "OK";
} else {
    print "Fehler";
}
?>
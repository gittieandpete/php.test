<?php
session_start(  );

if (array_key_exists('benutzername', $_SESSION)) {
    print "Hallo $_SESSION[benutzername].";
} else {
    print 'Wie geht\'s, Fremder.';
}
?>
if ($eingeloggt) {
    // Das wird ausgef�hrt, wenn $eingeloggt true ist
    print "Willkommen, bekannter Benutzer.";
} elseif ($neue_nachrichten) {
    // Das wird ausgef�hrt, wenn $eingeloggt false und $neue_nachrichten true ist
    print "Lieber Fremder, es gibt neue Nachrichten.";
} elseif ($notfall) {
    // Das wird ausgef�hrt, wenn $eingeloggt und $neue_nachrichten false sind
    // und $notfall true ist
    print "Fremder, ist gibt keine neuen Nachrichten, aber es ist ein Notfall eingetreten.";
}

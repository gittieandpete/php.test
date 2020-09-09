if ($eingeloggt) {
    // Das wird ausgeführt, wenn $eingeloggt true ist
    print "Willkommen, bekannter Benutzer.";
} elseif ($neue_nachrichten) {
    // Das wird ausgeführt, wenn $eingeloggt false und $neue_nachrichten true ist
    print "Lieber Fremder, es gibt neue Nachrichten.";
} elseif ($notfall) {
    // Das wird ausgeführt, wenn $eingeloggt und $neue_nachrichten false sind
    // und $notfall true ist
    print "Fremder, ist gibt keine neuen Nachrichten, aber es ist ein Notfall eingetreten.";
} else {
    // Das wird ausgeführt, wenn $eingeloggt, $neue_nachrichten und
    // $notfall false sind
    print "Ich kenne Sie nicht, es gibt keine neuen Nachrichten und auch keinen Notfall.";
}

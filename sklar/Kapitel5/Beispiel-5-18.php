function kann_mit_bargeld_zahlen($verfuegbares_bargeld, $betrag) {
    if ($betrag > $verfuegbares_bargeld) {
        return false;
    } else {
        return true;
    }
}

$gesamt = restaurantrechnung(15.22,8.25,15);
if (kann_mit_bargeld_zahlen(20, $gesamt)) {
    print "Ich kann mit Bargeld zahlen.";
} else {
    print "Zeit für die Kreditkarte.";
}

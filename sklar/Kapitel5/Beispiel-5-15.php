function zahlungsweise($verfuegbares_bargeld, $betrag) {
    if ($betrag > $verfuegbares_bargeld) {
        return 'Kreditkarte';
    } else {
        return 'Bargeld';
    }
}

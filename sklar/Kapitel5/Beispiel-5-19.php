<?php
function vollstaendige_rechnung($gericht, $steuer, $tringeld, $verfuegbares_bargeld) {
    $steuerbetrag = $gericht * ($steuer / 100);
    $trinkgeldbetrag = $gericht * ($trinkgeld / 100);
    $gesamtbetrag = $gericht + $steuerbetrag + $trinkgeldbetrag;
    if ($gesamtbetrag > $verfuegbares_bargeld) {
        // Der Rechnungsbetrag übersteigt das Geld, was wir haben
        return false;
    } else {
        // Wir können diesen Betrag zahlen
        return $gesamtbetrag;
    }
}

if ($gesamt = vollstaendige_rechnung(15.22, 16, 15, 20)) {
    print "Ich zahle gerne $gesamt EUR.";
} else {
    print "Leider habe ich nicht genug Geld. Soll ich ein paar Teller spülen?";
}
?>
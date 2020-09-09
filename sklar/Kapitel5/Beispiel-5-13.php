function restaurantrechnung2($gericht, $steuer, $trinkgeld) {
    $steuerbetrag = $gericht * ($steuer / 100);
    $trinkgeldbetrag = $gericht * ($trinkgeld / 100);
    $gesamt_ohne_trinkgeld = $gericht + $steuerbetrag;
    $gesamt_mit_trinkgeld = $gericht + $steuerbetrag + $trinkgeldbetrag;

    return array($gesamt_ohne_trinkgeld, $gesamt_mit_trinkgeld);
}

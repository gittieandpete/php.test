function restaurantrechnung($gericht, $steuer, $trinkgeld) {
    $steuerbetrag = $gericht * ($steuer / 100);
    $trinkgeldbetrag = $gericht * ($trinkgeld / 100);
    $gesamtsumme = $gericht + $steuerbetrag + $trinkgeldbetrag;

    return $gesamtsumme;
}

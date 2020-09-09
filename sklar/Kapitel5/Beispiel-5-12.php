// Die Gesamtsumme für ein Essen für 15,22 EUR bei 16% Steuern und einem Trinkgeld von 15% ermitteln
$gesamt = restaurantrechnung(15.22, 8.25, 15);

print 'Ich habe nur 20 EUR Bargeld, also ...';
if ($gesamt > 20) {
    print "muss ich mit meiner Kreditkarte zahlen.";
} else {
    print "kann ich mit Bargeld bezahlen.";
}

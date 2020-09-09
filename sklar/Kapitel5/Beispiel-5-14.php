$gesamtsummen = restaurantrechnung2(15.22, 8.25, 15);

if ($gesamtsummen[0] < 20) {
    print 'Die Gesamtsumme ohne Trinkgeld ist kleiner als 20 EUR.';
}
if ($gesamtsummen[1] < 20) {
    print 'Die Gesamtsumme mit Trinkgeld ist kleiner als 20 EUR.';
}
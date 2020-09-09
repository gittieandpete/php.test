// Die Verwendung von sprintf() ist erforderlich, um 
// sicherzustellen, dass einstellige Hexadezimalzahlen 
// (wie 0) mit einer f�hrenden 0 ausgepolstert werden.
function farbe_erzeugen($rot, $gruen, $blau) {
    $rothex   = dechex($rot);
    $gruenhex = dechex($gruen);
    $blauhex  = dechex($blau);
    return sprintf('#%02s%02s%02s', $rothex, $gruenhex, $blauhex);
}

// Sie k�nnen sich auch auf die eingebaute Hexadezimal/Dezimal-Umwandlung 
// von sprintf() mit dem Formatzeichen %x st�tzen:
function farbe_erzeugen($rot, $gruen, $blau) {
    return sprintf('#%02x%02x%02x', $rot, $gruen, $blau);
}
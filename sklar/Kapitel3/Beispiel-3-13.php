<?php
// Diese Werte werden anhand der lexikalischen Reihenfolge verglichen
if ("x54321"> "x5678") {
    print 'Der String "x54321" ist größer als der String "x5678".';
} else {
    print 'Der String "x54321" ist nicht größer als der String "x5678".';
}

// Diese Werte werden anhand der numerischen Reihenfolge verglichen
if ("54321" > "5678") {
    print 'Der String "54321" ist größer als der String "5678".';
} else {
    print 'Der String "54321" ist nicht größer als der String "5678".';
}

// Diese Werte werden anhand der lexikalischen Reihenfolge verglichen
if ('6-Pack' < '55-Karten-Deck') {
    print 'Der String "6-Pack" ist kleiner als der String "55-Karten-Deck".';
} else {
    print 'Der String "6-Pack" ist nicht kleiner als der String "55-Karten-Deck".';
}

// Diese Werte werden anhand der numerischen Reihenfolge verglichen
if ('6-Pack' < 55) {
    print 'Der String "6-Pack" ist kleiner als die Zahl 55.';
} else {
    print 'Der String "6-Pack" ist nicht kleiner als die Zahl 55.';
}
?>
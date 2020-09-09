$x = strcmp("x54321","x5678"); 
if ($x > 0) {
    print 'Der String "x54321" ist größer als der String "x5678".';
} elseif ($x < 0) {
    print 'Der String "x54321" ist kleiner als der String "x5678".';
}

$x = strcmp("54321","5678");
if ($x > 0) {
    print 'Der String "54321" ist größer als der String "5678".';
} elseif ($x < 0) {
    print 'Der String "54321" ist kleiner als der String "5678".';
}

$x = strcmp('6-Pack','55-Karten-Deck');
if ($x > 0) {
    print 'Der String "6-Pack" ist größer als der String "55-Karten-Deck".';
} elseif ($x < 0) {
    print 'Der String "6-Pack" ist kleiner als der String "55-Karten-Deck".';
}

$x = strcmp('6-Pack',55);
if ($x > 0) {
    print 'Der String "6-Pack" ist größer als die Zahl 55.';
} elseif ($x < 0) {
    print 'Der String "6-Pack" ist kleiner als die Zahl 55.';
}

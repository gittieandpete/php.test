if (preg_match('/^(\d{5})(-(\d{4}))?$/',$_POST['zip'],$treffer)) {
    print "Der Anfang des ZIP-Kodes ist: $treffer[1]\n";
    // $treffer[2] enthält das, was im zweiten Klammernsatz steht:
    // den Bindestrich und die letzten vier Ziffern
    // $treffer[3] enthält nur die letzten vier Ziffern
    if (isset($treffer[2])) {
        print "ZIP+4 ist: $treffer[3]";
    }
}

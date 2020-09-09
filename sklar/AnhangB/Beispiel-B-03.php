// Den Wert von $_POST['zip'] mit dem Muster
// ^(\d{5})(-\d{4})?$ vergleichen
if (preg_match('/^(\d{5})(-\d{4})?$/',$_POST['zip'],$treffer)) {
    // $treffer[0] enthält den vollständigen ZIP-Kode
    print "$treffer[0] ist ein gültiger US-ZIP-Kode\n";
    // $treffer[1] enthält die fünf Stellen des Teils innerhalb der 
    // Klammernsätze
    print "$treffer[1] ist der fünf-stellige Teil des ZIP-Kodes\n";
    // Wenn Sie im String vorkommen, befinden sich Bindestrich und die
    // ZIP-4-Stellen in $treffer[2]
    if (isset($treffer[2])) {
        print "ZIP+4 ist $treffer[2];";
    } else {
        print "Es gibt kein ZIP+4";
    }
}

// Den Wert von $html mit dem Muster @<b>[^<]+</b> vergleichen
// Der Begrenzer ist @, da das Muster / enthält
$ist_fett = preg_match('@<b>([^<]+)</b>@',$html,$treffer);
if ($ist_fett) {
    // $treffer[1] enthält das, was innerhalb der <b></b>-Tags steht
    print "Der fette Text ist: $treffer[1]";
}

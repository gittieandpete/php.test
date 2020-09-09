<?php
session_start(  );

$hauptgerichte = array('gurke'   => 'Gedünstete Seegurke',
                       'magen'   => "Sautierter Schweinemagen",
                       'kutteln' => 'Sautierte Kutteln in Calvados',
                       'taro'    => 'Geschmortes Schweinefleisch mit Taro',
                       'gaense'  => 'Gebackenes Gänseklein mit Salz', 
                       'abalone' => 'Abalone mit Mark und Entenfüßen');

if (count($_SESSION['bestellung']) > 0) {
    print '<ul>';
    foreach ($_SESSION['bestellung'] as $bestellung) {
        $gerichtname = $hauptgerichte[ $bestellung['gericht'] ];
        print "<li> $bestellung[menge] mal $gerichtname </li>";
    } 
    print "</ul>";
} else {
    print "Sie haben nichts bestellt.";
}
?>

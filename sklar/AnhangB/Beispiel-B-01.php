<?php
$fleischsorten = "<b>Hund</b>, <b>Rind</b>, <b>Ente</b>";

// Bei einem nicht-gierigen Quantifizierer wird jedes Fleisch einzeln gefunden
preg_match_all('@<b>.*?</b>@',$fleischsorten,$treffer);
foreach ($treffer[0] as $fleisch) {
    print "Fleisch A: $fleisch\n";
}

// Bei einem gierigen Quantifizierer wird nur einmal der ganze String gefunden
preg_match_all('@<b>.*</b>@',$fleischsorten,$treffer);
foreach ($treffer[0] as $fleisch) {
    print "Fleisch B: $fleisch\n";
}
?>
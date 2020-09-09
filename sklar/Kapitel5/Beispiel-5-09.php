<?php
function countdown($start) {
    while ($start > 0) {
        print "$start..";
        $start--;
    }
    print "Boom!\n";
}

$zaehler = 5;
countdown($zaehler);
print "Jetzt ist der Zähler $zaehler";
?>
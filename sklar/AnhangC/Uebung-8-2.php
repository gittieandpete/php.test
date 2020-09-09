<?php
$seitenzaehler = $_COOKIE['seitenzaehler'] + 1;
if ($seitenzaehler == 20) {
    // Mit einem leeren Wert wird das Cookie gelöscht
    setcookie('seitenzaehler','');
    print "Zeit, noch einmal von vorn zu beginnen.";
} else {
    setcookie('seitenzaehler', $seitenzaehler);
    print "Anzahl der Besuche: $seitenzaehler";
    if ($seitenzaehler == 5) {
        print "<br/> Das ist Ihr fünfter Besuch.";
    } elseif ($seitenzaehler == 10) {
        print "<br/> Das ist Ihr zehnter Besuch. Haben Sie immer noch nicht genug von dieser Seite?";
    } elseif ($seitenzaehler == 15) {
        print "<br/> Das ist ihr fünfzehnter Besuch. Haben Sie nichts Besseres zu tun?";
    }
}
?>
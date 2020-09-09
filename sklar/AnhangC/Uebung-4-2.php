<?php
// Mit asort() über die Bevölkerung sortieren
$bevoelkerung = array('Berling, Berlin' => 3392425,
                      'Hamburg, Hamburg' => 1728806,
                      'München, Bayern' => 1234692,
                      'Köln, NRW' => 968639,
                      'Frankfurt am Main, Hessen' => 643726,
                      'Dortmund, NRW' => 590831,
                      'Stuttgart, Baden-Württemberg' => 588477,
                      'Essen, NRW' => 585481,
                      'Düsseldorf, NRW' => 571886,
                      'Bremen, Bremen' => 542987);
$gesamt_bevoelkerung = 0;
asort($bevoelkerung);
print "<table><tr><th>Stadt</th><th>Bevölkerung</th></tr>\n";
foreach ($bevoelkerung as $stadt => $menschen) {
    $gesamt_bevoelkerung += $menschen;
    print "<tr><td>$stadt</td><td>$menschen</td></tr>\n";
    
}
print "<tr><td>Gesamt</td><td>$gesamt_bevoelkerung</td></tr>\n";
print "</table>\n";

//Mit ksort() über den Stadtnamen zu sortieren
$bevoelkerung = array('Berling, Berlin' => 3392425,
                      'Hamburg, Hamburg' => 1728806,
                      'München, Bayern' => 1234692,
                      'Köln, NRW' => 968639,
                      'Frankfurt am Main, Hessen' => 643726,
                      'Dortmund, NRW' => 590831,
                      'Stuttgart, Baden-Württemberg' => 588477,
                      'Essen, NRW' => 585481,
                      'Düsseldorf, NRW' => 571886,
                      'Bremen, Bremen' => 542987);
$gesamt_bevoelkerung = 0;
ksort($bevoelkerung);
print "<table><tr><th>Stadt</th><th>Bevökerung</th></tr>\n";
foreach ($bevoelkerung as $stadt => $menschen) {
    $gesamt_bevoelkerung += $menschen;
    print "<tr><td>$stadt</td><td>$menschen</td></tr>\n";
    
}
print "<tr><td>Gesamt</td><td>$gesamt_bevoelkerung</td></tr>\n";
print "</table>\n";
?>
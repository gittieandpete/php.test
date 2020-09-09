<?php
// Mit asort() �ber die Bev�lkerung sortieren
$bevoelkerung = array('Berling, Berlin' => 3392425,
                      'Hamburg, Hamburg' => 1728806,
                      'M�nchen, Bayern' => 1234692,
                      'K�ln, NRW' => 968639,
                      'Frankfurt am Main, Hessen' => 643726,
                      'Dortmund, NRW' => 590831,
                      'Stuttgart, Baden-W�rttemberg' => 588477,
                      'Essen, NRW' => 585481,
                      'D�sseldorf, NRW' => 571886,
                      'Bremen, Bremen' => 542987);
$gesamt_bevoelkerung = 0;
asort($bevoelkerung);
print "<table><tr><th>Stadt</th><th>Bev�lkerung</th></tr>\n";
foreach ($bevoelkerung as $stadt => $menschen) {
    $gesamt_bevoelkerung += $menschen;
    print "<tr><td>$stadt</td><td>$menschen</td></tr>\n";
    
}
print "<tr><td>Gesamt</td><td>$gesamt_bevoelkerung</td></tr>\n";
print "</table>\n";

//Mit ksort() �ber den Stadtnamen zu sortieren
$bevoelkerung = array('Berling, Berlin' => 3392425,
                      'Hamburg, Hamburg' => 1728806,
                      'M�nchen, Bayern' => 1234692,
                      'K�ln, NRW' => 968639,
                      'Frankfurt am Main, Hessen' => 643726,
                      'Dortmund, NRW' => 590831,
                      'Stuttgart, Baden-W�rttemberg' => 588477,
                      'Essen, NRW' => 585481,
                      'D�sseldorf, NRW' => 571886,
                      'Bremen, Bremen' => 542987);
$gesamt_bevoelkerung = 0;
ksort($bevoelkerung);
print "<table><tr><th>Stadt</th><th>Bev�kerung</th></tr>\n";
foreach ($bevoelkerung as $stadt => $menschen) {
    $gesamt_bevoelkerung += $menschen;
    print "<tr><td>$stadt</td><td>$menschen</td></tr>\n";
    
}
print "<tr><td>Gesamt</td><td>$gesamt_bevoelkerung</td></tr>\n";
print "</table>\n";
?>
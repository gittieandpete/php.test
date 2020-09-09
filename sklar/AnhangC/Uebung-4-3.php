<?php
// Die Namen der Stadt und des Bundeslands im Array trennen,
// damit die Gesamtsummen pro Bundesland berechnet werden k�nnen
$bevoelkerung = array('Berlin' => array('b_land' => 'Berlin',
                                        'bev' => 3392425),
                      'Hamburg' => array('b_land' => 'Hamburg',
                                         'bev' => 1728806),
                      'M�nchen' => array('b_land' => 'Bayern',
                                         'bev' => 1234692),
                      'K�ln' => array('b_land' => 'NRW',
                                      'bev' => 968639),
                      'Frankfurt am Main' => array('b_land' => 'Hessen',
                                                   'bev' => 643726),
                      'Dortmund' => array('b_land' => 'NRW',
                                          'bev' => 590831),
                      'Stuttgart' => array('b_land' => 'Baden-W�rttemberg',
                                           'bev' => 588477),
                      'Essen' => array('b_land' => 'NRW',
                                       'bev' => 585481),
                      'D�sseldorf' => array('b_land' => 'NRW',
                                            'bev' => 571886),
                      'Bremen' => array('b_land' => 'Bremen',
                                        'bev' => 542987));
// Das Array $b_land_gesamt verwenden, um die Gesamtsummen f�r
// die einzelnen Bundesl�nder nachzuhalten
$b_land_gesamt = array(  );
$gesamt_bevoelkerung = 0;
print "<table><tr><th>Stadt</th><th>Bev�lkerung</th></tr>\n";
foreach ($bevoelkerung as $stadt => $info) {
    // $info ist ein Array mit zwei Elementen: bev (Stadt-Bev�lkerung) 
    // und b_land (Name des Bundeslands)
    $gesamt_bevoelkerung += $info['bev'];
    // Das $info['b_land']-Element von $b_land_gesamt um 
    // $info['bev'] erh�hen, um die Gesamtbev�lkerung des 
    // Bundeslands $info['b_land'] nachzuhalten
    $b_land_gesamt[$info['b_land']] += $info['bev'];
    print "<tr><td>$stadt, {$info['b_land']}</td>
               <td>{$info['bev']}</td></tr>\n";
    
}
// Das Array $b_land_gesamt durchlaufen, um die Gesamtbev�lkerung 
// pro Bundesland auszugeben
foreach ($b_land_gesamt as $b_land => $bev) {
    print "<tr><td>$b_land</td><td>$bev</td>\n";
}
print "<tr><td>Gesamt</td><td>$gesamt_bevoelkerung</td></tr>\n";
print "</table>\n";
?>
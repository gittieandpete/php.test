<?php
$gewuerze = array('Japanisch' => array('scharf' => 'Wasabi',
                                       'salzig' => 'Soja-So�e'),
                  'Chinesisch'  => array('scharf' => 'Senf',
                                         'pfeffrig-salzig' => 'Szetschuan-Pfeffer'));

// $kultur ist der Schl�ssel und $kultur_gewuerze der Wert (ein Array)
foreach ($gewuerze as $kultur => $kultur_gewuerze) {

    // $gewuerz ist der Schl�ssel und $beispiel ist der Wert
    foreach ($kultur_gewuerze as $gewuerz => $beispiel) {
        print "Ein {$gewuerz}es {$kultur}es Gew�rz ist $beispiel.\n";
    }
}
?>
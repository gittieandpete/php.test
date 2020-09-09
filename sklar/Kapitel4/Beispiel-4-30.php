<?php
$gewuerze = array('Japanisch' => array('scharf' => 'Wasabi',
                                       'salzig' => 'Soja-Soße'),
                  'Chinesisch'  => array('scharf' => 'Senf',
                                         'pfeffrig-salzig' => 'Szetschuan-Pfeffer'));

// $kultur ist der Schlüssel und $kultur_gewuerze der Wert (ein Array)
foreach ($gewuerze as $kultur => $kultur_gewuerze) {

    // $gewuerz ist der Schlüssel und $beispiel ist der Wert
    foreach ($kultur_gewuerze as $gewuerz => $beispiel) {
        print "Ein {$gewuerz}es {$kultur}es Gewürz ist $beispiel.\n";
    }
}
?>
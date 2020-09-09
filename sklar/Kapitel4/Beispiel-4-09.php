<?php
$mahlzeit = array('Walnuss-Weckchen' => 1,
                 'Cashew-N�sse mit Champignons' => 4.95,
                 'Getrocknete Maulbeeren' => 3.00,
                 'Aubergine mit Chili-So�e' => 6.50);

foreach ($mahlzeit as $gericht => $preis) {
    // $preis = $preis * 2 funktioniert NICHT
    $mahlzeit[$gericht] = $mahlzeit[$gericht] * 2;
}

// Durchlaufe das Array erneut und gebe die ge�nderten Werte aus
foreach ($mahlzeit as $gericht => $preis) {
    printf("Der neue Preis von %s ist %.2f EUR.\n",$gericht,$preis);
}
?>
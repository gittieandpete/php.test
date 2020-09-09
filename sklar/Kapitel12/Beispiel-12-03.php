<?php
$preise = array(5.95, 3.00, 12.50);
$gesamtpreis = 0;
$steuersatz = 1.16; // 16% tax

foreach ($preise as $preis) {
    $gesamtpreis = $preis * $steuersatz;
}

printf('Gesamtpreis (mit Steuern): %.2f EUR', $gesamtpreis);
?>
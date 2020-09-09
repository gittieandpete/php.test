<?php
$preise = array(5.95, 3.00, 12.50);
$gesamtpreis = 0;
$steuersatz = 1.16; // 16% tax

foreach ($preise as $preis) {
    error_log("[Vor: $gesamtpreis]");
    $gesamtpreis = $preis * $steuersatz;
    error_log("[Nach: $gesamtpreis]");
}

printf('Gesamtpreis (mit Steuern): %.2f EUR', $gesamtpreis);
?>
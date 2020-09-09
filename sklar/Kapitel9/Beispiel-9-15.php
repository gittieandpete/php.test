<?php
require 'formularhelfer.php';

$stunden = array(  );
for ($stunde = 1; $stunde <= 24; $stunde++) { $stunden[$stunde] = $stunde; }

$minuten = array(  );
for ($minute = 0; $minute < 60; $minute += 5) {
    $formatierte_minute = sprintf('%02d', $minute);
    $minuten[$formatierte_minute] = $formatierte_minute;
}

input_select('stunde', $_POST, $stunden);
print ':';
input_select('minute', $_POST, $minuten);
?>

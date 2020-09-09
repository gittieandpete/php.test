<?php
require 'formularhelfer.php';

$monate = array(1 => 'Januar', 2 => 'Februar', 3 => 'März', 4 => 'April', 
                5 => 'Mai', 6 => 'Juni', 7 => 'Juli', 8 => 'August',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 
                12 => 'Dezember');

$tage = array(  );
for ($i = 1; $i <= 31; $i++) { $tage[$i] = $i; }

$jahre = array(  );
for ($jahr = date('Y') -1, $max_jahr = date('Y') + 5; $jahr < $max_jahr; $jahr++) {
    $jahre[$jahr] = $jahr;
}

input_select('tag',  $_POST, $tage);
print ' ';
input_select('monat',$_POST, $monate);
print ' ';
input_select('jahr', $_POST, $jahre);
?>
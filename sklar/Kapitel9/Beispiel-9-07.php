<?php
setlocale(LC_TIME,'ge');
$jetzt = time();
$spaeter = strtotime('Thursday',$jetzt);
$frueher = strtotime('last thursday',$jetzt);
print strftime("Jetzt: %c \n", $jetzt);
print strftime("Später: %c \n", $spaeter);
print strftime("Früher: %c \n", $frueher);
?>
<?php
// 13:30 (und 45 Sekunden) am 20. Oktober 1982
$nachmittag = mktime(13,30,45,10,20,1982);

print strftime('Um %H:%M:%S am %d.%m.%y ', $nachmittag);
print "waren $nachmittag Sekunden seit dem 1.1.1970 vergangen.";
?>
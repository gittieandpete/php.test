<?php
setlocale(LC_ALL, 'ge');
$zeitstempel = mktime(19,45,0,10,20,2004);
print strftime('Heute ist der %d. Tag des %B und der %j. Tag des Jahrs %Y. Es ist %H:%M Uhr (auch bekannt als %I:%M %p).', $zeitstempel);
?>
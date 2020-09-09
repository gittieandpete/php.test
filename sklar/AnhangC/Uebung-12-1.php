<?php

/* Die Fehlermeldung sieht folgendermaßen aus:
   Parse error: parse error, unexpected T_GLOBAL in uebung-12-1.php on line 6

   Die global-Deklaration muss auf einer eigenen Zeile stehen, 
   nicht in einer print-Anweisung. Trennen Sie beides, um 
   das Problem zu beheben:
*/
$name = 'Umberto';
function sag_hallo(  ) {
    global $name;
    print 'Hallo ';
    print $name;
}
sag_hallo(  );
?>
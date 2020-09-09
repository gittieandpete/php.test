<?php
$zeitstempel = mktime(19,45,0,10,20,2004);
print 'Heute ist der Tag '.date('d',$zeitstempel).'. des '.date('F',$zeitstempel).' und der '.(date('z',$zeitstempel)+1);
print '. Tag des Jahrs '.date('Y',$zeitstempel).'. Es ist '.date('H:i',$zeitstempel).' Uhr';
print ' (auch bekannt als '.date('h:i A',$zeitstempel).').';
?>
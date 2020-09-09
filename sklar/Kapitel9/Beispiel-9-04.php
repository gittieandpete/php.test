<?php
print 'strftime(  ) sagt: ';
print strftime('%H:%M:%S', time(  ) + 60*60);
print "\n";
print 'date(  ) sagt: ';
print date('H:i:s', time(  ) + 60*60);
?>
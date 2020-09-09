<?php
print 'strftime(  ) sagt: ';
print strftime('Heute ist der %d.%m.%y und es ist %H:%M:%S Uhr.');
print "\n";
print 'date(  ) sagt: ';
print 'Heute ist der ' . date('d.m.y') . ' und es ist ' . date('H:i:s') . ' Uhr.';
?>
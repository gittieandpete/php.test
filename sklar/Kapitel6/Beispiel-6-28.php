<?php
print '<input type="checkbox" name="lieferung" value="yes"';
if ($standardwert['lieferung'] == 'ja') { print ' checked="checked"'; }
print '> Lieferung?';

print '<input type="radio" name="groesse" value="klein"';
if ($standardwert['groesse'] == 'klein') { print ' checked="checked"'; }
print '> Klein ';
print '<input type="radio" name="groesse" value="mittel"';
if ($standardwert['groesse'] == 'medium') { print ' checked="checked"'; }
print '> Mittel';
print '<input type="radio" name="groesse" value="gross"';
if ($standardwert['groesse'] == 'large') { print ' checked="checked"'; }
print '> Groß';
?>
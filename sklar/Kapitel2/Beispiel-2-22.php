<?php
$seitentitel = 'Speisekarte';
$fleisch = 'Schweinefleisch';
$gemuese = 'Sprossen';
print <<<SPEISEKARTE
<html>
<head><title>$seitentitel</title></head>
<body>
<ul>
<li> Gegrilltes $fleisch
<li> Geschnetzeltes $fleisch
<li> GedŁnstetes $fleisch mit $gemuese
</ul>
</body>
</html>
SPEISEKARTE;
?>
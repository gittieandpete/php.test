<?php
$fh = fopen('leute.txt','rb');
for ($zeile = fgets($fh); ! feof($fh); $zeile = fgets($fh)) {
    $zeile = trim($zeile);
    $info = explode('|', $zeile);
    print '<li><a href="mailto:' . $info[0] . '">' . $info[1] ."</li>\n";
}
fclose($fh);
?>
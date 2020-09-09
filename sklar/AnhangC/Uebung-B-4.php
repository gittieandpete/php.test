<?php
$url = 'http://www.sklar.com/';
$seite = file_get_contents($url);
if (preg_match_all('@<a href="[^"]+">.+?</a>@', $seite, $treffer)) {
    foreach ($treffer[0] as $link) {
        print "$link <br/>\n";
    }
}
?>
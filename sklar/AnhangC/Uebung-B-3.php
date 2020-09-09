<?php
$zip = 98052;
$url = 'http://www.srh.noaa.gov/zipcity.php?inputstring=' . $zip;
$wetterseite = file_get_contents($url);
if (preg_match('@<br><br>(-?\d+)&deg;F<br>\((-?\d+)&deg;C\)</td>@',
$wetterseite,$treffer)) {
    // $treffer[1] ist die Fahrenheit-Temperatur
    // $treffer[2] ist die Celsius-Temperatur
    print "Die aktuelle Temperatur ist $treffer[2] Grad.";
} else {
    print "Kann aktuelle Temperatur nicht abrufen.";
}
?>
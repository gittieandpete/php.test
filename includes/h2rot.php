<?php

wrap($reihenfolge,$layout);

// Anzahl der erwarteten Bilder eintragen
layoutcheck(1);

if ($titel) print '<h2 class="meldung">' . $titel . "</h2>\n";

print '<a href="?bild=' . $biglink . '"><img class="rechts maxwidth ' . $property . '" src="' . $bild . '"  alt="' . $bildtitle . '"></a>' . "\n";
print '<div class="kasten">' . "\n";

if ($text)	print '<div class="description" >' . $text . '</div>' . "\n\n";

print "<p>\n";
if ($abmessung)	print "\t" . '' . $abmessung . "<br>\n";
if ($farbe)	print "\t" . '' . $farbe . "<br>\n";
if ($nummer)	print "\t" . '' . $nummer . "<br>\n";
if ($uvp)	print "\t" . $uvp . "<br>\n";
if ($preis)	print "\t" . $preis . "<br>\n";
if ($rabatt)	print "\t" . $rabatt . "<br>\n";
if ($baujahr)	print "\t" . '' . $baujahr . "<br>\n";
print "</p>\n\n";

if ($demolink) print '<p><a href="http://www.merz-klaviere.de/neu/demos.php?ytlink=' . $demolink[0] . '">' . $demolink[1] . "</a></p>\n\n";
if ($herstellerlink)	print '<p class="kasten"><a href="' . $herstellerlink . '">Spezifikation ' . $modell . "</a></p>\n\n";
$max--;

print "</div><!-- kasten -->\n";
if ($zeilen-$max>1) print '<div class="uplink"><a href="#outer">&uarr;</a></div>';
print "</div>\n\n<!-- wrap -->";

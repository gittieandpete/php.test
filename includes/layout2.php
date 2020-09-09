<?php
if ($max == $zeilen)
    {
    print "<div>\n\n";
} else	{
    print "<div class=\"wrap\">\n\n";
}

// debug
print "<strong>Debug: $layout, $kategorie, $instrument und Max = $max.</strong>";

if (!$titel) print "<a name=\"anker$reihenfolge\"></a>\n";

print <<<HTML

    <a href="$biglink"><img class="rechts" src="$bildlink" width="200" border="0" alt="$bildtitle"></a>

HTML;

print "<p>\n";
if ($titel)	print "\t<span id=\"anker$reihenfolge\">$titel</span><br>\n";
if ($abmessung)	print "\t$abmessung<br>\n";
if ($farbe)	print "\t$farbe<br>\n";
if ($nummer)	print "\t$nummer<br>\n";
if ($uvp)	print "\t$uvp<br>\n";
if ($preis)	print "\t$preis<br>\n";
if ($rabatt)	print "\t$rabatt<br>\n";
if ($baujahr)	print "\t$baujahr<br>\n";
print "</p>\n\n";

if ($text)	print "$text\n\n";
if ($herstellerlink)	print "<p class=\"kasten\"><a href=\"$herstellerlink\">Spezifikation $modell</a></p>";
$max--;
print "</div><!-- wrap -->\n\n";
<?php
if ($max == $zeilen)
    {
    print "<div>\n\n";
} else	{
    print "<div class=\"wrap\">\n\n";
}

// debug
print "<strong>Debug: $layout, $kategorie, $instrument und Max = $max.</strong>";

if (!$titel)	print "<a name=\"anker" . $reihenfolge . "\"></a>\n";

print <<<HTML

    <a href="$biglink"><img class="rechts" src="$bildlink" width="200" border="0" alt="$bildtitle"></a>

HTML;

if ($titel)	print "<h3 id=\"anker$reihenfolge\">$titel</h3>\n";

if ($text)	print "$text\n\n";

if ($herstellerlink)	print "<p class=\"kasten\"><a href=\"$herstellerlink\">Spezifikation $modell</a></p>";
if ($preis)	print "<p>$preis</p>\n\n";
$max--;
print "</div><!-- wrap -->\n\n";
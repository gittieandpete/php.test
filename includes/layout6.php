<?php
/*
// hier ohne horizontale Linien
if ($max == $zeilen)
    {
    print "<div>\n\n";
} else	{
    print "<div class=\"wrap\">\n\n";
}
*/
if (!$titel) print "<a name=\"anker$reihenfolge\"></a>\n";
if ($bildlink) print "<img class=\"rechts\" src=\"$bildlink\" border=\"0\" alt=\"$bildtitle\">";
if ($titel) print "<h2 id=\"anker$reihenfolge\">$titel</h2>\n";
if ($text) print "$text\n";
/*
$max--;
print "</div><!-- wrap -->\n\n";
*/
<?php
$channel = array('title' => "Was es heute zu essen gibt",
                 'link' => 'http://speisekarte.beispiel.com/',
                 'description' => 'Hier sehen Sie die Auswahl an Gerichten für den heutigen Abend.');

print "<channel>\n";
foreach ($channel as $element => $inhalt) {
    print " <$element>";
    print htmlentities($inhalt);
    print "</$element>\n";
}
print "</channel>";
?>
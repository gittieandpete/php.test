$channel =<<<_XML_
<channel>
 <title>Was es heute zu essen gibt</title>
 <link>http://speisekarte.beispiel.com/</link>
 <description>Hier sehen Sie die Auswahl an Gerichten für den heutigen Abend.</description>
</channel>
_XML_;

$xml = simplexml_load_string(utf8_encode($channel));

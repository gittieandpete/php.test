<?php
$speisekarte=<<<_XML_
<?xml version="1.0" encoding="iso-8859-1" ?>
<rss version="0.91">
 <channel>
  <title>Was es heute zu essen gibt</title>
  <link>http://speisekarte.beispiel.com/</link>
  <description>Hier sehen Sie die Auswahl an Gerichten für den heutigen Abend.</description>
  <item>
   <title>Gedünstete Seegurke</title>
   <link>http://speisekarte.beispiel.com/gerichte.php?gericht=gurke</link>
   <description>Sanfte Aromen des Meers, die Sie nähren und erfrischen.</description>
  </item>
  <item>
   <title>Gebackenes Gänseklein mit Salz</title>
   <link>http://speisekarte.beispiel.com/gerichte.php?gericht=gaense</link>
   <description>Reicher Gänseklein-Geschmack mit Salz und Gewürzen angereichert. </description>
  </item>
  <item>
   <title>Abalone mit Mark und Entenfüßen</title>
   <link>http://speisekarte.beispiel.com/gerichte.php?gericht=abalone</link>
   <description>Das unverwechselbare Geschmacksvergnügen der Abalone.</description>
  </item>
 </channel>
</rss>
_XML_;

$xml = simplexml_load_string($speisekarte);

print "Der " . utf8_decode($xml->channel->title) . "-Channel ist unter " . 
      $xml->channel->link . " verfügbar. ";
print "Die Beschreibung ist \"" . utf8_decode($xml->channel->description)."\"";
?>
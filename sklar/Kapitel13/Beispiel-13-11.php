// Einen neuen XSL Transformer erzeugen
$xslt = new XSLTProcessor(  );
// Das Stylesheet aus der Datei rss.xsl laden
$xslt->importStyleSheet(DomDocument::load('rss.xsl'));

// Das Stylesheet auf das XML anwenden
$html = $xslt->transformToDoc($rss);
// Den Inhalt des neuen Dokuments ausgeben
$html->formatOutput = true;
print $html->saveXML(  );

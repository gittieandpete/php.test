<?php
class RSS extends DomDocument {
    function __construct($titel, $link, $beschreibung) {
        // Dieses Dokument als XML 1.0-Dokument einrichten, mit einem 
        // <rss>-Wurzelelement mit dem Attribut version="0.91"
        parent::__construct('1.0', 'ISO-8859-1');
        $rss = $this->createElement('rss');
        $rss->setAttribute('version', '0.91');
        $this->appendChild($rss);
        
        // Ein <channel>-Element mit <title>-, <link>-
        // und <description>-Kindelementen einrichten
        $channel = $this->createElement('channel');
        $channel->appendChild($this->erzeugeTextknoten('title', $titel));
        $channel->appendChild($this->erzeugeTextknoten('link', $link));
        $channel->appendChild($this->erzeugeTextknoten('description',
                                                       $beschreibung));
        
        // Unterhalb von <rss> einen <channel> hinzufügen
        $rss->appendChild($channel);
        
        // Die Ausgabe mit Zeilenumbrüchen und Leerzeichen einrichten
        $this->formatOutput = true;
    }
    
    // Diese Funktion fügt <channel> ein <item> hinzu
    function addItem($titel, $link, $beschreibung) {
        // Ein <item>-Element mit <title>-, <link>-
        // und <description>-Kindelementen erzeugen
        $item = $this->createElement('item');
        $item->appendChild($this->erzeugeTextknoten('title', $titel));
        $item->appendChild($this->erzeugeTextknoten('link', $link));
        $item->appendChild($this->erzeugeTextknoten('description',
                                                    $beschreibung));
        
        // Dem <channel> das <item> hinzufügen
        $channel = $this->getElementsByTagName('channel')->item(0);
        $channel->appendChild($item);
    }
    
    // Eine Hilfsfunktion zum Erzeugen von Elementen, die nur aus
    // Text bestehen (keine Kindelemente enthalten)
    private function erzeugeTextknoten($name, $text) {
        $element = $this->createElement($name);
        $element->appendChild($this->createTextNode($text));
        return $element;
    }
}

// Ein neues RSS-Dokument mit den für den Channel angegebenen Titel, Link
//  und Beschreibung erzeugen
$rss = new RSS(utf8_encode("Was es heute zu essen gibt"), 
               'http://speisekarte.beispiel.com/', 
               utf8_encode('Hier sehen Sie die Auswahl an Gerichten für den heutigen Abend.'));
// Drei Elemente hinzufügen
$rss->addItem(utf8_encode('Gedünstete Seegurke'),
              'http://speisekarte.beispiel.com/gerichte.php?gericht=gurke',
              utf8_encode('Sanfte Aromen des Meers, die Sie nähren und erfrischen.'));
$rss->addItem(utf8_encode('Gebackenes Gänseklein mit Salz'),
              'http://speisekarte.beispiel.com/gerichte.php?gericht=gaense',
              utf8_encode('Reicher Gänseklein-Geschmack mit Salz und Gewürzen angereichert.'));
$rss->addItem(utf8_encode('Abalone mit Mark und Entenfüßen'),
              'http://speisekarte.beispiel.com/gerichte.php?gericht=abalone',
              utf8_encode("Das unverwechselbare Geschmacksvergnügen der Abalone."));
// Das XML ausgeben
print $rss->saveXML();
?>
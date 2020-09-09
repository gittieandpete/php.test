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
        
        // Unterhalb von <rss> einen <channel> hinzuf�gen
        $rss->appendChild($channel);
        
        // Die Ausgabe mit Zeilenumbr�chen und Leerzeichen einrichten
        $this->formatOutput = true;
    }
    
    // Diese Funktion f�gt <channel> ein <item> hinzu
    function addItem($titel, $link, $beschreibung) {
        // Ein <item>-Element mit <title>-, <link>-
        // und <description>-Kindelementen erzeugen
        $item = $this->createElement('item');
        $item->appendChild($this->erzeugeTextknoten('title', $titel));
        $item->appendChild($this->erzeugeTextknoten('link', $link));
        $item->appendChild($this->erzeugeTextknoten('description',
                                                    $beschreibung));
        
        // Dem <channel> das <item> hinzuf�gen
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

// Ein neues RSS-Dokument mit den f�r den Channel angegebenen Titel, Link
//  und Beschreibung erzeugen
$rss = new RSS(utf8_encode("Was es heute zu essen gibt"), 
               'http://speisekarte.beispiel.com/', 
               utf8_encode('Hier sehen Sie die Auswahl an Gerichten f�r den heutigen Abend.'));
// Drei Elemente hinzuf�gen
$rss->addItem(utf8_encode('Ged�nstete Seegurke'),
              'http://speisekarte.beispiel.com/gerichte.php?gericht=gurke',
              utf8_encode('Sanfte Aromen des Meers, die Sie n�hren und erfrischen.'));
$rss->addItem(utf8_encode('Gebackenes G�nseklein mit Salz'),
              'http://speisekarte.beispiel.com/gerichte.php?gericht=gaense',
              utf8_encode('Reicher G�nseklein-Geschmack mit Salz und Gew�rzen angereichert.'));
$rss->addItem(utf8_encode('Abalone mit Mark und Entenf��en'),
              'http://speisekarte.beispiel.com/gerichte.php?gericht=abalone',
              utf8_encode("Das unverwechselbare Geschmacksvergn�gen der Abalone."));
// Das XML ausgeben
print $rss->saveXML();
?>
<?php
// Die Hilfsfunktionen f�r Formularelemente laden
require 'formularhelfer.php';

if ($_POST['_abgeschickt_test']) {
    // Wenn validiere_formular(  ) Fehler liefert, �bergebe sie an zeige_formular(  )
    if ($formularfehler = validiere_formular(  )) {
        zeige_formular($formularfehler);
    } else {
        // Die �bermittelten Daten sind g�ltig, also verarbeite sie
        verarbeite_formular(  );
    }
} else {
    // Das Formular wurde nicht �bermittelt, also zeige es an
    zeige_formular(  );
}

function zeige_formular($fehler = '') {
    if ($fehler) {
        print 'Bitte beheben Sie die folgenden Fehler: <ul><li>';
        print implode('</li><li>',$fehler);
        print '</li></ul>';
    }

    // Der Anfang des Formulars
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    // Der Titel
    print 'Titel: ';
    input_text('title', $_POST);
    print '<br/>';
    // Der Link
    print 'Link: ';
    input_text('link', $_POST);
    print '<br/>';
    // Die Beschreibung
    print 'Beschreibung: ';
    input_text('description', $_POST);
    print '<br/>';
    // Der Absenden-Button
    input_submit('absenden','Dokument erzeugen');
    // Die verborgene Variable _abgeschickt_test und das Ende des Formulars
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}

function validiere_formular(  ) {
    $fehler = array(  );
    // Der Titel ist erforderlich
    if (! strlen(trim($_POST['title']))) {
        $fehler[  ] = 'Geben Sie einen Titel f�r das Item an.';
    }
    // Der Link ist erforderlich
    if (! strlen(trim($_POST['link']))) {
        $fehler[  ] = 'Geben Sie einen Link f�r das Item an.';
    // Es ist kompliziert, eine URL korrekt zu validieren, aber wir
    // k�nnen zumindest pr�fen, ob sie mit dem richtigen String
    // beginnt
    } elseif (! (substr($_POST['link'], 0, 7) == 'http://') ||
              (substr($_POST['link'], 0, 8) == 'https://')) {
        $fehler[  ] = 'Geben Sie eine g�ltige http- oder https-URL an.';
    }
    
    // Die Beschreibung ist erforderlich
    if (! strlen(trim($_POST['description']))) {
        $fehler[  ] = 'Geben Sie eine Beschreibung f�r das Item an.';
    }
    return $fehler;
}

function verarbeite_formular(  ) {
    // Den Content-Type-Header setzen
    header('Content-Type: text/xml');
    // Den Anfang des XMLs einschlie�lich der Channel-Informationen ausgeben
    print<<<_XML_
<?xml version="1.0" encoding="ISO-8859-1" ?>
<rss version="0.91">
 <channel>
  <title>Was es heute zu essen gibt</title>
  <link>http://speisekarte.beispiel.com/</link>
  <description>Hier sehen Sie, welches Gericht Sie f�r den heutigen Abend ausgew�hlt haben.</description>
   <item>
_XML_;
  
    // Die �bermittelten Formulardaten ausgeben
    print '  <title>' . utf8_decode(htmlentities($_POST['title'])) . "</title>\n";
    print '  <link>' . htmlentities($_POST['link']) . "</link>\n";
    print '  <description>' . utf8_decode(htmlentities($_POST['description'])) . 
"</description>\n";
   
    // Das Ende des XMLs ausgeben
    print<<<_XML_
  </item>
 </channel>
</rss>
_XML_;
}
?>
<?php
require 'formularhelfer.php';
if ($_POST['_abgeschickt_test']) {
    if ($formularfehler = validiere_formular(  )) {
        zeige_formular($formularfehler);
    } else {
        verarbeite_formular(  );
    }
} else {
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
    print '<table>';
    // Der Suchbegriff
    print '<tr><td>Suchbegriff:</td><td>';
    input_text('begriff', $_POST);
    print '</td></tr>';
    
    // Formularende
    print '<tr><td colspan="2"><input type="absenden" value="Nachrichten suchen">';
    print '</td></tr>';
    print '</table>';
    print '<input type="hidden" name="_abgeschickt_test" value="1"/>';
    print '</form>';
}      
function validiere_formular(  ) {
    $fehler = array(  );
    if (! strlen(trim($_POST['begriff']))) {
        $fehler[  ] = 'Geben Sie einen Suchbegriff ein.';
    }
    return $fehler;
}
function verarbeite_formular(  ) {
    
    // Die RSS-Nachrichten abrufen
    $feed = simplexml_load_file('http://rss.news.yahoo.com/rss/topstories');
    if ($feed) {
        print "<ul>\n";
        foreach ($feed->channel->item as $item) {
            if (stristr(utf8_decode($item->title), $_POST['begriff'])) {
                print '<li><a href="' . $item->link .'">' ;
                print utf8_decode(htmlentities($item->title));
                print "</a></li>\n";
            }
        }
        print '</ul>';
    } else {
        print "Konnte Nachrichten nicht abrufen.";
    }
}
?>
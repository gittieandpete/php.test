// Diese Werte sind Punkt-Angaben (1/72 eines Zolls)
$schriftgroesse = 72;     // 1 Zoll große Buchstaben
$seiten_hoehe = 612; // 8.5 Zoll große Seiten
$seiten_breite = 792;  // 11 Zoll breite Seiten

// Eine Standardmeldung verwenden, wenn keine angegeben wurde
if (strlen(trim($_GET['meldung']))) {
    $meldung = trim($_GET['meldung']);
} else {
    $meldung = 'Ein PDF generieren!';
}

// Ein neues PDF-Dokument im Speicher generieren
$pdf = pdf_new(  );
pdf_open_file($pdf, '');

// Dem Dokument eine 11"x8.5"-Seite hinzufügen
pdf_begin_page($pdf, $seiten_breite, $seiten_hoehe);

// Die Schrift Helvetica mit 72 Punkten auswählen
$schrift = pdf_findfont($pdf, "Helvetica", "winansi", 0);
pdf_setfont($pdf, $schrift, $schriftgroesse);

// Die Meldung im Zentrum der Seite anzeigen
pdf_show_boxed($pdf, $meldung, 0, ($seiten_hoehe-$schriftgroesse)/2,
               $page_width, $schriftgroesse, 'center');

// Seite und Dokument beenden
pdf_end_page($pdf);
pdf_close($pdf);

// Den Inhalt des Dokuments abrufen und es aus dem Speicher löschen
$pdf_dok = pdf_get_buffer($pdf);
pdf_delete($pdf);

// Die erforderlichen Header und den Dokumenteninhalt senden
header('Content-Type: application/pdf');
header('Content-Length: ' . strlen($pdf_dok));
print $pdf_dok;

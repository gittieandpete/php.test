<?php
function csv_zeile_machen($werte) {
    // Wenn ein Wert Kommas, Anf�hrungszeichen, Leerzeichen, Tabulatoren (\t)
    // Zeilenumbruch (\n) oder Zeilenvorschub (\r) enth�lt, umgebe sie
    // mit Anf�hrungszeichen und ersetzte alle Anf�hrungszeichen
    // durch zwei Anf�hrungszeichen
    foreach($werte as $i => $wert) {
        if ((strpos($wert, ',')  !== false) ||
            (strpos($wert, '"')  !== false) ||
            (strpos($wert, ' ')  !== false) ||
            (strpos($wert, "\t") !== false) ||
            (strpos($wert, "\n") !== false) ||
            (strpos($wert, "\r") !== false)) {
            $werte[$i] = '"' . str_replace('"', '""', $wert) . '"';
        }
    }
    // Verbinde alle Wert, setzte dabei Kommas zwischen sie und h�nge am 
    // Ende einen Zeilenumbruch an
    return implode(',', $werte) . "\n";
}require 'DB.php';
// Mit der Datenbank verbinden
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');

// Dem Webclient sagen, dass eine CVS-Datei namens "gerichte.csv" verschickt wird
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="gerichte.csv"');

// Die Informationen aus der Datenbank-Tabelle abrufen und ausgeben
$gerichte = $db->query('SELECT gerichtname, preis, ist_scharf FROM gerichte');
while ($zeile = $gerichte->fetchRow(  )) {
    print csv_zeile_machen($zeile);
}
?>
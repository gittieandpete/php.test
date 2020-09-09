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
}
require 'DB.php';
// Mit der Datenbank verbinden
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
// Die CVS-Datei zum Schreiben �ffnen
$fh = fopen('gerichte.csv','wb');

$gerichte = $db->query('SELECT gerichtname, preis, ist_scharf FROM gerichte');
while ($zeile = $gerichte->fetchRow(  )) {
    // Wandle das Array von fetchRow(  ) in einen CSV-formatierten String um
    $zeile = csv_zeile_machen($zeile);
    // Schreibe den String in die Datei. Am Ende muss kein Zeilenumbruch 
    // angehangen werden, weil csv_zeile_machen(  ) das bereits tut
    fwrite($fh, $zeile);
}
fclose($fh);
?>
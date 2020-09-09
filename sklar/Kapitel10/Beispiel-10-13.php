<?php
function csv_zeile_machen($werte) {
    // Wenn ein Wert Kommas, Anführungszeichen, Leerzeichen, Tabulatoren (\t)
    // Zeilenumbruch (\n) oder Zeilenvorschub (\r) enthält, umgebe sie
    // mit Anführungszeichen und ersetzte alle Anführungszeichen
    // durch zwei Anführungszeichen
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
    // Verbinde alle Wert, setzte dabei Kommas zwischen sie und hänge am 
    // Ende einen Zeilenumbruch an
    return implode(',', $werte) . "\n";
}
require 'DB.php';
// Mit der Datenbank verbinden
$db = DB::connect('mysql://jaeger:w)mp3s@db.beispiel.com/restaurant');
// Die CVS-Datei zum Schreiben öffnen
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
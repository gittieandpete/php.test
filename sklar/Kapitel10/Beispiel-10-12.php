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
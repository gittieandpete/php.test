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
// "df" ausführen und seine Ausgabe in einzelne Zeilen aufteilen
$df_ausgabe = shell_exec('/bin/df -h');
$df_zeile = explode("\n", $df_ausgabe);

// Alle Zeilen durchlaufen. Die erste Zeile überspringen, die nur
// eine Kopfzeile ist
for ($i = 1, $zeilen = count($df_zeilen); $i < $zeilen; $i++) {
    if (trim($df_zeilen[$i])) {
        // Die Zeile in Felder aufteilen
        $felder = preg_split('/\s+/', $df_zeilen[$i]);
        // Informationen zu jedem Dateisystem ausgeben
        print "Dateisystem $felder[5] ist $felder[4] voll.\n";
    }
}

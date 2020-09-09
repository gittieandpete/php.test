// Dem Webclient mitteilen, das er eine CVS Datei zu erwarten hat
header('Content-Type: text/csv');
// Dem Webclient sagen, dass er die CVS-Datei in einee separaten Anwendung anzeigen soll
header('Content-Disposition: attachment; filename="gerichte.csv"');

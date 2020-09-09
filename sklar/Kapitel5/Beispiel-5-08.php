// Ein optionales Argument: Es muss an letzter Stelle stehen
function seiten_kopf5($farbe, $titel, $ueberschrift = 'Willkommen') {
    print '<html><head><title>Willkommen auf ' . $titel . '</title></head>';
    print '<body bgcolor="#' . $farbe . '">';
    print "<h1>$ueberschrift</h1>";
}
// Zul�ssige M�glichkeiten, diese Funktion aufzurufen:
seiten_kopf5('66cc99','meiner tolle Seite'); // Standardwert f�r $header verwenden
seiten_kopf5('66cc99','meiner tolle Seite','Diese Seite ist klasse!'); // Keine Standardwerte

// Zwei optionale Argumente: Es m�ssen die letzten beiden Argumente sein
function seiten_kopf6($farbe, $titel = 'meiner Seite', $ueberschrift = 'Willkommen') {
    print '<html><head><title>Willkommen auf ' . $titel . '</title></head>';
    print '<body bgcolor="#' . $farbe . '">';
    print "<h1>$ueberschrift</h1>";
}
// Zul�ssige M�glichkeiten, diese Funktion aufzurufen:
seiten_kopf6('66cc99'); // Standardwert f�r $titel und $ueberschrift verwenden
seiten_kopf6('66cc99','meiner tollen Seite'); // Standard f�r $ueberschrift verwenden
seiten_kopf6('66cc99','meiner tollen Seite','Diese Seite ist klasse!'); // Keine Standardwerte


// Alle Argumente optional
function seiten_kopf7($farbe = '336699', $titel = 'meiner Seite', $header = 'Willkommen') {
    print '<html><head><title>Willkommen auf ' . $titel . '</title></head>';
    print '<body bgcolor="#' . $farbe . '">';
    print "<h1>$ueberschrift</h1>";
}
// Zul�ssige M�glichkeiten, diese Funktion aufzurufen:
seiten_kopf7(); // Alle Standardwerte verwenden
seiten_kopf7('66cc99'); // Standardwerte f�r $titel und $ueberschrift verwenden
seiten_kopf7('66cc99','meiner tollen Seite'); // Standardwert f�r $ueberschrift verwenden
seiten_kopf7('66cc99','meiner tollen Seite','Diese Seite ist klasse!'); // Keine Standardwerte

// Die neue Funktion validiere_formular(  ), die die zus�tzliche
// Regel implementiert

function validiere_formular(  ) {
    $fehler = array(  );

    // Der Dateiname ist erforderlich
    if (! strlen(trim($_POST['dateiname']))) {
        $fehler[  ] = 'Geben Sie einen Dateinamen ein.';
    } else {
        // Aus dem Dokument-Wurzelverzeichnis des Webservers, einem
        // Schr�gstrich und dem �bermittelten Wert den vollst�ndigen
        // Dateinamen aufbauen
        $dateiname = $_SERVER['DOCUMENT_ROOT'] . '/' . $_POST['dateiname'];

        // realpath verwenden, um eventuelle ..-Sequenzen aufzul�sen
        $dateiname = realpath($dateiname);

        // Pr�fen, ob der $dateiname mit dem Dokument-Wurzel-
        // verzeichnis beginnt
        $dokwurzel_laenge = strlen($_SERVER['DOCUMENT_ROOT']);
        // Hier ist die Anwendung von realpath() erforderlich, damit der
        // Vergleich auch unter Windows funktioniert
        $dokwurzel = realpath($_SERVER['DOCUMENT_ROOT']);
        if (substr($dateiname, 0, $dokwurzel_laenge) != $dokwurzel) {
            $fehler[  ] = 'Die Datei muss sich unterhalb des Dokument-Wurzelverzeichnisses befinden.';
        } elseif (strcasecmp(substr($dateiname, -5), '.php') != 0) {
            $fehler[  ] = 'Der Dateiname muss mit .php enden';
        }
    }

    return $fehler;
}
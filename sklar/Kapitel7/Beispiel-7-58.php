function verarbeite_formular(  ) {
    // Greife auf die globale Variable $db innerhalb dieser Funktion zu
    global $db;
    
    // Die Abfrage aufbauen 
    $sql = 'SELECT gerichtname, preis, ist_scharf FROM gerichte WHERE ';
    
    // Der Abfrage den minimalen Preis hinzufügen
    $sql .= "preis >= '" .
            mysqli_real_escape_string($db, $_POST['min_preis']) . "' ";

    // Der Abfrage den maximalen Preis hinzufügen
    $sql .= " AND preis <= '" .
            mysqli_real_escape_string($db, $_POST['max_preis']) . "' ";

    // Wenn ein Gerichtname übermittelt wurde, füge ihn der WHERE-Klausel hinzu.
    // Wir verwenden mysqli_real_escape_string(  ) und strtr(  ), um vom
    // Benutzer eingegebene Jokerzeichen abzuschalten
    if (strlen(trim($_POST['gerichtname']))) {
        $gericht = mysqli_real_escape_string($db, $_POST['gerichtname']);
        $gericht = strtr($gericht, array('_' => '\_', '%' => '\%'));
        // mysqli_real_escape_string(  ) fügt um den Wert keine einfachen
        // Anführungszeichen hinzu, Sie müssen $gericht also in der Abfrage 
        // damit umgeben:
        $sql .= " AND gerichtname LIKE '$gericht'";
    }

    // Wenn ist_scharf gleich "Ja" oder "Nein" ist, füge das entsprechende 
    // SQL hinzu (wenn es "Beides" ist, müssen wir der WHERE-Klausel 
    // ist_scharf nicht hinzufügen)
    $scharf_auswahl = $GLOBALS['scharf_auswahl'][ $_POST['ist_scharf'] ];
    if ($spicy_choice =  = 'Ja') {
        $sql .= ' AND ist_scharf = 1';
    } elseif ($spicy_choice =  = 'Nein') {
        $sql .= ' AND ist_scharf = 0';
    }

    // Die Abfrage an das Datenbank-Programm schicken und alle Zeilen abrufen
    $q = mysqli_query($db, $sql);

    if (mysqli_num_rows($q) =  = 0) {
        print 'Keine passenden Gerichte gefundenen.';
    } else {
        print '<table>';
        print '<tr><th>Gerichtname</th><th>Preis</th><th>Scharf?</th></tr>';
        while ($gericht = mysqli_fetch_object($q)) {
            if ($gericht->ist_scharf =  = 1) {
                $scharf = 'Ja';
            } else {
                $scharf = 'Nein';
            }
            printf('<tr><td>%s</td><td>$%.02f</td><td>%s</td></tr>',
                   htmlentities($gericht->gerichtname), $dish->preis, $scharf);
        }
    }
}

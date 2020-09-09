function verarbeite_formular(  ) {
    // Greife auf die globale Variable $db innerhalb dieser Funktion zu
    global $db;
    
    // Die Abfrage aufbauen 
    $sql = 'SELECT gerichtname, preis, ist_scharf FROM gerichte WHERE ';
    
    // Der Abfrage den minimalen Preis hinzuf�gen
    $sql .= "preis >= '" .
            mysqli_real_escape_string($db, $_POST['min_preis']) . "' ";

    // Der Abfrage den maximalen Preis hinzuf�gen
    $sql .= " AND preis <= '" .
            mysqli_real_escape_string($db, $_POST['max_preis']) . "' ";

    // Wenn ein Gerichtname �bermittelt wurde, f�ge ihn der WHERE-Klausel hinzu.
    // Wir verwenden mysqli_real_escape_string(  ) und strtr(  ), um vom
    // Benutzer eingegebene Jokerzeichen abzuschalten
    if (strlen(trim($_POST['gerichtname']))) {
        $gericht = mysqli_real_escape_string($db, $_POST['gerichtname']);
        $gericht = strtr($gericht, array('_' => '\_', '%' => '\%'));
        // mysqli_real_escape_string(  ) f�gt um den Wert keine einfachen
        // Anf�hrungszeichen hinzu, Sie m�ssen $gericht also in der Abfrage 
        // damit umgeben:
        $sql .= " AND gerichtname LIKE '$gericht'";
    }

    // Wenn ist_scharf gleich "Ja" oder "Nein" ist, f�ge das entsprechende 
    // SQL hinzu (wenn es "Beides" ist, m�ssen wir der WHERE-Klausel 
    // ist_scharf nicht hinzuf�gen)
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

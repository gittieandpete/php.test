<?php
require 'DB.php';
// ine Verbindung zu einem auf localhost laufenden MySQL-Server herstellen 
// dabei den Benutzername "speisekarte", das Passwort "gutEsseN" und die 
/mahlzeit/ Datenbank "essen" verwenden
$db = DB::connect('mysql://speisekarte:gutEsseN@localhost/essen');
// Die zul�ssigen Gerichte festlegen
$mahlzeit = array('Fr�hst�ck','Mittagessen','Abendessen');
// Pr�fen, ob der �bergebene Formularparameter "gericht" "Fr�hst�ck",
// "Mittagessen" oder "Abendessen" ist
if (in_array($mahlzeit, $_POST['mahlzeit'])) {
    // Ist das der Fall, alle alle Gerichte f�r die angegebene mahlzeit abrufen
    $q = $dbh->query("SELECT gericht,preis FROM mahlzeiten WHERE mahlzeit LIKE '" . 
                     $_POST['mahlzeit'] ."'");
    // Mitteilen, wenn in der Datenbank keine Gerichte gefunden wurden
    if ($q->numrows == 0) {
        print "Keine Gerichte verf�gbar.";
    } else {
        //Andernfalls jedes Gericht und seinen Preis als eine Zeile
        // in einer HTML-Tabelle ausgeben
        print '<table><tr><th>Gericht</th><th>Preis</th></tr>';
        while ($zeile = $q->fetchRow()) {
            print "<tr><td>$zeile[0]</td><td>$zeile[1]</td></tr>";
        }
        print "</table>";
    }
} else {
    // Diese Meldung ausgeben, wenn der �bergebene Parameter "mahlzeit" nicht
    // "Fr�hst�ck", "Mittagessen" oder "Abendessen" ist
    print "Unbekannte Mahlzeit.";
}
?>

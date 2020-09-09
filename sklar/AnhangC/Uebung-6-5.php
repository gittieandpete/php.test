function array_ausgeben($array, $praefix) {
    // Das Array durchlaufen
    foreach ($array as $schluessel => $wert) {
        // Wenn der Wert dieses Elements ein Array ist, dann rufe
        // array_ausgeben(  ) wieder auf, um das Unterarray zu durchlaufen,
        // und hänge dabei den Schlüsselnamen an das Präfix an
        if (is_array($wert)) {
            print_array($wert, $praefix . "['" . $schluessel . "']");
        } else {
            // Wenn der Wert kein Array ist, dann gebe ihn 
            // einschließlich eines eventuellen Präfixes aus
            print $praefix;
            print "['" . htmlentities($schluessel) . "'] = ";
            print htmlentities($wert) . '<br/>';
        }
    }
}
function verarbeite_formular(  ) {
    print_array($_POST, '$_POST');
}
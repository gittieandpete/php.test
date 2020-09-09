function array_ausgeben($array, $praefix) {
    // Das Array durchlaufen
    foreach ($array as $schluessel => $wert) {
        // Wenn der Wert dieses Elements ein Array ist, dann rufe
        // array_ausgeben(  ) wieder auf, um das Unterarray zu durchlaufen,
        // und h�nge dabei den Schl�sselnamen an das Pr�fix an
        if (is_array($wert)) {
            print_array($wert, $praefix . "['" . $schluessel . "']");
        } else {
            // Wenn der Wert kein Array ist, dann gebe ihn 
            // einschlie�lich eines eventuellen Pr�fixes aus
            print $praefix;
            print "['" . htmlentities($schluessel) . "'] = ";
            print htmlentities($wert) . '<br/>';
        }
    }
}
function verarbeite_formular(  ) {
    print_array($_POST, '$_POST');
}
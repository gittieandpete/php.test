// Die Ausgabe einfangen, statt sie auszugeben
ob_start(  );
// var_dump(  ) wie gewöhnlich aufrufen
var_dump($_POST);
// In $ausgabe alle Ausgaben speichern, die seit dem Aufruf von ob_start(  ) 
// erzeugt wurden
$ausgabe = ob_get_contents(  );
// Zur normalen Anzeige von Ausgaben zurückkehren
ob_end_clean(  );
// $ausgabe ans Fehlerprotokoll senden
error_log($ausgabe);

function datenbank_fehler($fehlerobjekt) {
    print "Es tut uns leid, aber es gibt ein vor�bergehendes Problem mit der Datenbank.";
    $ausfuehrlicher_fehler = $fehlerobjekt->getDebugInfo(  );
    error_log($ausfuehrlicher_fehler);
}

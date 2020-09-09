function datenbank_fehler($fehlerobjekt) {
    print "Es tut uns leid, aber es gibt ein vorübergehendes Problem mit der Datenbank.";
    $ausfuehrlicher_fehler = $fehlerobjekt->getDebugInfo(  );
    error_log($ausfuehrlicher_fehler);
}

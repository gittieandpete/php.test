// Den Unix-Zeitstempel von vor 6 Monaten ermitteln
$bereichsanfang = strtotime('6 months ago');
// Den Unix-Zeitstempel für diesen Moment ermitteln
$bereichsende   = time(  );

// Das 4-stellige Jahr ist in $_POST['jahr']
// Der 2-stellige Monat ist in $_POST['monat']
// Der 2-stellige Tag ist in $_POST['tag']
$uebermitteltes_datum = strtotime($_POST['jahr'] . '-' . 
                                  $_POST['monat'] . '-' . 
                                  $_POST['tag']);

if (($bereichsanfang > $uebermitteltes_datum) || ($bereichsende < $uebermitteltes_datum)) {
    $fehler[  ] = 'Bitte wählen Sie ein Datum, das weniger als sechs Monate zurückliegt.';
}

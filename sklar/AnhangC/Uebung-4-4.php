// Ein assoziatives Array, dessen Schlüssel die Namen der Studenten 
// und dessen Werte assoziative Arrays mit Note und ID sind.
$studenten = array('David Sklar' => array('note' => '1+',
                                          'id' => 271231),
                   'Buwei Yang Chao' => array('note' => '1', 
                                              'id' => 818211));

// Ein assoziatives Array, dessen Schlüssel der Name des Artikels 
// und dessen Wert der Lagerbestand ist.
$lager = array('Wok' => 5, 'Schnellkochtopf' => 3, 
                'Kochmesser' => 2, 'Küchenmesser' => 6);

// Ein assoziatives Array, dessen Schlüssel der Tag und dessen 
// Wert ein assoziatives Array ist, das die Malzeit beschreibt. 
// Dieses assoziative Array enthält ein Schlüssel/Wert-Paar für 
// den Preis und eins für jeden Bestandteil der Malzeit 
// (Vorspeise, Beilage, Getränke).
$abendessen = array('Montag' => 
                    array('Preis' => 1.50,
                           'Vorspeise' => 'Rindfleisch Shiu-Mai',
                           'Beilage' => 'Frittierter Salzkuchen',
                           'Getränk' => 'Schwarzer Tee'),
                    'Dienstag' => 
                    array('Preis' => 1.50,
                          'Vorspeise' => 'Gedämpfter Fisch',
                          'Beilage' => 'Karottenkuchen',
                          'Getränk' => 'Schwarzer Tee'),
                    'Mittwoch' => 
                    array('Preis' => 2.00,
                          'Vorspeise' => 'Gedünstete Seegurke',
                          'Beilage' => 'Karottenkuchen',
                          'Getränk' => 'Grüner Tee'),
                    'Donnerstag' => 
                    array('Preis' => 1.35,
                          'Vorspeise' => 'Pfannengerührte Zwei Winter',
                          'Beilage' => 'Eierkuchen',
                          'Getränk' => 'Schwarzer Tee'),
                    'Freitag' => 
                    array('Preis' => 2.15,
                          'Vorspeise' => 'Geschmortes Schwein mit Taro',
                          'Beilage' => 'Entenfüße',
                          'Getränk' => 'Jasmin-Tee'));

// Ein numerisches Array, dessen Werte die Namen der 
// Familienmitglieder sind.
$familie = array('Bart','Lisa','Homer','Marge','Maggie');

// Ein assoziatives Array, dessen Schlüssel die Namen der 
// Familienmitglieder sind und dessen Werte assoziative 
// Arrays mit Alter und Verwandtschaftsbeziehung sind.
$familie = array('Bart' => array('Beziehung' => 'Bruder',
                                 'Alter' => 10),
                 'Lisa' => array('Beziehung' => 'Schwester',
                                 'Alter' => 7),
                 'Homer' => array('Beziehung' => 'Vater',
                                  'Alter' => 36),
                 'Marge' => array('Beziehung' => 'Mutter',
                                  'Alter' => 34),
                 'Maggie' => array('Beziehung' => 'Ich',
                                   'Alter' => 1));
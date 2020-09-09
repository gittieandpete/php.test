// Ein assoziatives Array, dessen Schl�ssel die Namen der Studenten 
// und dessen Werte assoziative Arrays mit Note und ID sind.
$studenten = array('David Sklar' => array('note' => '1+',
                                          'id' => 271231),
                   'Buwei Yang Chao' => array('note' => '1', 
                                              'id' => 818211));

// Ein assoziatives Array, dessen Schl�ssel der Name des Artikels 
// und dessen Wert der Lagerbestand ist.
$lager = array('Wok' => 5, 'Schnellkochtopf' => 3, 
                'Kochmesser' => 2, 'K�chenmesser' => 6);

// Ein assoziatives Array, dessen Schl�ssel der Tag und dessen 
// Wert ein assoziatives Array ist, das die Malzeit beschreibt. 
// Dieses assoziative Array enth�lt ein Schl�ssel/Wert-Paar f�r 
// den Preis und eins f�r jeden Bestandteil der Malzeit 
// (Vorspeise, Beilage, Getr�nke).
$abendessen = array('Montag' => 
                    array('Preis' => 1.50,
                           'Vorspeise' => 'Rindfleisch Shiu-Mai',
                           'Beilage' => 'Frittierter Salzkuchen',
                           'Getr�nk' => 'Schwarzer Tee'),
                    'Dienstag' => 
                    array('Preis' => 1.50,
                          'Vorspeise' => 'Ged�mpfter Fisch',
                          'Beilage' => 'Karottenkuchen',
                          'Getr�nk' => 'Schwarzer Tee'),
                    'Mittwoch' => 
                    array('Preis' => 2.00,
                          'Vorspeise' => 'Ged�nstete Seegurke',
                          'Beilage' => 'Karottenkuchen',
                          'Getr�nk' => 'Gr�ner Tee'),
                    'Donnerstag' => 
                    array('Preis' => 1.35,
                          'Vorspeise' => 'Pfannenger�hrte Zwei Winter',
                          'Beilage' => 'Eierkuchen',
                          'Getr�nk' => 'Schwarzer Tee'),
                    'Freitag' => 
                    array('Preis' => 2.15,
                          'Vorspeise' => 'Geschmortes Schwein mit Taro',
                          'Beilage' => 'Entenf��e',
                          'Getr�nk' => 'Jasmin-Tee'));

// Ein numerisches Array, dessen Werte die Namen der 
// Familienmitglieder sind.
$familie = array('Bart','Lisa','Homer','Marge','Maggie');

// Ein assoziatives Array, dessen Schl�ssel die Namen der 
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
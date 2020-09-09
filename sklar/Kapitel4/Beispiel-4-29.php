$preise['Abendessen']['Süßer Mais und Spargel'] = 12.50;
$preise['Mittagessen']['Cashew-Nüsse und Champignons'] = 4.95;
$preise['Abendessen']['Gedünstete Bambuspilze'] = 8.95;

$preise['Abendessen']['gesamt'] = $preise['Abendessen']['Süßer Mais und Spargel'] +
                                  $preise['Abendessen']['Gedünstete Bambuspilze'];

$spezialitaeten[0][0] = 'Haselnuss-Weckchen';
$spezialitaeten[0][1] = 'Walnuss-Weckchen';
$spezialitaeten[0][2] = 'Erdnuss-Weckchen';
$spezialitaeten[1][0] = 'Haselnuss-Salat';
$spezialitaeten[1][1] = 'Walnuss-Salat';
// Wird der Index weggelassen, wird das Element ans Ende des Arrays angehangen
// Das erzeugt $spezialitaeten[1][2]
$spezialitaeten[1][] = 'Erdnuss-Salat';

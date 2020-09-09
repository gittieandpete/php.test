if ($_POST['_abgeschickt_test']) {
    $standardwerte = $_POST;
} else {
    $standardwert = array('lieferung'    => 'ja',
                          'groesse'      => 'mittel',
                          'hauptgericht' => array('taro','kutteln'),
                          'suesswaren'   => 'toertchen');
}

if ($_POST['alter'] != strval(intval($_POST['alter']))) {
    $fehler[  ] = "Ihr Alter muss eine Zahl sein.";
} elseif (($_POST['alter'] < 18) || ($_POST['alter'] > 65)) {
    $fehler[  ] = "Sie m�ssen mindestens 18 und d�rfen h�chstens 65 Jahre alt sein.";
}

if ($_POST['alter'] != strval(intval($_POST['alter']))) {
    $fehler[  ] = "Ihr Alter muss eine Zahl sein.";
} elseif (($_POST['alter'] < 18) || ($_POST['alter'] > 65)) {
    $fehler[  ] = "Sie müssen mindestens 18 und dürfen höchstens 65 Jahre alt sein.";
}

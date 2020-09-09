$_POST['name'] = trim($_POST['name']);

if (strlen($_POST['name']) =  = 0) {
    $fehler[  ] = "Ihr Name ist erforderlich.";
}

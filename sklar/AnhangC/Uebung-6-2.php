function verarbeite_formular(  ) {
    print "<ul>";
    foreach ($_POST as $element => $wert) {
        print "<li> \$_POST[$element] = $wert</li>";
    }
    print "</ul>";
}
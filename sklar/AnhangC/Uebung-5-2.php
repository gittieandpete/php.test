function html_img2($file, $alt = '', $height = 0, $width = 0) {

    print '<img src="' . $GLOBALS['bildpfad'] . $datei . '"';
    if (strlen($alt)) {
        print ' alt="' . $alt . '"';
    }
    if ($height) {
        print ' height="' . $height . '"';
    }
    if ($width) {
        print ' width="' . $width . '"';
    }
    print '>';
}
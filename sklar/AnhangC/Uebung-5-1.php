function html_img($url, $alt = '', $height = 0, $width = 0) {
    print '<img src="' . $url . '"';
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

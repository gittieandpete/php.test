$browser = get_browser(  );

if ($browser->platform == 'WinXP') {
    print 'Sie verwenden Windows XP.';
} elseif ($browser->platform == 'MacOSX') {
    print 'Sie verwenden Mac OS X.';
} else {
    print 'Sie verwenden ein anderes Betriebssystem.';
}

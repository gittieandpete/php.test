<?php
$gutes_html  = "I <b>liebe</b> Garnelenb�llchen.";
$schlechtes_html = "Ich <b>liebe</i> Garnelenb�llchen.";

if (preg_match('@<([bi])>.*?</\1>@',$gutes_html)) {
    print "Ihr Gl�ck! (Gutes HTML, R�ckw�rtsreferenzen)\n";
}
if (preg_match('@<([bi])>.*?</\1>@',$schlechtes_html)) {
    print "Ihr Gl�ck! (Schlechtes HTML, R�ckw�rtsreferenzen)\n";
}
if (preg_match('@<[bi]>.*?</[bi]>@',$gutes_html)) {
    print "Ihr Gl�ck! (Gutes HTML, keine R�ckw�rtsreferenzen)\n";
}
if (preg_match('@<[bi]>.*?</[bi]>@',$schlechtes_html)) {
    print "Ihr Gl�ck! (Schlechtes HTML, keine R�ckw�rtsreferenzen)\n";
}
?>
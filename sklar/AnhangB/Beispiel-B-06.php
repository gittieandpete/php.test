<?php
$gutes_html  = "I <b>liebe</b> Garnelenbällchen.";
$schlechtes_html = "Ich <b>liebe</i> Garnelenbällchen.";

if (preg_match('@<([bi])>.*?</\1>@',$gutes_html)) {
    print "Ihr Glück! (Gutes HTML, Rückwärtsreferenzen)\n";
}
if (preg_match('@<([bi])>.*?</\1>@',$schlechtes_html)) {
    print "Ihr Glück! (Schlechtes HTML, Rückwärtsreferenzen)\n";
}
if (preg_match('@<[bi]>.*?</[bi]>@',$gutes_html)) {
    print "Ihr Glück! (Gutes HTML, keine Rückwärtsreferenzen)\n";
}
if (preg_match('@<[bi]>.*?</[bi]>@',$schlechtes_html)) {
    print "Ihr Glück! (Schlechtes HTML, keine Rückwärtsreferenzen)\n";
}
?>
<?php
$html = <<<_HTML_
<ul>
<li>Rindfleisch Chow-Fun</li>
<li>Sautierte Zuckerschoten</li>
<li>Nudeln mit Sojasoﬂe</li>
</ul>
_HTML_;

preg_match('@<li>(.*?)</li>@',$html,$treffer);
$trefferzaehler = preg_match_all('@<li>(.*?)</li>@',$html,$alle_treffer);

print "preg_match_all(  ) hat $trefferzaehler Treffer gefunden.\n";

print "preg_match(  ) Array: ";
var_dump($treffer);

print "preg_match_all(  ) Array: ";
var_dump($alle_treffer);
?>
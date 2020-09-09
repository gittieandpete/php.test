$suesswaren = array('Sesam-Windbeutel','Kokusnus-Gelee-Happen',
                    'Karamell-Törtchen','Süßer Reis mit Fleisch');

// Das Formular anzeigen
function zeige_formular(  ) {
    print<<<_HTML_
<form method="post" action="$_SERVER[PHP_SELF]">
Ihre Bestellung: <select name="bestellung">

_HTML_;
foreach ($GLOBALS['suesswaren'] as $option) {
    print "<option>$option</option>\n";
}
print<<<_HTML_
</select>
<br/>
<input type="submit" value="Bestellen">
<input type="hidden" name="_abgeschickt_test" value="1">
</form>
_HTML_;
}

$suesswaren = array('windbeutel' => 'Sesam-Windbeutel',
                    'happen' => 'Kokosnuss-Gelee-Happen',
                    'toertchen' => 'Karamell-Törtchen',
                    'reisfleisch' => 'Süßer Reis mit Fleisch');

// Das Formular anzeigen
function zeige_formular(  ) {
    print<<<_HTML_
<form method="post" action="$_SERVER[PHP_SELF]">
Ihre Bestellung: <select name="bestellung">

_HTML_;
// $wert ist der Optionswert,  $wahl ist der angezeigte Optionstext
foreach ($GLOBALS['suesswaren'] as $wert => $wahl) {
    print "<option value=\"$wert\">$wahl</option>\n";
}
print<<<_HTML_
</select>
<br/>
<input type="submit" value="Bestellung">
<input type="hidden" name="_abgeschickt_test" value="1">
</form>
_HTML_;
}

// Den Wert von $_POST['zip'] mit dem Muster
// ^\d{5}(-\d{4})?$ vergleichen
if (preg_match('/^\d{5}$/',$_POST['zip'])) {
    print $_POST['plz'] . ' ist eine gültige US-Postleitzahl';
}

// Den Wert von $html mit dem Muster <b>[^<]+</b> vergleichen
// Der Begrenzer ist @, da im Muster / vorkommt
$ist_fett = preg_match('@<b>[^<]+</b>@',$html);

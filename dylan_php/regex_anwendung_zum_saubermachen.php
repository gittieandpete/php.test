<?php
$titel = "Bob Dylan Texte";
$menuitem = '';


require '../../../files/php/login_web330.php';
require '../includes/definitions.php';
require '../includes/functions.php';
connect ();
session_start();
require '../includes/uebunghead.php';
require '../includes/uebungkopf.php';
require '../includes/uebungnavi.php';

print "<h1>$titel</h1>";
?>


<?php

// keine Schreibrechte für Ordner, die müssen vorher schon vorhanden sein.
// Ordnerliste per dir, Ordner per mkdir anlegen (siehe ordnerliste.cmd)


// Dateinamen einlesen
// von dylan_liste.txt

$dateiname = 'dylan_liste.txt';
$text = file_get_contents($dateiname);
// Zeilenumbruch als delimiter /n/r, oder systemunabhängig PHP_EOL
$dateinamensliste = explode(PHP_EOL,$text);
// print '<pre>';
// print_r($dateinamensliste);

print '<ul>' . "\n";
for ($i=0;$i<count($dateinamensliste);$i++)
    {
    $dateiname = $dateinamensliste[$i];
    // @ als Begrenzer, weil slash im Suchmuster vorkommt
    $pattern='@[^/]+/([^/]+/)([^/]+)$@';
    $subject=$dateiname;
    preg_match($pattern,$subject,$matches);
    // print_r($matches);
    // Ordnername ist [1] des Arrays
    // Dateiname ist [2] des Arrays
    $text = file_get_contents($dateiname);
    $text = putzen($text);
    $speichern = 'fertig/' . $matches[1] . $matches[2];
    $ok=file_put_contents($speichern,$text);
    print '<li>' . $matches[1] . $matches[2] . ' gespeichert. </li>' . "\n";
}
print '</ul>' . "\n";

function putzen($text)
    {
    // zuerst den Zeilenumbruch entfernen (PHP_EOL funktioniert hier offenbar nicht)
    $text = preg_replace('@\n@','',$text);
    if(preg_match('@<title>AZ Lyrics.az \| ([^<]+)</title>@',$text,$treffer))
        {
        $title=$treffer[1];
    }
    $header='<!DOCTYPE html><html lang="de"><head><title>' . $title . '</title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="author" content="Bob Dylan"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" type="text/css" href="../styles.css"></head>';
    $text = preg_replace('@<!DOCTYPE html>.*</head>@',$header,$text);
    $text = preg_replace('@<h1 class="text-yellow" style="display: inline; text-align: center;">@','<h1>',$text);
    $text = preg_replace('@<body>.*<h1@','<body><h1',$text);
    $text = preg_replace('@<span style="color:#29013c;.*</span>@','',$text);
    $text = preg_replace('@<a id="correct-lyrics">.*@','</body></html>',$text);
    // Zeilenumbruch hinzufügen
    $text = preg_replace('@>@',">\n",$text);
    return $text;
}

?>



<?php
require '../includes/uebungfooter.php';
?>

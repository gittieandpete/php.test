<?php

$titel = "Über mich";
$menuitem = 'navigation';


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

<h2>Navigation zum Umschalten auf eine andere Sprache</h2>

<p>Es soll die entsprechende Seite mit der sprechenden URL der anderen Sprache ausgegeben werden.</p>

<p>Die deutsche Version liegt in /de, die englische in /en.</p>

<?php
$menu_labels = array (
    'datenschutzerklaerung.php' => 'DATENSCHUTZERKLÄRUNG',
    'impressum.php' => 'IMPRESSUM',
    'index.php' => 'START',
    'kontakt.php' => 'KONTAKT',
    'leistungen.php' => 'LEISTUNGEN',
    'ueber_mich.php' => 'ÜBER MICH',
    'data_privacy_statement.php' => 'DATA PRIVACY STATEMENT',
    'legal_notes.php' => 'LEGAL NOTES',
    'index.php' => 'HOME',
    'contact.php' => 'CONTACT',
    'services.php' => 'SERVICES',
    'about_me.php' => 'ABOUT ME',
);

$menu_de = array (
    'datenschutzerklaerung.php' => 'data_privacy_statement.php',
    'impressum.php' => 'legal_notes.php',
    'index.php' => 'index.php',
    'kontakt.php' => 'contact.php',
    'leistungen.php' => 'services.php',
    'ueber_mich.php' => 'about_me.php'
    );
$menu_en = array_flip($menu_de);
$menu_lang = array (
    '/de'=>$menu_de,
    '/en'=>$menu_en
);

debug($menu_labels);
debug($menu_de);
debug($menu_en);
debug($menu_lang);

$pathinfo = pathinfo($_SERVER['PHP_SELF']);
debug($pathinfo);
$dir = $pathinfo['dirname'];
$protocol = $_SERVER['REQUEST_SCHEME'];
$file = $pathinfo['basename'];
$self = basename($_SERVER['PHP_SELF']);
debug($protocol);
debug($dir);
debug($file);
debug($self, 'alternative PHP_SELF');
?>

<p>Die entsprechende anderssprachige Seite finden:</p>
<?php
// find page in other language
$seite = $menu_lang[$dir][$file];
debug($seite);
?>

<p>Das Label der aktuellen Seite finden:</p>

<?php
// find label of current page
// find the key
$key = array_keys($menu_lang[$dir],$seite)[0];
// find the label
$label = $menu_labels[$key];
debug($key);
debug($label);
?>

<p>Navigation automatisch ausgeben</p>

<ul>
<?php
debug($menu_lang[$dir]);
?>

<?php
// print menu
foreach($menu_lang[$dir] as $key => $value)
    {
    $label = $menu_labels[$key];
    menue ($key,$label);
}?>
</ul>


<?php
// debug($_SERVER);
?>

<p class="lang">
<?php
if ($dir == '/de')
    { ?>
    de | <a href="/en/<?php print $seite;?>">en</a>
<?php }
if ($dir == '/en')
    { ?>
    <a href="/de/<?php print $seite;?>">de</a> | en
<?php }
?>


</p>


<?php
require '../includes/uebungfooter.php';
?>

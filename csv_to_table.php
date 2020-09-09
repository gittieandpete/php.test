<?php
$titel = "CSV-Datei als Html-Tabelle ausgeben";
$menuitem = '';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php'; ?> 

<h1><?php print $titel;?></h1>

<table class='csv-data'>

<?php
// mode: Beschreibung
// 'r': Nur zum Lesen geöffnet; platziere Dateizeiger auf Dateianfang. 
$f = fopen("files/piano_literature_classified.csv", "r");
    // erste Zeile mit th per css ".csv-data tr:first-child"
    // files/konzertveranstalter_min $delimiter als '	' angeben
    // files/piano_literature_classified.csv $delimiter ';'
while (($line = fgetcsv($f,$length=0,$delimiter=';',$enclosure='"',$escape='\\')) !== false) { ?> 
        <tr>
        <?php foreach ($line as $cell) { ?> 
        <td><?php print htmlspecialchars($cell);?></td>
        <?php } ?> 
    </tr>
<?php }
fclose($f); ?>

</table>

<?php
require 'includes/uebungfooter.php';
?>

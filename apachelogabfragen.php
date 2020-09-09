<?php
$titel = "Apachelog Abfragen";
$menuitem = 'datenbank';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php';

print "<h1>$titel</h1>";
?>

<h2>Beispiele für Abfragen</h2>

<p>Der Aufbau dieser Seite kann etwas dauern - je mehr Wochen in der Datenbank sind, desto länger dauern die Abfragen.</p>

<h3>Zeitraum der vorliegenden Daten</h3>

<p>Achtung, die Tabelle existiert nicht mehr! Die mysql-Abfragen sind auskommentiert.</p>

<?php

$abfrage = "select count(date) as Anzahl, date from apachelog group by date order by date";

print "<p><code>$abfrage</code></p>";

// $query = mysql_query("$abfrage");
?>

<h3>Die häufigsten 20 400er Meldungen pro request nach Häufigkeit</h3>

<?php
$abfrage = "select status as Status, count(status) as Anzahl, request as Request from apachelog where status >= '400' AND status <= '500' group by request order by Anzahl desc limit 20;";

print "<p><code>$abfrage</code></p>";
?>

<h3>Die ersten 30 Requests mit gleichem Useragent, nur html-Dateien</h3>

<?php
$abfrage = "select count(ua) as Anzahl, ua as UserAgent from apachelog where request like '%html%' group by ua order by Anzahl desc limit 0,30";

print "<p><code>$abfrage</code></p>";
?>

<h3>Die 50 meistverlangten Dateien</h3>

<?php
$abfrage = "select count(request) as Anzahl, request as Datei from apachelog group by request order by Anzahl desc limit 50";

print "<p><code>$abfrage</code></p>";
?>

<h3>Seitenabrufe pro Tag, sortiert nach Datum</h3>

<p>Anmerkung: mit 'like' bedeutet '%' 1 oder mehr beliebige Zeichen. Für genau 1 beliebiges Zeichen '_' verwenden.</p>

<?php
$abfrage = "select count(date) as 'Abrufe pro Tag', date as Tag from apachelog where request like 'GET %.php%' OR request like 'GET / %' group by date order by date limit 21";

print "<p><code>$abfrage</code></p>";

?>

<h3>Seitenabrufe pro Tag, sortiert nach Häufigkeit</h3>

<?php
$abfrage = "select count(date) as 'Abrufe pro Tag', date as Tag from apachelog where request like 'GET %.php%' OR request like 'GET / %' group by date order by count(date) desc limit 21";

print "<p><code>$abfrage</code></p>";
?>


<h3>Anfragen pro IP</h3>

<?php
$abfrage = "select count(ip) as Anzahl, ip as IP, ua as '
User Agent' from apachelog group by ip order by Anzahl desc limit 0,30";

print "<p><code>$abfrage</code></p>";
?>

<h3>Die häufigsten Anfragen an Google, die bei Merz gelandet sind</h3>

<?php
$abfrage = "select count(referer) as Anfragen, referer, request from apachelog where referer like '%google%' group by referer order by Anfragen desc limit 20";

print "<p><code>$abfrage</code></p>";
?>


<?php
require 'includes/uebungfooter.php';
?>
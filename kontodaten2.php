<?php
$titel = "Kontodaten";
$menuitem = 'kontodaten';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php';

print "<h1>$titel</h1>";

print "<pre>

Umsätze von Bank als csv herunterladen;
umbenennen in umsatz.csv;
erste Zeile nicht löschen;
per ftp nach /var/www/c-major.de/php kopieren;
Rechte prüfen;
putty: mysql -u root -p usr_web330_1;
delete from steuer_kontodaten;
load data local infile
'/var/www/c-major.de/php/umsatz.csv'
into table steuer_kontodaten
fields terminated by ';'
enclosed by '\"';
(Quelltext? backslash entfernen);
Daten einfach von dieser Seite (Browser) kopieren
In OpenOffice einfügen, Dialog:
    'Werte in Hochkomma...' Haken weg,
    Spaltentrenner Semikolon,
    Texttrenner Anführungszeichen
Valutatag: ganze Spalte markieren,
Ctrl+F, Dialog:
    (Optionen nur in Selektion, Regulärer Ausdruck),
    suchen nach ^.*$ ersetzen durch &

Kategorien:
Arbeitszimmer
Bankgebühren
Barentnahme
Betreuungskosten
eigener Übertrag
Fachliteratur
Fahrtkosten
Geschenk
gezahlte Vorsteuern
Hans und Helene
Konzerthonorar
Lohn
Miete
Sonstige Ausgaben
Stadtwerke
Studio
Telefon
Unterhaltszahlung Kinder
Versicherung

</pre>";

print '<pre>
Tabellendesign:
(siehe csv-headerzeile aus dem download von der Sparkasse Hannover)
(hintendran kategorie und id)

create table steuer_kontodaten (
    auftragskonto varchar(30),
    buchungstag varchar(30),
    valutadatum varchar(30),
    buchungstext varchar(250),
    verwendungszweck varchar(250),
    beguenstigter varchar(100),
    kontonummer varchar(30),
    blz varchar(30),
    betrag varchar(30),
    waehrung char(3),
    info varchar(30),
    kategorie varchar(100),
    id INT NOT NULL auto_increment,
    PRIMARY KEY(id)
);
</pre>';


/*
Bedingungen für das Feld 'Beguenstigter':
Arbeitszimmer = 'MARKUS THUMERER'
Bankgebühren = 'DEKABANK FFM' oder 'SPARKASSE HANNOVER'
Barentnahme = 'GA NR.*'
Betreuungskosten = 'NATURKINDERGARTEN E.V.'
eigener Übertrag = 'MUELLER PETER' oder 'Amsterdam Trade Bank.*' oder 'CHRISTINE KOEHLER' oder 'PETER MUELLER'
Fachliteratur = 'BARTELS.*'
Fahrtkosten = 'DB FERNVERKEHR AG' oder 'DB VERTRIEB GMBH' oder 'STADTMOBIL HANNOVER GMBH'
gezahlte Vorsteuern = 'FA HANNOVER-MITTE.*'
Konzerthonorar = 'AXEL HEIL' oder 'BENEKE, ANNIKA' oder 'FEINE DINNER SHOW GMBH' oder 'MTV VON 1848 HILDESHEIM' oder 'NORDDEUTSCHER RUNDFUNK'
Lohn = 'OFD-LBV.*'
Miete = 'BARON-GLAUERT, HEIDI'
Stadtwerke = 'STADTWERKE HANNOVER AG'
Studio = 'KR IMMOBILIENMANAGEMENT'
Telefon = 'KLARMOBIL GMBH' oder 'VODAFONE D2 GMBH'
Versicherung = 'VHV ALLGEMEINE AG' oder 'LANDESKRANKENHILFE V.V.A.G.' oder 'HANNOVERSCHE LEBEN'
*/

print "<h3>Kategorien zuweisen mit MySQL</h3>\n\n";
$inserts = 0;
$noinserts = 0;
$sql = 'select id, beguenstigter from steuer_kontodaten';
$frage1 = mysql_query($sql);
print "<ul>\n\n";
while ($ergebnis1 = mysql_fetch_array($frage1, MYSQL_ASSOC))
    {
    $id = $ergebnis1['id'];
    $wert = $ergebnis1['beguenstigter'];
    if ('MARKUS THUMERER' == $wert)
        {
        $kategorie = 'Arbeitszimmer';
    }
    if ('DEKABANK FFM' == $wert || 'SPARKASSE HANNOVER' == $wert)
        {
        $kategorie = 'Bankgebühren';
    }
    if (preg_match('/GA NR.*/', $wert))
        {
        $kategorie = 'Barentnahme';
    }
    if ('NATURKINDERGARTEN E.V.' == $wert)
        {
        $kategorie = 'Betreuungskosten';
    }
    if ('MUELLER PETER' == $wert || preg_match('/Amsterdam Trade Bank.*/', $wert) || 'CHRISTINE KOEHLER' == $wert || 'PETER MUELLER' == $wert)
        {
        $kategorie = 'eigener Übertrag';
    }
    if (preg_match('/BARTELS.*/', $wert))
        {
        $kategorie = 'Fachliteratur';
    }
    if ('DB FERNVERKEHR AG' == $wert || 'DB VERTRIEB GMBH' == $wert || 'STADTMOBIL HANNOVER GMBH' == $wert || preg_match('/ARAL.*/', $wert) || preg_match('/ESSO.*/', $wert) || preg_match('/SHELL.*/', $wert)  || preg_match('/JET-TANK.*/', $wert))
        {
        $kategorie = 'Fahrtkosten';
    }
    if ('MÜLLER, MARGARETE FRANZISKA' == $wert)
        {
        $kategorie = 'Geschenk';
    }
    if (preg_match('/FA HANNOVER-MITTE.*/', $wert))
        {
        $kategorie = 'gezahlte Vorsteuern';
    }
    if ('LANGEHEIN, HANS' == $wert || 'LANGEHEIN, HELENE' == $wert || 'LANGEHEIN HANS' == $wert)
        {
        $kategorie = 'Hans und Helene';
    }
    if ('AXEL HEIL' == $wert || 'BENEKE, ANNIKA' == $wert || 'FEINE DINNER SHOW GMBH' == $wert || 'MTV VON 1848 HILDESHEIM' == $wert || 'NORDDEUTSCHER RUNDFUNK' == $wert)
        {
        $kategorie = 'Konzerthonorar';
    }
    if (preg_match('/OFD-LBV.*/', $wert))
        {
        $kategorie = 'Lohn';
    }
    if ('BARON-GLAUERT, HEIDI' == $wert)
        {
        $kategorie = 'Miete';
    }
    if (preg_match('/REWE.*/', $wert))
        {
        $kategorie = 'Sonstige Ausgaben';
    }
    if ('STADTWERKE HANNOVER AG' == $wert)
        {
        $kategorie = 'Stadtwerke';
    }
    if ('KR IMMOBILIENMANAGEMENT' == $wert)
        {
        $kategorie = 'Studio';
    }
    if ('KLARMOBIL GMBH' == $wert || 'VODAFONE D2 GMBH' == $wert)
        {
        $kategorie = 'Telefon';
    }
    if ('AMT F. JUGEND U. FAMILIE' == $wert)
        {
        $kategorie = 'Unterhaltszahlung Kinder';
    }
    if ('VHV ALLGEMEINE AG' == $wert || 'LANDESKRANKENHILFE V.V.A.G.' == $wert || 'HANNOVERSCHE LEBEN' == $wert)
        {
        $kategorie = 'Versicherung';
    }
    if (isset($kategorie))
        {
        $sql2 = "update steuer_kontodaten set kategorie = '$kategorie' where id = '$id'";
        $ok = mysql_query($sql2);
        if ($ok) $inserts++;
    } else $noinserts++;
    unset ($kategorie);
}
print "</ul>\n\n";
print "<p>Es wurden ${inserts}mal Kategorien eingetragen, ${noinserts}mal nicht.</p>\n\n";


print "<h3>Export - Ausgabe der Kontodaten mit Kategorien</h3>\n\n";

$sql3 = 'select
    auftragskonto,
    buchungstag,
    valutadatum,
    buchungstext,
    verwendungszweck,
    beguenstigter,
    kontonummer,
    blz,
    betrag,
    waehrung,
    info,
    kategorie from steuer_kontodaten order by kategorie, beguenstigter;';
$ergebnis3 = mysql_query($sql3);
mysql_out_csv($ergebnis3, 'Kontodaten plus Kategorien');

print "<div style='clear:both;'></div>";

require 'includes/uebungfooter.php';

?>

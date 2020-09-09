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

print "<p>Dies ist die endgültige Version, für die vorige siehe <a href=\"kontodaten2.php\">kontodaten2.php</a></p>\n\n";

print <<<HTML
<pre>

Umsätze von Bank als csv herunterladen;
Format CSV-MT940
umbenennen in umsatz.csv;
in Textpad laden, speichern unter mit Zeichensatz utf-8;
erste Zeile nicht löschen;
linux: per ftp nach /var/www/html/c-major.de/php kopieren;
xampp: nach htdocs/c-major.de/php kopieren
Rechte prüfen;
putty:
# From command line, run your client with the load-infile option set to true
# in order to be able to use load data local infile
# mysql --local-infile=1 -p;
mysql -u root -p usr_web330_1 --local-infile=1;
delete from steuer_kontodaten;
# fuer Linux/Debian
# load data local infile
# '/var/www/html/c-major.de/php/umsatz.csv'
# into table steuer_kontodaten
# fields terminated by ';'
# enclosed by '"';
#

# fuer xampp unter windows /phpmyadmin
load data local infile
'D:/prox/xampp/htdocs/c-major.de/php/umsatz.csv'
into table steuer_kontodaten
fields terminated by ';'
enclosed by '"';

Daten einfach von dieser Seite (Browser) kopieren, in Textpad kopieren, speichern als umsatz_kategorien.csv.
In LibreOffice einfügen, Dialog:
    Zeichensatz utf-8
    'Werte in Hochkomma...' Haken weg,
    Spaltentrenner Semikolon,
    Texttrenner Anführungszeichen
Valutatag: ganze Spalte markieren,
Ctrl+F, Dialog:
    (Optionen nur in Selektion, Regulärer Ausdruck),
    suchen nach ^.*$ ersetzen durch &


</pre>
HTML;

print "<p>Tabellendesign siehe <a href=\"kontodaten2.php\">kontodaten2.php</a> oder mysqlinfo.txt</p>";

$kategorien = array(
    'AfA' => array(
        'AKAD. ARBEITSGEM. - WOLTERS  KLUWER',
        'Musikhaus Thomann',
        'Venta Luftwaescher'
    ),
    'Bankgebühren' => array(
        'DEKABANK FFM',
        'DekaBank Frankfurt',
        'SPARKASSE HANNOVER',
        'Entgeltabrechnungsiehe Anlage'
    ),
    'Barentnahme' => array(
        'GA NR'
    ),
    'Betreuungskosten' => array(
        'NATURKINDERGARTEN E.V.',
        'Naturkindergarten Eilenried e e.V.',
        'NATURKINDERGARTEN EILENRIED E E.V.',
        'Dada Elterninitiative e.V.'
    ),
    'eigener Übertrag' => array(
        'Amsterdam Trade Bank',
        'CHRISTINE KOEHLER',
        'MUELLER PETER',
        'Mueller Peter',
        'PETER MUELLER'
    ),
    'Eltern- Kindergeld' => array(
        'Bundesagentur fuer Arbeit -  Familienkasse',
        'Bundeskasse Trier Dienstsit z Kiel'
    ),
    'Fachliteratur' => array(
        'BARTELS',
        'Bartels GmbH'
    ),
    'Fahrtkosten' => array(
        'ARAL',
        'DB FERNVERKEHR AG',
        'DB VERTRIEB GMBH',
        'DB Vertrieb GmbH',
        'DEUTSCHE BAHN',
        'ESSO',
        'JET-TANK',
        'Kaniewski KFZ',
        'SHELL',
        'STADTMOBIL HANNOVER GMBH',
        'STAR TST',
        'Stadtmobil Hannover GmbH'
    ),
    'Gehalt Musikhochschule' => array(
        'OFD-LBV',
        'Nieders',
        'Niedersächsische Landeshaup tkasse'
    ),
    'Gehalt Lukaskirche' => array(
        'COMRAMO Finanz GmbH'
    ),
    'Geschenk' => array(
        'MÜLLER, MARGARETE FRANZISKA'
    ),
    'gezahlte Vorsteuern' => array(
        'FA HANNOVER-MITTE',
        'FINANZAMT HANNOVER-MITTE',
        'Finanzamt Hannover-Mitte'
    ),
    'Hans und Helene' => array(
        'LANGEHEIN, HANS',
        'LANGEHEIN, HELENE',
        'LANGEHEIN HANS'
    ),
    'Klavierverkauf' => array(
        'ANDREAS KIPP',
        'KIPP, ANDREAS',
        'Kipp, Andreas'
    ),
    'Konzerthonorar' => array(
        'Annika Beneke',
        'Axel Hickthier',
        'BENEKE ANNIKA',
        'BENEKE, ANNIKA',
        'Beneke, Annika',
        'CATHERINE RENNO',
        'CELLA ST. BENEDIKT',
        'Celler Schloßtheater eingetragener Verein',
        'Celler Stadtkantorei e.V.',
        'Egon Martens',
        'FEINE DINNER SHOW GMBH',
        'LANDESKIRCHENKASSE HANNOVER',
        'Männer-Turn-Verein 1848 Hildesheim e.V.',
        'MAJA LUTSCH',
        'MARTENS, EGON',
        'MAURICE RUEMPER',
        'MERZ-KLAVIERE GMBH',
        'MTV VON 1848 HILDESHEIM',
        'MTV von 1848 Hildesheim',
        'Martens, Egon',
        'Merz - Klaviere GmbH',
        'NORDDEUTSCHER RUNDFUNK',
        'Norddeutscher Rundfunk',
        'STADTKIRCHENKASSE',
        'Stadtkirchenverband Hannover',
        'Silke Falk'
    ),
    'Miete' => array(
        'BARON-GLAUERT, HEIDI',
        'Baron-Glauert, Heidi',
        'Robert Blanke KG'
    ),
    'Mieteinnahmen' => array(
        'Cornelia Hellbruegge',
        'CORNELIA HELLBRUEGGE',
        'SUSANNE WIENCIERZ'
    ),
    'Sonstige Ausgaben' => array(
        'REWE'
    ),
    'Stadtwerke' => array(
        'Stadtwerke Hannover AG'
    ),
    'Studio' => array(
        'KR IMMOBILIENMANAGEMENT'
    ),
    'Telefon' => array(
        'Klarmobil GmbH',
        'klarmobil',
        'MARKUS THUMERER',
        'Markus Thumerer',
        'Vodafone GmbH (eArcor)',
        'VODAFONE GMBH',
        'Vodafone GmbH',
        'Vodafone KabelDeutschland',
        'Vodafone Kabel DeutschlandGmbH',
        'Webspace-Verkauf.de ISP e.K .',
        'Webspace-Verkauf.de ISP e.K.'
    ),
    'Unterhaltszahlung Kinder' => array(
        'AMT F. JUGEND U. FAMILIE'
    ),
    'Versicherung' => array(
        'VHV ALLGEMEINE AG',
        'VHV Allgemeine AG',
        'LANDESKRANKENHILFE V.V.A.G.',
        'Landeskrankenhilfe V.V.a.G.',
        'HANNOVERSCHE LEBEN',
        'KUENSTLERSOZIALKASSE'
    )
);

print "<h3>Kategorien zuweisen mit MySQL</h3>\n\n";
$inserts = 0;
$noinserts = 0;

global $dbh;
$abfrage = "
    SELECT id, beguenstigter
    FROM steuer_kontodaten";

$exec = $dbh -> query($abfrage);
$result = $exec -> fetchall();

if(isset($result))
    {
    $query = 'update steuer_kontodaten set kategorie = :kategorie where id = :id';
    $stmt = $dbh -> prepare($query);
    for ($i=0;$i<count($result);$i++)
        {
        $id=$result[$i]['id'];
        $wert=$result[$i]['beguenstigter'];
        $kategorie = checkkategorie($wert);
        if (isset($kategorie))
            {
            $stmt -> bindParam(':id', $id);
            $stmt -> bindParam(':kategorie', $kategorie);
            $stmt -> execute();
            $inserts++;
        } else $noinserts++;
        unset ($kategorie);
    }
}

print "<p>Es wurden ${inserts}mal Kategorien eingetragen, ${noinserts}mal nicht.</p>\n\n";

function checkkategorie($wert)
    {
    global $kategorien;
    reset($kategorien);
    foreach ($kategorien as $schluessel => $wertearray)
        {
        foreach($kategorien[$schluessel] as $kat)
            {
             if (strpos($wert,$kat) !== false)
                {
                return $schluessel;
            }
        }
    }
}

print "<h3>Export - Ausgabe der Kontodaten mit Kategorien</h3>\n\n";
// diese Spalten brauche ich für die Steuer Tabelle 'Kontoauszug':
// kategorie	unterkategorie	betrag	buchungstag	beguenstigter	verwendungszweck
$abfrage = 'SELECT kategorie, id, betrag, buchungstag, beguenstigter, verwendungszweck
    FROM steuer_kontodaten
    ORDER BY kategorie, beguenstigter;';

// pdo_csv_out erwartet DB-Handle, Abfrage, Überschrift
pdo_csv_out($dbh,$abfrage,'Kontodaten plus Kategorien');

/*
// Entwicklung mit getColumnMeta (laut php manual https://secure.php.net/manual/de/pdostatement.getcolumnmeta.php bisher nicht verlässlich)
$handler=$dbh -> query($abfrage);
for ($i=0;$i<$handler->columnCount();$i++)
    {
    $meta[] = $handler->getColumnMeta($i);
    print $meta[$i]['name'] . '<br>';
}
print '<pre>';
$zeilen = count($result);
print_r($zeilen);
print_r($meta);
// print_r ($result);
print '</pre>';
*/

print "<div style='clear:both;'></div>";

require 'includes/uebungfooter.php';

?>

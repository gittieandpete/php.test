<?php

function ausgabe($text,$variable = 'VAR')
    {
    if (is_array($text))
        {
        print "\n<p>$variable: \n";
        print_r($text);
        print "</p>\n\n";
    } else {
    print "\n<p>$variable: $text</p>\n";
    }
}


function berechne($a)
    {
    if ($a == 1)
        {
        $a = 2;
        print "$a ";
    }
    $i = 2;
    $rest = $a % $i;
    $i++;
    while ($i < sqrt($a) && $rest != 0)
        {
        $rest = $a % $i;
        // nur noch ungerade Zahlen
        $i = $i + 2;
    }
    // Zeilenumbruch
    static $column = 1;
    if ($i > sqrt($a) && $rest != 0)
        {
        print "$a ";
        $column++;
        if ($column > 20)
            {
            print "<br>\n";
            $column = 1;
        }
    }
}

function bildliste($produktID)
    {
    // aktuelle function bildliste bei merz
    global $dbmerz;
    $query = "
        SELECT link, alttext, property
        FROM bilder
        WHERE produktID = :produktID
        AND link != ''
        AND status > 0
        ORDER BY ausrichtung";
    $i = 0;
    $stmt = $dbmerz -> prepare($query);
    $stmt -> bindParam(':produktID', $produktID);
    $stmt -> execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    if(isset($result))
        {
        for ($i=0;$i<count($result);$i++)
            {
            $bildinfo['link']=$result[$i]->link;
            $bildinfo['alttext']=$result[$i]->alttext;
            $bildinfo['property']=$result[$i]->property;
            $bildliste[$i]=$bildinfo;
        }
        fehlersuche($bildliste);
    }
    if (isset($bildliste)) return $bildliste;
}

// PDO benutzen
function connect ()
    {
    global $dbh;
    $dsn = "mysql:host=localhost;dbname=" . DATENBANK . ";charset=Latin1";
    $opt = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    $dbh = new PDO($dsn,USER,PASSWORT,$opt);
}

// PDO-Verbindung mit usr_web25_1
function connect_merz ()
    {
    global $dbmerz;
    $dsn = "mysql:host=localhost;dbname=usr_web25_1;charset=Latin1";
    $opt = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    $dbmerz = new PDO($dsn,'web25','Es1VadLefs+', $opt);
}

function debug($var)
    {
    print '<pre>';
    print_r($var);
    print '</pre>';
}

function demoliste($produktID)
    {
    global $dbmerz;
    $query = "
        SELECT link, linktext
        FROM demos
        WHERE produktID=:produktID
        AND reihenfolge=1
        LIMIT 1";
    $stmt = $dbmerz -> prepare($query);
    $stmt -> bindParam(':produktID', $produktID);
    $stmt -> execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    //var_dump($result);
    if ($result)
        {
        $link=$result[0]->link;
        $linktext=$result[0]->linktext;
        $link=preg_replace('/[^=]*=/','',$link);
        $linkliste[0] = $link;
        $linkliste[1] = $linktext;
        return $linkliste;
    }
}

// noch testen (1.9.2014)
function erstelldatum()
    {
    $date = date('d.m.Y', filectime(basename($_SERVER['PHP_SELF'])));
    if (!$date)
        {
        $date = date('d.m.Y');
    }
    return $date;
}

function fehlersuche ($var,$ausgabe = 'print_r',$bemerkung = 'Fehlersuche')
    {
    // Ausgabe als 'ul','txt','table','mysql' oder einfach print_r
    // FEHLERSUCHE in definitions.php auf 0 oder 1 setzen (oder true oder false)
    if (FEHLERSUCHE==1)
        {
        print "<div class=\"fehlersuche\">\n";
        print "<p><strong>$bemerkung:</strong></p>\n";
        switch ($ausgabe)
            {
            case 'print_r':
            print_r($var);
            break;
            case 'ul':
            if(is_array($var))
                {
                print "<ul>\n";
                foreach ($var as $schluessel => $wert)
                    {
                    print "\t<li>$schluessel: $wert</li>\n";
                }
                print "</ul>\n";
            } else {
                fehlersuche($var, 'txt');
            }
            break;
            case 'txt':
            print "<pre>$var</pre>";
            break;
            case 'table':
            if (is_array($var))
                {
                print "<table>\n";
                foreach ($var as $schluessel => $wert)
                    {
                    print "\t<tr>\n\t<td>$schluessel</td><td>$wert</td>\n\t</tr>\n\n";
                }
                print "</table>\n";
            } else {
                fehlersuche($var, 'txt');
            }
            break;
            case 'mysql':
            print "<table>\n";
            print "\t<tr>\n";
            for ($i = 0; $i < mysql_num_fields($var); $i++)
                {
                $th[$i] = mysql_field_name($var,$i);
                print "\t<th>$th[$i]</th>\n";
            }
            print "\t</tr>\n\n";
            while ($liste1 = mysql_fetch_array($var, MYSQL_ASSOC))
                {
                print "\t<tr>\n";
                foreach ($liste1 as $schluessel => $wert)
                    {
                    print "\t<td>$wert</td>\n";
                }
                print "\t</tr>\n\n";
            }
            print "</table>\n\n";
            break;

        } // Ende switch
        print "</div>\n"; // class=fehlersuche
    } // Ende if(fehlersuche)
}

function getcheckherst($hersteller,$kategorie)
    {
    $herstellerliste = herstellerliste($kategorie);
    if (!isset($herstellerliste[$_GET['hersteller']]))
        {
        return $hersteller='';
    }
    return $hersteller;
}

// Prüft $_GET (z.B. für pathinfos.php, holedaten)
function getcheckinstr($instrument,$kategorie)
    {
    $instrumentliste = instrumentliste($kategorie);
    if (!isset($instrumentliste[$_GET['instrument']]))
        {
        $instrument = '';
        return $instrument;
    }
    return $instrument;
}

function herstellerliste($kategorie)
    {
    global $dbmerz;
    $i = 0;
    $query = "
        SELECT distinct hersteller
        FROM produkte
        WHERE hersteller != ''
        AND kategorie = :kategorie
        AND status>0
        ORDER BY hersteller";

    $stmt = $dbmerz -> prepare($query);
    $stmt -> bindParam(':kategorie', $kategorie);
    $stmt -> execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    $herstellerliste=herstellerliste_mkarr ($result);
    if (isset($herstellerliste)) return $herstellerliste;
}

function herstellerliste_mkarr($result)
    {
    for ($i=0;$i<count($result);$i++)
        {
        $liste[$result[$i]->hersteller]=$i;
    }
    if (isset($liste)) return $liste;
}

function hole_pdo_daten ()
    {
    // aktueller unter merz-klaviere.de/includes/merz-functions.php
    global $abmessung,
        $baujahr,
        $biglink,
        $bildlink,
        $bildtitle,
        $dbmerz,
        $demolink,
        $farbe,
        $hersteller,
        $herstellerlink,
        $id,
        $instrument,
        $kategorie,
        $layout,
        $layout_bild_anzahl,
        $leertext,
        $max,
        $modell,
        $nummer,
        $preis,
        $preisabsolut,
        $property,
        $rabatt,
        $reihenfolge,
        $relpath,
        $richtung,
        $status,
        $text,
        $titel,
        $uvp,
        $zeilen,
        $zeitraum;

    $alt=waehle();
    fehlersuche($alt);

    if (in_array('hersteller',$alt) && in_array('instrument',$alt))
        {
        $abfrage = "select id, hersteller, herstellerlink, titel, modell, abmessung, farbe, nummer, baujahr, uvp, text, preis, preisabsolut, rabatt, layout, reihenfolge
        from produkte
        where kategorie = :kategorie
        AND hersteller = :hersteller
        AND instrument = :instrument
        AND status > 0
        AND status != 2
        order by reihenfolge";
        fehlersuche($abfrage);

        $stmt = $dbmerz -> prepare($abfrage);
        $stmt -> bindParam(':kategorie', $kategorie);
        $stmt -> bindParam(':hersteller', $hersteller);
        $stmt -> bindParam(':instrument', $instrument);
        $stmt -> execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    } elseif (in_array('hersteller',$alt))
        {
        $abfrage = "select id, hersteller, herstellerlink, titel, modell, abmessung, farbe, nummer, baujahr, uvp, text, preis, preisabsolut, rabatt, layout, reihenfolge
        from produkte
        where kategorie = :kategorie
        AND hersteller = :hersteller
        AND status > 0
        AND status != 2
        order by reihenfolge";
        fehlersuche($abfrage);

        $stmt = $dbmerz -> prepare($abfrage);
        $stmt -> bindParam(':kategorie', $kategorie);
        $stmt -> bindParam(':hersteller', $hersteller);
        $stmt -> execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    } elseif (in_array('instrument',$alt))
        {
        $abfrage = "select id, hersteller, herstellerlink, titel, modell, abmessung, farbe, nummer, baujahr, uvp, text, preis, preisabsolut, rabatt, layout, reihenfolge
        from produkte
        where kategorie = :kategorie
        AND instrument = :instrument
        AND status > 0
        AND status != 2
        order by reihenfolge";
        fehlersuche($abfrage);

        $stmt = $dbmerz -> prepare($abfrage);
        $stmt -> bindParam(':kategorie', $kategorie);
        $stmt -> bindParam(':instrument', $instrument);
        $stmt -> execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // für events
    if (in_array('zeitraum',$alt))
        {
        fehlersuche($zeitraum);
        $ts = time();
        if ($zeitraum == 'aktuell')
            {
            $abfrage = "select id, hersteller, herstellerlink, titel, modell, abmessung, farbe, nummer, baujahr, uvp, text, preis, preisabsolut, rabatt, layout, reihenfolge
            from produkte
            where kategorie = :kategorie
            AND status > 0
            AND status != 2
            AND unix_timestamp(ts) >= :ts
            order by ts asc";
            fehlersuche($abfrage);
        } elseif ($zeitraum == 'rueckblick')
            {
            $abfrage = "select id, hersteller, herstellerlink, titel, modell, abmessung, farbe, nummer, baujahr, uvp, text, preis, preisabsolut, rabatt, layout, reihenfolge
            from produkte
            where kategorie = :kategorie
            AND status > 0
            AND status != 2
            AND unix_timestamp(ts) <= :ts
            order by ts desc";
            fehlersuche($abfrage);
        }
        $stmt = $dbmerz -> prepare($abfrage);
        $stmt -> bindParam(':kategorie', $kategorie);
        $stmt -> bindParam(':ts', $ts);
        $stmt -> execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    if (isset($status) && $status==2)
        {
        // die Angebote haben status=2
        $abfrage = "select id, hersteller, herstellerlink, titel, modell, abmessung, farbe, nummer, baujahr, uvp, text, preis, preisabsolut, rabatt, layout, reihenfolge
            from produkte
            where kategorie = :kategorie
            AND instrument = :instrument
            AND status = 2
            order by reihenfolge";
            fehlersuche($abfrage);
        $stmt = $dbmerz -> prepare($abfrage);
        $stmt -> bindParam(':kategorie', $kategorie);
        $stmt -> bindParam(':instrument', $instrument);
        $stmt -> execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    if (in_array('treffer',$alt))
        {
        // von der Suchseite. Nur ein Treffer wird gezeigt.
        fehlersuche($_GET['treffer'],'txt');
        $sql_treffer= 'select id, hersteller, herstellerlink, titel, modell, abmessung, farbe, nummer, baujahr, uvp, text, preis, preisabsolut, rabatt, layout, reihenfolge
            from produkte
            where reihenfolge= :treffer';
            fehlersuche($sql_treffer);
        $stmt = $dbmerz -> prepare($sql_treffer);
        $stmt -> bindParam(':treffer', $treffer);
        $treffer=intval($_GET['treffer']);
        $stmt -> execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    if (isset($leertext))
        {
        if ($leertext == 'a') $leertext = "<p>Für aktuelle Angebote <a href=\"/info/kontakt.php\">sprechen Sie uns gern an</a>!</p>\n\n";
        elseif ($leertext == 'e') $leertext =  "<p>Im Moment sind keine Veranstaltungen geplant.</p>\n\n";
        elseif ($leertext == 'h') $leertext = "<p>Informationen zu historischen Instrumenten auf <a href=\"/info/kontakt.php\">Anfrage</a>!</p>\n\n";
        else $leertext = '<p>Im Moment haben wir keine Angebote</p>';
    }

    if (!isset($result))
        {
        print $leertext;
    }

    if(isset($result))
        {
        // sqltable_merz($result);

        for ($i=0;$i<count($result);$i++)
            {
            // id, hersteller, herstellerlink, titel, modell, abmessung, farbe, nummer, baujahr, uvp, text, preis, preisabsolut, rabatt, layout, reihenfolge
            $id=$result[$i]->id;
            $hersteller=$result[$i]->hersteller;
            $herstellerlink=$result[$i]->herstellerlink;
            $titel=$result[$i]->titel;
            $modell=$result[$i]->modell;
            $abmessung=$result[$i]->abmessung;
            $farbe=$result[$i]->farbe;
            $nummer=$result[$i]->nummer;
            $baujahr=$result[$i]->baujahr;
            $uvp=$result[$i]->uvp;
            $text=$result[$i]->text;
            $preis=$result[$i]->preis;
            $preisabsolut=$result[$i]->preisabsolut;
            $rabatt=$result[$i]->rabatt;
            $layout=$result[$i]->layout;
            $reihenfolge=$result[$i]->reihenfolge;
        }
    }

    // Vorsicht bei HTML in $titel
    if ($abmessung)	$abmessung = $abmessung . '&nbsp;cm';
    if ($nummer)	$nummer = 'Nr.&nbsp;' . $nummer;
    if ($baujahr)	$baujahr = 'Baujahr&nbsp;' . $baujahr;
    if ($rabatt)	$rabatt = $rabatt . '%&nbsp;Rabatt';

    $bildlink = bildliste($id);
    $sep=' ,';
    if (count($bildlink)==1)
        {
        $bildtitle = $bildlink[0]['alttext'];
        $biglink = $bildlink[0]['link'];
        $bild = "{$relpath}grafik/$biglink";
        $layout_bild_anzahl = 1;
        // prop0, prop1 usw sind Css-Klassen, siehe dort unter img
        $property = 'prop' . $bildlink[0]['property'];
        // print $bildtitle . $sep . $biglink . $sep . $bild . $sep . $property;
    } else {
        unset ($bildtitle);
        unset ($biglink);
        unset ($bild);
        $layout_bild_anzahl = count($bildlink);
        for ($i=0;$i<count($bildlink);$i++)
            {
            $bildtitle[] = $bildlink[$i]['alttext'];
            $biglink[] = $bildlink[$i]['link'];
            $bild[] = 'grafik/' . $biglink[$i];
            $property[$i] = 'prop' . $bildlink[$i]['property'];
            print $bildtitle[$i] . $sep . $biglink[$i] . $sep . $bild[$i] . $sep . $property[$i];
        }
    }
    if (!$titel) $titel = titelcheck($titel,$hersteller,$modell);

    $demolink=demoliste($id);

    require ('includes/' . $layout . '.php');
    unset (
        $abmessung,
        $baujahr,
        $biglink,
        $bild,
        $bildlink,
        $bildtitle,
        $demolink,
        $farbe,
        $hersteller,
        $herstellerlink,
        $id,
        $layout,
        $modell,
        $nummer,
        $preis,
        $preisabsolut,
        $property,
        $rabatt,
        $reihenfolge,
        $text,
        $titel,
        $uvp);
}

function instrumentliste($kategorie)
    {
    global $dbmerz;
    $i = 0;
    $query = "
        SELECT distinct instrument
        FROM produkte
        WHERE instrument != ''
        AND kategorie = :kategorie
        AND status>0
        ORDER BY instrument";

    $stmt = $dbmerz -> prepare($query);
    $stmt -> bindParam(':kategorie', $kategorie);

    $stmt -> execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    $instrumentliste=instrumentliste_mkarr ($result);
    if (isset($instrumentliste)) return $instrumentliste;
}

function instrumentliste_mkarr($result)
    {
    for ($i=0;$i<count($result);$i++)
        {
        $liste[$result[$i]->instrument]=$i;
    }
    if (isset($liste)) return $liste;
}

function layoutcheck($bilder_erwartet)
    {
    global $layout_bild_anzahl;
    if ($layout_bild_anzahl!=$bilder_erwartet) print "<p class=\"klein\">Bitte das Layout überprüfen! Anzahl der Bilder: $layout_bild_anzahl statt $bilder_erwartet.</p>";
}

function menue ($adresse,$ankertext,$linktitel='Nähere Angaben')
    {
    if ($adresse == $_SERVER['PHP_SELF'])
        {
        print "\t" . '<li class="aktuell">' . $ankertext . "</li>\n";
    }
    else
        {
        print "\t" . '<li><a href="http://' . $_SERVER['HTTP_HOST'] . $adresse . '" title="' . $linktitel . '">' . $ankertext . "</a></li>\n";
    }
}

function mysql_out($var, $caption='Mysql-Tabelle')
    {
    print "<table class=\"mysql_out\">\n";
    print "\t<caption>$caption</caption>\n";
    print "\t<tr>\n";
    for ($i = 0; $i < mysql_num_fields($var); $i++)
        {
        $th[$i] = mysql_field_name($var,$i);
        print "\t<th>$th[$i]</th>\n";
    }
    print "\t</tr>\n\n";
    while ($liste1 = mysql_fetch_array($var, MYSQL_ASSOC))
        {
        print "\t<tr>\n";
        foreach ($liste1 as $schluessel => $wert)
            {
            print "\t<td>$wert</td>\n";
        }
        print "\t</tr>\n\n";
    }
    print "</table>\n\n";
}

function mysql_out_csv($var, $titel='Mysql-Tabelle')
    {
    print "<h2>$titel</h2>\n";
    print "<pre>\n";
    for ($i = 0; $i < mysql_num_fields($var); $i++)
        {
        $th[$i] = mysql_field_name($var,$i);
        print "\"$th[$i]\";";
    }
    print "\n";
    while ($liste1 = mysql_fetch_array($var, MYSQL_ASSOC))
        {
        foreach ($liste1 as $schluessel => $wert)
            {
            print '"' . $wert . '";';
        }
        print "\n";
    }
    print "</pre>\n\n";
}

function pdo_csv_out($dbh,$abfrage,$caption = 'Mysql-Tabelle')
    {
    $stmt = $dbh -> query($abfrage);
    $spalten_anzahl = $stmt->columnCount();
    $columnkeys = array_keys($stmt->fetch(PDO::FETCH_ASSOC));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $zeilen = count($result);

    print '<h3>' . $caption . '</h3>' . "\n";
    print '<pre>';
    for ($i = 0;$i < $spalten_anzahl;$i++)
        {
        print '"' . $columnkeys[$i] . '";';
    }
    print "\n";
    for ($zl = 0;$zl < $zeilen;$zl++)
        {
        for ($i = 0;$i < $spalten_anzahl;$i++)
            {
            print '"' . $result[$zl][$columnkeys[$i]] . '";';
        }
        print "\n";
    }
    print '</pre>';
}

function pdo_out($dbh,$abfrage,$caption = 'Mysql-Tabelle')
    {
    $stmt = $dbh -> query($abfrage);
    $spalten_anzahl = $stmt->columnCount();
    $columnkeys = array_keys($stmt->fetch(PDO::FETCH_ASSOC));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $zeilen = count($result);
    /*
    // Entwicklung
    print '<pre>';
    print 'Anzahl der Spalten: ';
    print_r($spalten_anzahl);
    print "\n" . 'Spalten: ';
    print_r($columnkeys);
    print "\n" . 'Zeilen vom Abfrageergebnis: ';
    print_r($zeilen);
    print '</pre>';
    */
    print '<table class = "mysql_out">' . "\n";
    print "\t" . '<caption>' . $caption . '</caption>' . "\n";
    print "\t<tr>\n";
    for ($i = 0;$i < $spalten_anzahl;$i++)
        {
        print "\t<th>" . $columnkeys[$i] . "</th>\n";
    }
    print "\t</tr>\n\n";
    for ($zl = 0;$zl < $zeilen;$zl++)
        {
        print "\t<tr>\n";
        for ($i = 0;$i < $spalten_anzahl;$i++)
            {
            print "\t" . '<td>' . $result[$zl][$columnkeys[$i]] . '</td>' . "\n";
        }
        print "\t</tr>\n\n";
    }
    print "</table>\n\n";
}

function out($var, $name = 'Var: ')
    {
    if (is_array($var))
        {
        print "\n<pre>Array $name \n";
        print_r($var) . "\n";
        print "</pre>\n\n";
    } else {
    print "\n<p>$name $var</p>\n";
    }
}

function print_index($dir) {
    // funktioniert nur von / aus, aus keinem Unterverzeichnis
    // $dir = getcwd();
    print "\n\n<li>Index von $dir:</li>\n\n";
    // print "<ul>\n";
    $dirhandle = opendir($dir);
    $dateinamen = array();
    $i = 0;
    while (($file = readdir($dirhandle)) !== false)
        {
        if (preg_match('/.+\.txt/',$file) && $file != 'index.php')
            {
            $dateinamen[$i] = $file;
            $i++;
        }
    }
    sort ($dateinamen);
    foreach ($dateinamen as $name)
        {
        menue ('/' . $dir . '/' . $name,$name);
        // print "\t<li><a href=\"$name\">$name</a></li>\n";
    }
    // print "</ul>\n";
}

function sekunden ($zahldertage)
    {
    $sekunden = 3600 * 24 * $zahldertage;
    return $sekunden;
}

#################
# Link-Element
#################

function naechste ($seite, $pfad)
    {
    $abfrage = "select id from seitenliste where basename = '$seite' AND cwd = '$pfad'";
    $query = mysql_query("$abfrage");
    if ($query)
        {
        $row = mysql_fetch_assoc($query);
        $id = $row['id'];
        $abfrage = "select basename, cwd from seitenliste where id = '$id' + 1";
        $query = mysql_query("$abfrage");
        if ($query)
            {
            $row = mysql_fetch_assoc($query);
            $pfad = $row['cwd'];
            $seite = $row['basename'];
            $next = $pfad . '/' . $seite;
            $next = str_replace('//', '/', $next);
        }
    }
    if (isset ($next)) return $next;
}


####################
#
# Für Merz Seriennummern/Wie alt
#
####################


// liest die möglichen Optionen für form -> select aus einer Tabelle
function optionen($spalte, $tabelle, $ordnung)
    {
    // Abfrage für die options-Liste
    $query = mysql_query("select $spalte from $tabelle
    order by $ordnung");
    // wird gespeichert in der $liste
    while ($ergebnis = mysql_fetch_array($query, MYSQL_ASSOC))
        {
        foreach ($ergebnis as $inhalt)
            {
            $liste[] = $inhalt;
        }
    }
    return $liste;
}

// liest und druckt die möglichen Optionen für form -> select aus einer Tabelle
function optionen2($tabellenname, $firmenname, $tabelle, $ordnung)
    {
    // Abfrage für die options-Liste
    $query = mysql_query("select $tabellenname, $firmenname from $tabelle
    order by $ordnung");
    while ($ergebnis = mysql_fetch_array($query, MYSQL_ASSOC))
        {
        if (isset($_POST['abgeschickt']) && $_POST['abgeschickt'] == 1)
            {
            // Eingabe noch prüfen
            $eingabe = $_POST['firma'];
            if ($eingabe == $ergebnis[$tabellenname])
                {
                print "\t<option selected value=\"$ergebnis[$tabellenname]\">$ergebnis[$firmenname]</option>\n";
            } else {
                print "\t<option value=\"$ergebnis[$tabellenname]\">$ergebnis[$firmenname]</option>\n";
            }
        } else print "\t<option value=\"$ergebnis[$tabellenname]\">$ergebnis[$firmenname]</option>\n";
    }
}


// liest eine Spalte, macht eine Liste und vergleicht die mit $eingabe
function firmapruefen ($eingabe, $spalte, $tabelle)
    {
    $i = 0;
    $query = mysql_query("select $spalte from $tabelle");
    while ($ergebnis = mysql_fetch_array($query, MYSQL_ASSOC))
        {
        foreach ($ergebnis as $inhalt)
            {
            $checkliste[$inhalt] = $i;
            $i++;
        }
    }
    if (!isset ($checkliste[$eingabe]))
        {
        print "<p>Diese Firma steht nicht in unserer Liste.</p>";
        // sonst wird der Rest der Seite nicht mehr ausgegeben, also:
        zeigedenrest();
        die;
    }
    return $eingabe;
}

function titelcheck ($titel,$hersteller,$modell)
    {
    if ($hersteller || $modell)
        {
        $titel = $hersteller . ' ' .  $modell;
        return $titel;
    }
    fehlersuche($titel);
}

function validiere ($text)
    {
    // Positiv-Liste, neu, mehr Zeichen
    $muster = '/[0-9a-zA-Z#%&\(\)+\-,.!\/:=@_¢£¥§©ª«°±²³µ¹º»¼½¾¿×ßÀàÁáÂâÃãÄäÅåÆæÇçÈèÉéÊêËëÌìÍíÎîÏïÐðÑñÒòÓóÔôÕõÖö÷ØøÙùÚúÛûÜüÝýÞþÿ]+/';
    $text = strip_tags (trim ($text));
    $text = substr ($text, 0, 2000);
    preg_match_all ($muster, $text, $treffer);
    $ergebnis = '';
    foreach ($treffer as $array)
        {
        foreach ($array as $wert)
            {
            $ergebnis .= $wert . ' ';
        }
    }
    $ergebnis = trim ($ergebnis);
    return $ergebnis;
}

function waehle()
    {
    global
        $kategorie,
        $hersteller,
        $instrument,
        $zeitraum,
        $richtung,
        $status,
        $treffer;
    $alt = array();
    if (isset($_GET['hersteller']))
        {
        $hersteller = getcheckherst($_GET['hersteller'],$kategorie);
        fehlersuche($hersteller,'txt');
        if ($hersteller) $alt[]='hersteller';
    }
    if (isset($_GET['instrument']))
        {
        $instrument = getcheckinstr($_GET['instrument'],$kategorie);
        fehlersuche($instrument,'txt');
        if ($instrument) $alt[]='instrument';
    }
    if (isset($zeitraum)) $alt[]='zeitraum';
    if (isset($richtung)) $alt[]='richtung';
    if (isset($status)) $alt[]='status';
    if (isset($_GET['treffer']) && intval($_GET['treffer']>0)) $alt[]='treffer';
    return $alt;
}

function wrap($reihenfolge,$layout)
    {
    global $max,
        $zeilen;
    if ($max == $zeilen)
        {
        print '<div id="anker' . $reihenfolge . '"><!--' . $layout . " -->\n\n";
    } else	{
        print '<div id="anker' . $reihenfolge . '" class="wrap"><!--' . $layout . " -->\n\n";
    }
}
function wrap_microdata($reihenfolge,$layout)
    {
    global $max, $zeilen;
    if ($max == $zeilen)
        {
        print '<div id="anker' . $reihenfolge . '" itemscope itemtype="http://schema.org/Product"><!-- ' . $layout . " -->\n\n";
    } else	{
        print '<div id="anker' . $reihenfolge . '" itemscope itemtype="http://schema.org/Product" class="wrap"><!-- ' . $layout . "-->\n\n";
    }
}
function wrap_startseite($reihenfolge,$layout)
    {
    global $max, $zeilen;
    print '<div id="anker' . $reihenfolge . '" class="wrap_startseite"><!--' . $layout . "-->\n\n";
}


####################################
#
#     Für Formulare
#
####################################

// Ein Textfeld ausgeben mit $_POST-Werten
function input_text_post($feldname, $werte, $label = 'Textfeld')
    {
    print "\t<tr>\n\t<td class=\"rechts\">$label: </td>\n";
    print "\t<td><input type=\"text\" name=\"$feldname\" value=\"" . htmlentities($werte[$feldname]) .  "\"></td>\n";
    print "\t</tr>\n\n";
}
// Ein Textfeld ausgeben ohne $_POST-Werte
function input_text($feldname, $label= 'Textfeld')
    {
    print "\t<tr>\n\t<td class=\"rechts\">$label: </td>\n";
    print "\t<td><input type=\"text\" name=\"$feldname\"></td>\n";
    print "\t</tr>\n\n";
}

// Passwort-Feld ausgeben
function input_passwort($feldname, $label = 'Passwort')
    {
    // $werte = $_POST[$feldname]; brauche ich beim Passwort nicht
    print "\t<tr>\n";
    print "\t<td class=\"rechts\">$label: </td>\n";
    print "\t<td><input type=\"password\" name=\"$feldname\"></td>\n";
    print "\t</tr>\n\n";
}

// Einen Absenden-Button ausgeben
function input_submit($feldname, $label = 'Absenden')
    {
    print "\t<tr>\n";
    print "\t<td></td>\n";
    print "\t<td><input type=\"submit\" name=\"$feldname\" value=\"$label\"></td>\n";
    print "\t</tr>\n\n";
}

// das versteckte Formularfeld ausgeben
function input_hidden($feldname = 'weg')
    {
    print "<input type=\"hidden\" name=\"$feldname\" value=\"1\">\n";
}

// bezieht sich auf das hidden-Feld im Formular
function iswech($hidden='weg')
    {
    if (isset ($_POST[$hidden]) && $_POST[$hidden] == 1)
        {
        return true;
    }
    return false;
}

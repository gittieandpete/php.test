<?php

function aktuell()
    {
    // timestamp jetzt
    $ts = time();
    // $ts = mktime(01,00,00,9,15,2012);
    $abfrage = "select titel, text, info
        from aktuell
        where status > 0
        AND unix_timestamp(gilt_ab) <= '$ts'
        AND unix_timestamp(gilt_bis) >= '$ts'
        order by reihenfolge, length(text)";
    $query = mysql_query($abfrage);
    if ($query)
        {
        $lfdnr = 0;
        $anzahlspalten=2;
        print "<table class=\"tabelle_aktuell\">\n\n";
        print "\t<tr>\n";
        while ($liste = mysql_fetch_array($query, MYSQL_ASSOC))
            {
            foreach ($liste as $inhalt)
                {
                $titel = $liste['titel'];
                $text = $liste['text'];
                $info = $liste['info'];
            }
            if ($lfdnr%$anzahlspalten==0 && $lfdnr>0) print "\t</tr>\n\n\t<tr>\n";
            print "\t<td>\n";
            print "\t<h2>$titel</h2>\n";
            print "\t<p>$text</p>\n";
            print "\t<p>$info</p>\n";
            print "\t</td>\n";
            $lfdnr++;
        }
        print "\t</tr>\n";
        print "</table>\n\n";
    }
}


?>
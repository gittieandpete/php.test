<?php
$titel = "Strippen";
$menuitem = '';


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

<p>Hier geht es darum, das Ergebnis von <a href="file_get_contents.php">File get Contents</a> (Google-Volltextsuche) aufzubereiten. Wir brauchen nur die Suchergebnisse, nicht die ganze Datei und auch kein neues Formular.</p>

<p><em>Scroogle hat sein Geschäftsmodell geändert, das folgende geht also nicht mehr. Ist trotzdem lehrreich wegen des Formularaufbaus und den String-Verarbeitungen. Formular nicht mehr benutzen!</em></p>

<h2>Teststring</h2>

<?php
// zum Testen hier einen String
$ergebnis = "<HTML><HEAD><META HTTP-EQUIV=\"content-type\"  CONTENT=\"text/html; charset=UTF-8\"><META NAME=\"ROBOTS\" CONTENT=\"NOINDEX,NOFOLLOW\">
<TITLE>hilfe site:www.merz-klaviere.de - Google Search</TITLE></HEAD>
<BODY BGCOLOR=#ffffff>
<BR><font face=\"Arial, Helvetica, sans-serif\"><blockquote>
<center><FORM METHOD=POST ACTION=\"http://www.scroogle.org/cgi-bin/nbbw.cgi\">
<INPUT TYPE=TEXT NAME=\"Gw\" VALUE=\"hilfe site:www.merz-klaviere.de\" SIZE=\"30\" MAXLENGTH=\"225\">
&nbsp;&nbsp;<INPUT TYPE=\"submit\" VALUE=\"Search\">
<INPUT TYPE=\"hidden\" NAME=\"n\" VALUE=\"5\">
</FORM></center>
<b>hilfe site:www.merz-klaviere.de - Google Search</b><br><br>
1. <A Href=\"http://www.merz-klaviere.de/service/hilfe_seriennummern.php\">Hilfeseite: Wie finde ich meine Seriennummer in den Listen?</a>
<ul><font size=2>\"... Petrof Zimmermann &middot; Pfeiffer Gaveau &middot; Pleyel Seiler &middot; Rönisch Steingraeber &middot;   Schiedmayer Young-Chang &middot; Steinway Bösendorfer &middot; Yamaha Sauter; <b style=\"background-color:#ffff66\">Hilfe</b> ...\"<br><font color=#008000>www.merz-klaviere.de/service/hilfe_seriennummern.php</font></font></ul>
2. <A Href=\"http://www.merz-klaviere.de/service/schiedmayer_youngchang.php\">Wie alt ist mein Flügel /Schiedmayer Piano Schiedmayer Klavier <b>...</b></a>
<ul><font size=2>\"... Rönisch Steingraeber; Schiedmayer Young-Chang; Steinway Bösendorfer &middot;   Yamaha Sauter &middot; <b style=\"background-color:#ffff66\">Hilfe</b> ... <b style=\"background-color:#ffff66\">Hilfe</b>. Wie finde ich meine Seriennummer in den Listen? ...\"<br><font color=#008000>www.merz-klaviere.de/service/schiedmayer_youngchang.php</font></font></ul>
3. <A Href=\"http://www.merz-klaviere.de/\">Klavierhaus Merz: Klaviere Flügel Digitalpianos Keyboards | neu + <b>...</b></a>
<ul><font size=2>\"Mit <b style=\"background-color:#ffff66\">Hilfe</b> der Seriennummer Ihres Instrumentes können Sie leicht herausfinden,   wann es gebaut wurde. In der Regel stehen diese Nummern auf der goldfarbenen ...\"<br><font color=#008000>www.merz-klaviere.de/</font></font></ul>
4. <A Href=\"http://www.merz-klaviere.de/verweise.php\">Verweise, Stichwortsuche</a>
<ul><font size=2>\"<b style=\"background-color:#ffff66\">Hilfe</b> Seriennummern. I. Ibach Seriennummern &middot; Impressum &middot; Infos &middot; Ibach Seriennummern &middot;   Irmler Seriennummern. J. K ...\"<br><font color=#008000>www.merz-klaviere.de/verweise.php</font></font></ul>
<BR><BR><center>
<FORM METHOD=POST ACTION=\"http://www.scroogle.org/cgi-bin/nbbw.cgi\">
<INPUT TYPE=TEXT NAME=\"Gw\" VALUE=\"hilfe site:www.merz-klaviere.de\" SIZE=\"40\" MAXLENGTH=\"225\">
&nbsp;&nbsp;<INPUT TYPE=\"submit\" VALUE=\"Search\">
<BR><font size=2>number of results<b>:</b> &nbsp;
<INPUT TYPE=RADIO NAME=\"n\" VALUE=\"2\">20 &nbsp; &nbsp;
<INPUT TYPE=RADIO NAME=\"n\" VALUE=\"5\" CHECKED>50 &nbsp; &nbsp;
<INPUT TYPE=RADIO NAME=\"n\" VALUE=\"1\">100
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <BR>
<BR><A Href=\"http://www.scroogle.org/\">home page</A> &nbsp; &nbsp; &nbsp; &nbsp;
<A Href=\"http://www.scroogle.org/scget.php\"><font color=#008000>how to make a bookmark</font></A>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </font></FORM></center>

<P></blockquote>
</BODY>
</HTML>";

$teilergebnis = "<b>hilfe site:www.merz-klaviere.de - Google Search</b><br><br>
1. <A Href=\"http://www.merz-klaviere.de/service/hilfe_seriennummern.php\">Hilfeseite: Wie finde ich meine Seriennummer in den Listen?</a>
<ul><font size=2>\"... Petrof Zimmermann &middot; Pfeiffer Gaveau &middot; Pleyel Seiler &middot; Rönisch Steingraeber &middot;   Schiedmayer Young-Chang &middot; Steinway Bösendorfer &middot; Yamaha Sauter; <b style=\"background-color:#ffff66\">Hilfe</b> ...\"<br><font color=#008000>www.merz-klaviere.de/service/hilfe_seriennummern.php</font></font></ul>
2. <A Href=\"http://www.merz-klaviere.de/service/schiedmayer_youngchang.php\">Wie alt ist mein Flügel /Schiedmayer Piano Schiedmayer Klavier <b>...</b></a>
<ul><font size=2>\"... Rönisch Steingraeber; Schiedmayer Young-Chang; Steinway Bösendorfer &middot;   Yamaha Sauter &middot; <b style=\"background-color:#ffff66\">Hilfe</b> ... <b style=\"background-color:#ffff66\">Hilfe</b>. Wie finde ich meine Seriennummer in den Listen? ...\"<br><font color=#008000>www.merz-klaviere.de/service/schiedmayer_youngchang.php</font></font></ul>
3. <A Href=\"http://www.merz-klaviere.de/\">Klavierhaus Merz: Klaviere Flügel Digitalpianos Keyboards | neu + <b>...</b></a>
<ul><font size=2>\"Mit <b style=\"background-color:#ffff66\">Hilfe</b> der Seriennummer Ihres Instrumentes können Sie leicht herausfinden,   wann es gebaut wurde. In der Regel stehen diese Nummern auf der goldfarbenen ...\"<br><font color=#008000>www.merz-klaviere.de/</font></font></ul>
4. <A Href=\"http://www.merz-klaviere.de/verweise.php\">Verweise, Stichwortsuche</a>
<ul><font size=2>\"<b style=\"background-color:#ffff66\">Hilfe</b> Seriennummern. I. Ibach Seriennummern &middot; Impressum &middot; Infos &middot; Ibach Seriennummern &middot;   Irmler Seriennummern. J. K ...\"<br><font color=#008000>www.merz-klaviere.de/verweise.php</font></font></ul>";

print $teilergebnis;
?>

<p>Der String soll gestrippt werden mit Regex.</p>

<?php
preg_match_all ('^[0-9]+\. <.*?<ul>.*?</ul>^s', $ergebnis , $treffer);

$ausgabe1 = $treffer;
$ausgabe2 = $treffer;
$ausgabe3 = $treffer;

print "<p>Ausgabe 1, var_dump</p>";

print '<pre>';
var_dump($ausgabe1);
print '</pre>';

print "<p>Ausgabe 2, Array buchstabiert</p>";

$a = $ausgabe2[0][0];
$b = $ausgabe2[0][1];
$c = $ausgabe2[0][2];
$d = $ausgabe2[0][3];


print '<ul>';
print "<li>$a</li>";
print "<li>$b</li>";
print "<li>$c</li>";
print "<li>$d</li>";
print '</ul>';

print "<p>Ausgabe 3, Arrayschleife</p>";

print "<ul>";
foreach ($ausgabe3 as $reihe)
    {
    foreach ($reihe as $inhalt)
        {
        print "<li>$inhalt</li>";
    }
}
print "</ul>";
?>

<p>Und weil das alles so schön klappt, kann alles zusammengefügt werden: Suchformular, Anfrage an Google über Scroogle, Empfang des Suchergebnisses mit file_get_contents, Umwandeln mit utf8_decode, Strippen mit Regex, Ausgabe mit foreach.</p>

<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
<input type="Text" name="suchwort" value="">
<input type="submit" value="Suche" style="width:80px">
<input type="hidden" name="gesendet" value="1">
</form>

<?php
if (isset($_POST['gesendet']) && $_POST['gesendet'] == 1)
    {
    $suchwort = $_POST['suchwort'];
    $ergebnis = file_get_contents("http://www.scroogle.org/cgi-bin/nbbw.cgi?Gw=$suchwort&n=5&d=www.merz-klaviere.de");
    print "<h2>Ergebnis vor Umwandlung:</h2>";
    print $ergebnis;
    $ergebnis = utf8_decode ("$ergebnis");
    print "<h2>Ergebnis nach Umwandlung mit utf8_decode</h2>";
    print $ergebnis;
    preg_match_all ('^[0-9]+\. <.*?<ul>.*?</ul>^s', $ergebnis , $treffer);
    print "<h2>Ergebnis nach Strippen mit preg_match_all</h2>";
    // count normal zählt nur das 'oberste' Array, count rekursiv zählt alles zusammen, also
    $x = count ($treffer, COUNT_RECURSIVE);
    $y = count ($treffer);
    $anzahl=  $x - $y;
    print "<p>$anzahl Treffer für &bdquo;$suchwort&ldquo;</p>";
    print "<ul>";
    foreach ($treffer as $reihe)
        {
        foreach ($reihe as $inhalt)
            {
            print "<li>$inhalt</li>";
        }
    }
    print "</ul>";
}

?>




<?php
require 'includes/uebungfooter.php';
?>

<div id="fusszeile">

<table>
<tr>
    <?php if (isset ($prev))
        {
        print "<td><a href=\"$prev\">&larr; zurück</a></td>";
    }
    ?>
    <td><a href="#kopf">&uarr; Nach oben &uarr;</a></td>
    <?php if (isset ($next))
        {
        print "<td><a href=\"$next\">weiter &rarr;</a></td>";
    }
    ?>
</tr>
</table>

</div> <!-- id="fusszeile -->

<h1 id="quelltext">Quelltext dieser Seite</h1>

<div style="margin:3%;">

<?php

if (!isset($_GET['highlight']) || $_GET['highlight']==0)
    {
    print "<p>Wenn gewünscht: ";
    print '<a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?highlight=1#quelltext">highlight file</a></p>';
}

if (isset($_GET['highlight']) && $_GET['highlight']==1)
    {
    print "<p>highlight file ";
    print '<a href="' . htmlspecialchars($_SERVER['PHP_SELF']) . '?highlight=0#quelltext">ausschalten.</a></p>';
    $datei = basename (htmlspecialchars($_SERVER['PHP_SELF']));
    // GET-Anhang loswerden
    $datei = preg_replace('/\?.*/','',$datei);
    highlight_file ($datei);
}
?>
</div>

</div> <!--id="outer"-->
</body>
</html>
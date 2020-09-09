

<ol>
<?php
    menu ('/de','Home');
    menu ('/de/zimmer.php','Zimmer');
    menu ('/de/seminarbereich.php','Seminarbereich');
    menu ('/de/galerie.php','Galerie');
    menu ('/de/kontakt.php','Kontakt');
    menu ('/de/lage.php','Lage');
    menu ('/de/service.php','Service');
    menu ('/navigation.php','aktuelle Seite');
?>
</ol>

<?php
function menu ($adresse,$ankertext)
    {
    if ($adresse == $_SERVER['REQUEST_URI'])
        {?>
        <li><a aria-current="page" href="<?php print $adresse;?>"><?php print $ankertext;?></a></li>
    <?php }
    else
        {?>
        <li><a href="<?php print $adresse;?>"><?php print $ankertext;?></a></li>
    <?php }
}?>


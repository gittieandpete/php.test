<div id="linkliste">

<ul class="menu">
    <?php
    menue ('/adminer-4.7.6.php', 'Adminer Mysql');
    menue ('/arrays1.php', 'Arrays');
    if (isset($menuitem) && $menuitem == 'arrays')
        {
        print '<li><ul class="sub">';
            menue ('/arrays2.php', 'Arrays, Forts.');
        print '</ul></li>';
    }
    menue ('/basics.php', 'Basics');
    menue ('/berechtigungen.php', 'Berechtigungen');
    menue ('/csv_to_table.php', 'CSV-Datei als Html-Tabelle');
    menue ('/dylan_php/regex_anwendung_zum_saubermachen.php', 'Dylan saubermachen');
    menue ('/dylan_php/regex_anwendung_test.php', 'Dylan Test');
    menue ('/apachelogabfragen.php', 'Apachelog Abfragen');
    menue ('/datumsangaben.php', 'Datumsangaben');
    menue ('/errors/fehler.php', 'Fehlerseite');
    menue ('/farben.php', 'Farben');
    menue ('/funktionen.php', 'Funktionen');
    menue ('/gaestebuch.php', 'Gästebuch');
    if (isset($menuitem) && $menuitem == 'gaestebuch')
        {
        print '<li><ul class="sub">';
            menue ('/gaestebuch_zaehler.php', 'Gästebuch,  Zähler');
        print '</ul></li>';
    }
    menue ('/http-header.php', 'HTTP-Header');
    menue ('/index.php', 'Index, 1. Versuch');
    menue ('/kakuro.php', 'Kakuro');
    if (isset($menuitem) && $menuitem == 'kakuro')
            {
            print '<li><ul class="sub">';
                menue ('/kakuro2.php', 'Kakuro improved');
                menue ('/kakuro3.php', 'Kakuro out+');
            print '</ul></li>';
        }
    menue ('/kontodaten.php', 'Kontodaten');
    menue ('/mailform/mailformular1.2.4.php', 'Mailformular');
    menue ('/mailform/mailformular_simpel_1.2.4.php', 'Mailformular simpel');
    menue ('/navigation.php', 'Navigation');
    if (isset($menuitem) && $menuitem == 'navigation')
        {
        print '<li><ul class="sub">';
        menue ('/en/about_me.php', 'About me', 'Select your language');
        menue ('/de/ueber_mich.php', 'Über mich', 'Schalter für Sprachauswahl');
        print '</ul></li>';
    }
    menue ('/oop1.php', 'OOP 1');
    if (isset($menuitem) && $menuitem == 'oop')
        {
        print '<li><ul class="sub">';
        menue ('/oop2.php', 'OOP 2');
        menue ('/oop3.php', 'OOP 3');
        print '</ul></li>';
    }
    menue ('/pdo_01_result.php', 'PDO Anfang' , 'erste Übungen, connect, Abfragen, result-Arrays');
    if (isset($menuitem) && $menuitem == 'pdo')
        {
        print '<li><ul class="sub">';
        menue ('/pdo_02_prepstatement.php', 'PDO Prep. Stmnts.' , 'Prepared Statements');
        menue ('/pdo_03_merzabfragen.php', 'PDO Merz' , 'Merz Abfragen umstellen');
        menue ('/pdo_04_holedaten.php', 'PDO holedaten', 'Merz function umbauen');
        menue ('/pdo_05_waehle.php', 'PDO Auswahl', 'Merz function umbauen, Auswahl der Abfragen');
        menue ('/pdo_06_checklisten.php', 'PDO Checklisten', 'whitelist');
        menue ('/pdo_07_standardtabelle.php', 'PDO MySQL Standardtabelle', 'automatische Tabelle bauen aus dem Abfrageergebnis');
        print '</ul></li>';
    }
    menue ('/php_testdatei.php', 'PHP Info');
    menue ('/primzahl.php', 'Primzahlen');
    menue ('/regex_test.php', 'Regex-Test');
    menue ('/sessions+cookies/cookies.php', 'Sessions+Cookies');
    if (isset($menuitem) && $menuitem == 'sessions')
        {
        print '<li><ul class="sub">';
            menue ('/sessions+cookies/session1.php', 'Session Farbe');
            menue ('/sessions+cookies/session2.php', 'Session Bestellung');
            menue ('/sessions+cookies/dbentwurf.php', 'DB-Entwurf');
            menue ('/sessions+cookies/login.php', 'Login');
            menue ('/sessions+cookies/registrieren.php', 'Registrieren');
            menue ('/sessions+cookies/login3changepass.php', 'Change Pass');
            menue ('/sessions+cookies/passwortvergessen.php', 'Passwort vergessen');
        print '</ul></li>';
    }
    menue ('/strippen.php', 'Strippen');
    menue ('/superglobals.php', 'Superglobals + Konstanten');
    menue ('/t9.php', 'T9');
    menue ('/zinsen.php', 'Zinsen');
    menue ('/zip.php', 'Zip');
    if (pathinfo($_SERVER['PHP_SELF'])['dirname']=='/')
        {
        print_index('info');
    }
    ?>

</ul>
</div> <!--id linkliste-->

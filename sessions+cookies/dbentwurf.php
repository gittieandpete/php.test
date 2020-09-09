<?php
$titel = "DB-Entwurf";
$menuitem = 'sessions';


require '../../../files/php/login_web330.php';
require '../includes/definitions.php';
require '../includes/functions.php';
connect ();
session_start();
require '../includes/uebunghead.php';
require '../includes/uebungkopf.php';
require '../includes/uebungnavi.php';

print "<h1>$titel</h1>";
?>

<pre>
create table studio_user
    (
    id INT NOT NULL auto_increment,
    PRIMARY KEY(id),
    -- user = mailadresse
    user varchar(100),
    vorname varchar(100),
    name varchar(100),
    pass varchar(50),
    pass_changed smallint unsigned default '0',
    admin smallint unsigned default '0',
    ts TIMESTAMP not null
);
create table studio_buchung (
    id INT NOT NULL auto_increment,
    PRIMARY KEY(id),
    userID int NOT NULL,
    begintime datetime NOT NULL,
    endtime datetime NOT NULL,
    preis decimal (7,2) unsigned not null default '2.50',
    ts TIMESTAMP not null
);
</pre>

<?php

// pass später ändern, jeweils pro user ein neues generieren. siehe registrieren.php
define('PASS','1234');
print '<p>Testuser anlegen:</p><pre>';
print "insert into studio_user (user, vorname, name, admin, pass) values('peter.mueller@c-major.de', 'Peter', 'Müller', '1', '" . crypt(PASS,SALT) . "');\n";
print "insert into studio_user (user, vorname, name, admin, pass) values('petermueller@c-major.de', 'Peter', 'Müller', '0', '" . crypt(PASS,SALT) . "');\n";
print "insert into studio_user (user, vorname, name, admin, pass) values('kobuhr@web.de', 'Kai', 'Buhr', '0', '" . crypt(PASS,SALT) . "');\n";
print "insert into studio_user (user, vorname, name, admin, pass) values('postfach.christinekoehler.de','Christine','Köhler', '0', '" . crypt(PASS,SALT) . "');\n";
print '</pre>';
?>
<?php
require '../includes/uebungfooter.php';
?>

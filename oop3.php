<?php
$titel = 'OOP Teil 3';
$menuitem = 'oop';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php';

include_once('classes/autoload.php');

print "<h1>$titel</h1>";





require 'includes/uebungfooter.php';


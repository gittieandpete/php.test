<?php

function __autoload($clname)
    {
    $filename = strtolower('classes/class_' . $clname . '.php');
    include_once($filename);
    // print "<p>'autoload' der Klasse $clname:</p>";
}

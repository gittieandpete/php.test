<?php
$titel = "HTTP-Header";
$menuitem = '';


require '../../files/php/login_web330.php';
require 'includes/definitions.php';
require 'includes/functions.php';
connect ();
session_start();
require 'includes/uebunghead.php';
require 'includes/uebungkopf.php';
require 'includes/uebungnavi.php';
?>

<h1><?php print "$titel";?></h1>

<pre>
<?php
    $request = apache_request_headers();
    $response = apache_response_headers();
    print_r ($request);
    echo $request['Accept-Language'];
    print_r ($response);
?>
</pre>


<?php
require 'includes/uebungfooter.php';
?>

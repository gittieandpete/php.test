require 'DB.php';
$db = DB::connect('mysql://pinguin:hut^spitze@db.beispiel.com/restaurant');
if (DB::isError($db)) { die("Keine Verbindung: " . $db->getMessage(  )); }

require 'Mail.php';
require 'Mail/mime.php';

$headers = array('From' => 'bestellungen@beispiel.com',
                 'Subject' => 'Ihre Bestellung');

$textinhalt = <<<_TXT_
Ihre Bestellung ist:
* 2 Frittierter Tofu
* 1 Aubergine mit Chili-Soﬂe
* 3 Ananas mit Yu-Pilzen
_TXT_;

$html_inhalt = <<<_HTML_
<p>Ihre Bestellung ist:</p>
<ul>
<li><b>2</b> Frittierter Tofu</li>
<li><b>1</b> Aubergine mit Chili-Soﬂe</li>
<li><b>3</b> Ananas mit Yu-Pilzen</li>
</ul>
_HTML_;

$mime = new Mail_mime(  );
$mime->setTXTBody($textinhalt);
$mime->setHTMLBody($html_inhalt);

$nachrichten_inhalt = $mime->get(  );
$nachrichten_header = $mime->headers($headers);

$mailer = Mail::factory('mail');

$mailer->send('hungrig@beispiel.com', $nachrichten_inhalt, $nachrichten_header);

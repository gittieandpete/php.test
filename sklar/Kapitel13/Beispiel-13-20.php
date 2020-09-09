$server = '{news.php.net/nntp:119}';
$newsgroup = 'php.announce';
$nntp = imap_open("$server$newsgroup", '', '', OP_ANONYMOUS);

$id_letzte_meldung = imap_num_msg($nntp);

$id_meldung = $id_letzte_meldung - 9;

print '<table>';
print "<tr><td>Betreff</td><td>Von</td><td>Datum</td></tr>\n";

while ($id_meldung <= $id_letzte_meldung) {
    $header = imap_header($nntp, $id_meldung);

    if (! $header->Size) { print "Keine Größe!"; }

    $email = $header->from[0]->mailbox . '@' .
        $header->from[0]->host;
    if ($header->from[0]->personal) {
        $email .= ' ('.$header->from[0]->personal.')';
    }

    $datum = date('d/m/Y H:i', $header->udate);

    print "<tr><td>$header->subject</td><td>$email</td>" .
        "<td>$datum</td></tr>\n";
$id_meldung++;
}
print '</table>';

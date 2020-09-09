$xml['version'] = '6.3';
$xml->channel->title = strtoupper($xml->channel->title);

for ($i = 0; $i < 3; $i++) {
    $xml->channel->item[$i]->link = str_replace('speisekarte.beispiel.com',
        'abendessen.beispiel.org', $xml->channel->item[$i]->link);
}

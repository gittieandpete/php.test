foreach ($xml->channel->item as $item) {
    print "Titel: " . utf8_decode($item->title) . "\n";
}

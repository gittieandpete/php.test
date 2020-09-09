foreach ($xml->channel->item[0] as $element_name => $inhalt) {
    print "$element_name ist" . utf8_decode($inhalt) . "\n";
}

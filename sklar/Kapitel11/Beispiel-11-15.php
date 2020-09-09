<?php
$xml = simplexml_load_file('http://rss.news.yahoo.com/rss/oddlyenough');

print "<ul>\n";
foreach ($xml->channel->item as $item) {
    print "<li>$item->title</li>\n";
}
print "</ul>";
?>
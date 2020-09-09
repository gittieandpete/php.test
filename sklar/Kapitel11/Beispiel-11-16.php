$xml = simplexml_load_file('http://rss.news.yahoo.com/rss/oddlyenough');
$xml->asXML('seltsam.xml');

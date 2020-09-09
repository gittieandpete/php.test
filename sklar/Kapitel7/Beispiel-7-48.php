$treffer = $db->getAll('SELECT gerichtname, preis FROM gerichte
                        WHERE gerichtname LIKE ?',
                       array($_POST['gerichtsuche']));

$db->query('UPDATE gerichte SET preis = 1 WHERE gerichtname LIKE ?',
           array($_POST['gerichtname']));

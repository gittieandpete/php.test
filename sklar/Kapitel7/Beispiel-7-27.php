$db->query('INSERT INTO gerichte (gerichtname) VALUES (?)',
    array($_POST['neuer_gerichtname']));

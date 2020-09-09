$db->query('INSERT INTO gerichte (gerichtname,preis,ist_scharf) VALUES (?,?,?)',
           array($_POST['new_gerichtname'], $_POST['neuer_preis'],
                 $_POST['ist_scharf']));

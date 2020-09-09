$db->query("INSERT INTO gerichte (gerichtname) 
            VALUES ('$_POST[neuer_gerichtname]')");

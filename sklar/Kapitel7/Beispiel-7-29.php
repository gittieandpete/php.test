$gericht_id = $db->nextID('gerichte');
$db->query("INSERT INTO orders (gericht_id, gerichtname, preis, ist_scharf)
    VALUES ($gericht_id, 'Frittierter Tofu', 1.50, 0)");

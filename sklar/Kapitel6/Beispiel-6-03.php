<form method="POST" action="katalog.php">
<input type="text" name="produkt_id">
<select name="kategorie">
<option value="topflappen">Topflappen</option>
<option value="bratpfanne">Bratpfanne</option>
<option value="lampe">Küchenlampe</option>
</select>
<input type="submit" name="absenden">
</form>
Hier sind die übermittelten Werte:

produkt_id: <?php print $_POST['produkt_id']; ?>
<br/>
kategorie: <?php print $_POST['kategorie']; ?>

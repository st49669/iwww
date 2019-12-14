<?php
if($_SESSION["Role"] == "Admin"){
	$conn = Conn::getPdo();
	$stmt = $conn->query("SELECT Produkt.ID, Produkt.Nazev, Cena, Skladem, Vyrobce.Nazev as NazVyr 
	FROM Produkt INNER JOIN Vyrobce on Produkt.Vyrobce_ID=Vyrobce.ID ORDER BY Produkt.ID DESC"); //produkty s vyrobceb
	echo '<h1>Seznam produktů:</h1><hr />
	<table class="btn" border="1px">
		<tr>
			<th>Operace</th>
			<th>Název</th>
			<th>Výrobce</th>
			<th>Cena</th>
			<th>Skladem</th>
		</tr>';
	foreach ($stmt as $item) { //plnění tabulky
		echo '
		<tr>
			<td>
				<a href="?page=admProd-uprav&id=' . $item["ID"] . '">Uprav</a>
				<a href="?page=admProd-smaz&id=' . $item["ID"] . '">Smaž</a>
			</td>
			<td>' . $item["Nazev"] . '</td >
			<td>' . $item["NazVyr"] . '</td>
			<td>' . $item["Cena"] . '</td>
			<td>'; if($item["Skladem"] < 1)
				echo "NE";
			 else 
				echo "ANO"; echo'</td>
		</tr>';
	}
	echo '</table><hr />'; ?>
<div class="btn">
<strong><a href="<?= BASE_URL ."?page=admProd-vloz" ?>">---&gt; Přidat další produkt &lt;---</a></strong>
</div>
<?php 
} else {
	die("Přístup zamítnut");
}
?>

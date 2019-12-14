 <?php
if($_SESSION["ID"] == $_GET["rel"]){ //kontrola ID relace vůči očekávané
	$conn = Conn::getPdo();
	echo '<h1>Položky objednávky</h1><hr />
	<table class="btn">
		<tr>
			<th>Název produktu</th>
			<th>Cena [Kč/ks]</th>
			<th>Množství</th>
			<th>Cena celkem</th>
		</tr>';
	$id2 = $_GET['id'];
	$stmt = $conn->query("SELECT Produkt.ID, Produkt.Nazev, rel_objednavka_produkt.Kusu, Produkt.Cena FROM rel_objednavka_produkt,Produkt 
	WHERE rel_objednavka_produkt.Objednavka_ID='$id2' AND Produkt.ID=rel_objednavka_produkt.Produkt_ID");
	foreach ($stmt as $item) { //projít položky v relační tabulce M:N
	echo '<tr>
			<td>' . $item["Nazev"] . '</td>
			<td>' . $item["Cena"] . '</td>
			<td>' . $item["Kusu"] . '</td>
			<td>' . ($item["Kusu"]*$item["Cena"]) . '</td >
	  </tr>';

	}
	echo '</table><hr />
	<div class="btn">';?>
	<strong><a href="<?= BASE_URL . "?page=meObjednavky" ?>">---&gt; Zpět &lt;---</a></strong>
	</div>
<?php
} else {
	die("Přístup zamítnut");
}?>
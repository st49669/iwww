<?php 
if($_SESSION["Role"] == "Admin"){
	$conn = Conn::getPdo();
	echo ' 
	<h1>Položky objednávky</h1><hr />
	<table class="btn">
		<tr>
			<th>Název produktu</th>
			<th>Cena [Kč/ks]</th>
			<th>Množství</th>
			<th>Cena celkem</th>
		</tr>';
	$id2 = $_GET['id'];
	$stmt = $conn->query("SELECT Produkt.ID, Produkt.Nazev, Kusu, AktCena FROM
	rel_objednavka_produkt INNER JOIN Produkt ON rel_objednavka_produkt.Produkt_ID = Produkt.ID
	WHERE rel_objednavka_produkt.Objednavka_ID='$id2'"); //položky v objednávce, včetně názvů a pouze pro danou objednávku
	foreach ($stmt as $item) {
		echo '   
	   <tr>
		<td>' . $item["Nazev"] . '</td>
		<td>' . $item["AktCena"] . '</td>
		<td>' . $item["Kusu"] . '</td>
		<td>' . ($item["Kusu"]*$item["AktCena"]) . '</td>
	  </tr>';
	}
	echo '</table>
	<hr />
	<div class="btn">'; ?>
	<strong><a href="<?= BASE_URL . "?page=admPlat" ?>">---&gt; Zpět &lt;---</a></strong>
	</div>
	<?php
} else {
	die("Přístup zamítnut");
}
?>
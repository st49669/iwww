<?php
if($_SESSION["Role"] == "Admin"){
	$conn = Conn::getPdo();
	$stmt1 = $conn->prepare("DELETE FROM rel_Objednavka_Produkt WHERE Objednavka_ID = :id"); //nejdřív vymazat z M:N objednávek produktů
	$stmt1->bindParam("id", $_GET["id"]);
	$stmt1->execute();
	$stmt = $conn->prepare("DELETE FROM Objednavka WHERE ID = :id"); //pak vymazat z objednávek
	$stmt->bindParam("id", $_GET["id"]);
	$stmt->execute();
	echo '<h1>Objednávka smazána</h1><hr />';
} else {
	die("Přístup zakázán");
}
?>
<div class="btn">
	<strong><a href="<?= BASE_URL ."?page=admPlat" ?>">---&gt; Zpět &lt;---</a></strong>
</div>


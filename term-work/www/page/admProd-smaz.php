<?php
if($_SESSION["Role"] == "Admin"){
$conn = Conn::getPdo();

$stmt = $conn->prepare("DELETE FROM Produkt WHERE ID = :id");
$stmt->bindParam("id", $_GET["id"]);
$stmt->execute();
echo '<h1>Produkt smazán</h1><hr />
<div class="btn">
<strong>'; ?>
<a href="<?= BASE_URL ."?page=admProd" ?>">---&gt; Zpět &lt;---</a></strong>
</div>

<?php
} else {
	die("Přístup zamítnut");
}
?>


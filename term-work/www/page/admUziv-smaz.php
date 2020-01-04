<?php
if($_SESSION["Role"] == "Admin"){ //zabránit přístupu neAdminům
	if ($_GET["id"] != 1){
		$conn = Conn::getPdo();
		$stmt = $conn->prepare("DELETE FROM Uzivatel WHERE ID=:id AND Role_ID!=0"); //zabránit smazání hl.admina
		$stmt->bindParam("id", $_GET["id"]);
		$stmt->execute();
		echo '<h1>Uživatel smazán</h1><hr />'; ?>
		<div class="btn">
			<strong><a href="<?= BASE_URL ."?page=admPlat" ?>">---&gt; Zpět &lt;---</a></strong>
		</div>
	<?php
	}else{
		echo '<h1>Tohoto uživatele nelze smazat...</h1><hr />'?>
		<div class="btn">
			<strong><a href="<?= BASE_URL ."?page=admUziv" ?>">---&gt; Zpět &lt;---</a></strong>
		</div>
<?php
	}
} else {
	die("Přístup zamítnut");
}
?>



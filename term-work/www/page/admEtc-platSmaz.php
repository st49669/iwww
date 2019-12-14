<?php
if ($_GET["id"] != 1){
	$conn = Conn::getPdo();
	$stmt = $conn->prepare("DELETE FROM Platba WHERE ID = :id");
	$stmt->bindParam("id", $_GET["id"]);
	$stmt->execute();
	echo '<h1>Typ platby smazán</h1><hr />'; ?>
	<div class="btn">
		<strong><a href="<?= BASE_URL ."?page=admEtc" ?>">---&gt; Zpět &lt;---</a></strong>
	</div>
<?php
}else{
	echo '<h1>Smazání se nezdařilo nebo tento typ platby nelze vymazat.</h1><hr />'?>
	<div class="btn">'
		<strong><a href="<?= BASE_URL ."?page=admEtc" ?>">---&gt; Zpět &lt;---</a></strong>
	</div>
<?php
}
?>
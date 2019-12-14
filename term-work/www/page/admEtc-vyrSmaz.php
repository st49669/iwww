<?php
if (isset($_GET["id"]){
	$conn = Conn::getPdo();
	$stmt = $conn->prepare("DELETE FROM Vyrobce WHERE ID = :id");
	$stmt->bindParam("id", $_GET["id"]);
	$stmt->execute();
	echo '<h1>Výrobce smazán</h1><hr />'; ?>
	<div class="btn">
		<strong><a href="<?= BASE_URL ."?page=admEtc" ?>">---&gt; Zpět &lt;---</a></strong>
	</div>
<?php
}else{
	echo '<h1>Smazání se nezdařilo.</h1><hr />'?>
	<div class="btn">'
		<strong><a href="<?= BASE_URL ."?page=admEtc" ?>">---&gt; Zpět &lt;---</a></strong>
	</div>
<?php
}
?>
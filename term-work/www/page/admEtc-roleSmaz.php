<?php
if ($_GET["id"] != 0){
	$conn = Conn::getPdo();
	$stmt = $conn->prepare("DELETE FROM Role WHERE ID = :id");
	$stmt->bindParam("id", $_GET["id"]);
	$stmt->execute();
	echo '<h1>Role smazána.</h1><hr />'; ?>
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
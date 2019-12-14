<?php
if($_SESSION["Role"] == "Admin"){
	echo '<h1>Exportování...</h1><hr />';
	if(!isset($_GET["tab"])) die("Neplatný název");
	$conn = Conn::getPdo();
	$tab = $_GET["tab"];
	$query = "SELECT * FROM " . $tab;
	$stmt = $conn->query($query);
	$json = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
	$e = "";
	try {
		$fo = fopen('./data/'.$tab.'.json', 'w');
		fwrite($fo, $json);
		fclose($fo);
		echo '<h3>Export dat dokončen.</h3>';
		echo '<strong>Typ: </strong>'. $tab;
		echo '<div class="btn">'; ?>
				<strong><a href="data/<?= $tab ?>.json">---&gt; Zobrazit výsledek &lt;---</a></strong>
		</div>
	<?php
	}catch(Exception $ex){
		echo "<h3>Při exportu došlo k chybám:</h3>";
		print($ex->getMessage());
	}
} else {
	die("Přístup zakázán");
}
?>
<hr /><div class="btn">
	<strong><a href="<?= BASE_URL ."?page=data" ?>">---&gt; Zpět &lt;---</a></strong>
</div>


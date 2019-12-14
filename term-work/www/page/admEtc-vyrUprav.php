<?php
if($_SESSION["Role"] == "Admin" && isset($_GET["id"])){
	echo '<h1>Úprava výrobce</h1><hr />';
	$conn = Conn::getPdo();
	$e = "";
	$nazev = "";
	$regTry = true;

	if (!empty($_POST)) {
		
		if (empty($_POST["Nazev"])) {
        $e .= "<p>Nebyl zadán název.</p>";
		$regTry = false;
		}
		if (empty($e)) {
			$stmt = $conn->prepare("UPDATE Vyrobce SET Nazev=:Nazev WHERE ID=:ID");
			$stmt->bindParam(':ID', $_GET["id"]);
			$stmt->bindParam(':Nazev', $_POST["Nazev"]);
			$stmt->execute();
		}
	}

	$stmt = $conn->prepare("SELECT * FROM Vyrobce WHERE ID=:ID");
	$stmt->bindParam(':ID', $_GET["id"]);
	$stmt->execute();
	$data = $stmt->fetch();

	$nazev = $data["Nazev"];
	?>
	<form method="post">
		<input type="text" name="Nazev" value="<?php echo $nazev?>" placeholder="Název"/><br /><br />
		<input type="submit" name="subm" value="Upravit"/>
	</form>
	<?php
	if (!empty($e)) {
		echo '<hr /><h3>Úprava selhala.</h3><div class="center-wrapper">'.$e.'</div>';
	}  else if ($regTry && $_SERVER['REQUEST_METHOD'] == 'POST') {
		header("Location:" . BASE_URL . "?page=admEtc");
	}
} else {
	die("Přístup zakázán");
}
?>
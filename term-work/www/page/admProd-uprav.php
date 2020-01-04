<h1>Upravit produkt</h1><hr />
<?php
if($_SESSION["Role"] == "Admin"){
	$conn = Conn::getPdo();

	$naz = "";
	$popis = "";
	$cen = "";
	$skla = "";
	$vyr = "";
	$e = "";
	$regTry = true;

	if (!empty($_POST)) {
		if (empty($_POST["Nazev"])) {
			$e .= "<p>Chybí název produktu.</p>";
			$regTry = false;
		}
		if (empty($_POST["Cena"])) {
			$e .= "<p>Chybí cena produktu.</p>";
			$regTry = false;
		}

		if (empty($e)) {
			$stmt = $conn->prepare("UPDATE Produkt SET Nazev=:Nazev, Popis=:Popis, Cena=:Cena, Skladem=:Skladem, Vyrobce_ID=:Vyrobce_ID WHERE ID=:ID");
			$stmt->bindParam(':ID', $_GET["id"]);
			$stmt->bindParam(':Nazev', $_POST["Nazev"]);
			$stmt->bindParam(':Popis', $_POST["Popis"]);
			$stmt->bindParam(':Cena', $_POST["Cena"]);
			if (isset($_POST['Skladem']) ){
				$skladem = ($_POST['Skladem'] != 0);
				$stmt->bindParam(':Skladem', $skladem);
			} 
			$stmt->bindParam(':Vyrobce_ID', $_POST["Vyrobce"]);
			$stmt->execute();
		}
		if (!empty($e)) {
			echo '<hr /><h3>Úprava selhala.</h3><div class="center-wrapper">'.$e.'</div>';
		}  else if ($regTry && $_SERVER['REQUEST_METHOD'] == 'POST') {
			header("Location:" . BASE_URL . "?page=admProd");
		}
	}

	$stmt = $conn->prepare("SELECT * FROM Produkt WHERE ID=:ID");
	$stmt->bindParam(':ID', $_GET["id"]);
	$stmt->execute();
	$data = $stmt->fetch();

	/* Vyplnění správně zadaných parametrů v případě chyby při odeslání*/
	$naz = $data["Nazev"];
	$popis = $data["Popis"];
	$cen = $data["Cena"];
	$skla = $data["Skladem"];
	$vyr = $data["Vyrobce_ID"];

	?>
	<form method="post">
			<input type="text" name="Nazev" placeholder="Název produktu" value="<?= $naz; ?>"/><br /><br />
			Výrobce: <select name="Vyrobce">
				<?php
				$stmt = $conn->query("SELECT * FROM Vyrobce");
				foreach ($stmt as $item) { 
					if($item["ID"]==$vyr){?>
							<option value="<?php echo $item["ID"] ?>" selected>
							<?php echo $item["Nazev"] ?>
						</option>
					<?php } else { ?>
						<option value="<?php echo $item["ID"] ?>">
							<?php echo $item["Nazev"] ?>
						</option>
					<?php } ?>
				<?php } ?>
			</select><br /><br />
			<textarea name="Popis" rows="5" cols="21" placeholder="Volitelný popis produktu..."><?php echo $popis; ?></textarea><br /><br />
			<input type="number" name="Cena" placeholder="Cena v Kč" value="<?= $cen; ?>"/><br /><br />
			Skladem: <select name="Skladem">
				<option value="0" <?php if($skla == 0) echo "selected"; ?>>Ne</option>
				<option value="1" <?php if($skla == 1) echo "selected"; ?>>Ano</option>
			</select>
			<br /><br />
			<input type="submit" name="subm" value="Upravit produkt"/>
		</form>
		<?php
	
} else {
	die("Přístup zamítnut");
}
?>
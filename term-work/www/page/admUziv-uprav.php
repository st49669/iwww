<?php
if($_SESSION["Role"] == "Admin"){
	echo '<h1>Úprava uživatele</h1><hr />';
	$conn = Conn::getPdo();
	$e = "";
	$email = "";
	$secret = "";
	$naroz = "";
	$role;
	$regTry = true;

	if (!empty($_POST)) { //kontrola vyplnění
		
		if (empty($_POST["Email"])) {
			$e .= "<p>Chybí e-mail uživatele.</p>";
			$regTry = false;
		}
		if (empty($_POST["Secret"])) {
			$e .= "<p>Chybí heslo uživatele.</p>";
			$regTry = false;
		}
		if (empty($_POST["Narozeni"])) {
			$e .= "<p>Chybí datum narození.</p>";
			$regTry = false;
		}
		if (!isset($_POST["Role_ID"])) {
			$e .= "<p>Chybí Role uživatele</p>";
			$regTry = false;
		}
		if (empty($e)) {
			$stmt = $conn->prepare("UPDATE Uzivatel SET Secret=:Secret, Role_ID=:Role, DatumNarozeni=:Narozeni, Email=:Email WHERE ID=:ID");
			$stmt->bindParam(':ID', $_GET["id"]);
			$stmt->bindParam(':Narozeni', $_POST["Narozeni"]);
			$stmt->bindParam(':Email', $_POST["Email"]);
			$stmt->bindParam(':Role', $_POST["Role_ID"]);
			$stmt->bindParam(':Secret', $_POST["Secret"]);
			$stmt->execute();
		}
	}

	$stmt = $conn->prepare("SELECT * FROM Uzivatel WHERE ID=:ID");
	$stmt->bindParam(':ID', $_GET["id"]);
	$stmt->execute();
	$data = $stmt->fetch();
	/* nastavení vyplněních hodnot po chybném vyplnění*/
	$email = $data["Email"];
	$naroz = $data["DatumNarozeni"];
	$role = $data["Role_ID"];
	$secret = $data["Secret"];
	?>
	<form method="post">
		E-mail: <input type="text" name="Email" value="<?= $email; ?>"/><br /><br />
		Heslo: <input type="password" name="Secret" value="<?= $secret; ?>"/><br /><br />
		Dat. narození: <input type="date" name="Narozeni" value="<?= $naroz; ?>"/><br /><br />
		Role: <select name="Role_ID">
			<?php
			$stmt1 = $conn->query("SELECT * FROM Role"); //načítání seznamu rolí
			foreach ($stmt1 as $item) { 
				if($item["ID"]==$role){ // kterou roli vybrat? ?>
						<option value="<?php echo $item["ID"] ?>" selected>
						<?php echo $item["Nazev"] ?>
					</option>
				<?php } else { ?>
					<option value="<?php echo $item["ID"] ?>">
						<?php echo $item["Nazev"] ?>
					</option>
				<?php }?>
			<?php } ?>
		</select><br /><br />
		<input type="submit" name="subm" value="Upravit uživatele"/>
	</form>
	<?php
	if (!empty($e)) {
		echo '<hr /><h3>Úprava selhala.</h3><div class="center-wrapper">'.$e.'</div>';
	}  else if ($regTry && $_SERVER['REQUEST_METHOD'] == 'POST') {
		header("Location:" . BASE_URL . "?page=admUziv");
	}
} else {
	die("Přístup zamítnut");
}

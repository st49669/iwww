<?php
echo '<h1>Úprava účtu</h1><hr />';

if($_SESSION["ID"] == $_GET["id"]){ //ověření itentity uživatele
	$jm = "";
	$ps = "";
	$mail = "";
	$pw = "";
	$e = "";
	$regTry = true; //pomoc při kontrole údajů
	$conn = Conn::getPdo();

	if (!empty($_POST)) { //kontrola vyplnění údajů
		if (empty($_POST["Email"])) {
			$e .= "<p>Nebyl zadán e-mail.</p>";
			$regTry = false;
		}

		if (empty($_POST["pw"])) {
			$e .= "<p>Nebylo zadáno heslo<strong>*</strong>.</p>";
			$regTry = false;
		}
		
		if (empty($_POST["Jmeno"])) {
		   $e .= "<p>Nebyl zadáno jméno.</p>";
			$regTry = false;
		}
		
		if (empty($_POST["Prijmeni"])) {
			$e .= "<p>Nebylo zadáno příjmení.</p>";
			$regTry = false;
		}
		if (!empty($_POST["pw"]) && !Sha::getSha()->checkLength($_POST["pw"])){
			$e .= "<p>Zadané heslo musí mít alespoň 8 znaků a nejvýše 40 znaků.</p>";
			$regTry = false;
		}

		if (empty($e)) { //údaje vyplněny, lze provést update		
			$shaPw = Sha::getSha()->hashPw($_POST["pw"]);
			$stmt1 = $conn->prepare("UPDATE Uzivatel SET Jmeno=:Jmeno, Prijmeni=:Prijmeni, Email=:Email, Secret=:Secret WHERE ID=:id");
			$stmt1->bindParam(':id', $_GET["id"]);
			$stmt1->bindParam(':Jmeno', $_POST["Jmeno"]);
			$stmt1->bindParam(':Prijmeni', $_POST["Prijmeni"]);
			$stmt1->bindParam(':Email', $_POST["Email"]);
			$stmt1->bindParam(':Secret', $shaPw);
			$stmt1->execute();
			$regTry = true;
		}
		
		if (!empty($e)) { //vypiš chyby
			echo "<h3>Úprava účtu selhaha. Zkontrolujte správnost zadaných údajů.</h3>"."<div class=\"center-wrapper\">".$e."</div>";
		} else if ($regTry && $_SERVER['REQUEST_METHOD'] == 'POST') {
			header("Location:" . BASE_URL . "?page=mujUcet&id=".$_SESSION['ID']); //vrať se na stránku
		}
	}
	$stmt2 = $conn->prepare("SELECT * FROM Uzivatel WHERE ID=:id"); //pro účely předvyplnení formuláře aktuálními hodnotami
	$stmt2->bindParam(':id', $_GET["id"]);
	$stmt2->execute();
	$item = $stmt2->fetch();

	$jm = $item["Jmeno"];
	$ps = $item["Prijmeni"];
	$mail = $item["Email"];

	?>

	<div class="center-wrapper">
		<form method="post">
			<table class="regtab">
				<input type="hidden" name="id" value="<?= $_GET["id"]; ?>" />
				<tr>
				<th class="rig">Jméno:</th>
				<td><input type="text" name="Jmeno" placeholder="Jméno" value="<?= $jm; ?>"/></td>
				</tr><tr>
				<th class="rig">Příjmení:</th>
				<td><input type="text" name="Prijmeni" placeholder="Příjmení" value="<?= $ps; ?>"/></td>
				</tr><tr>
				<th class="rig">E-mail:</th>
				<td><input type="email" name="Email" placeholder="vase@emailova.adresa" value="<?= $mail; ?>"/></td>
				</tr><tr>
				<th class="rig">Heslo:</th>
				<td><input type="password" name="pw" placeholder="Zadejte původní nebo nové heslo*" value="<?= $pw; ?>"/></td>
				</tr><tr><td colspan="2"></td>
				</tr><tr>
					<th class="cen" colspan="2"><input type="submit" name="subm" value="Aktualizovat"/></th>
				</tr>
			</table>
		</form>
	</div>

	<?php
	echo '<hr /><strong>*</strong>Pro aktualizaci údajů je nutné zadat i heslo.
	 <strong>Pokud heslo nechcete měnit, zadejte své původní</strong>.';
	
} else {
	die('Přístup zakázán');
}
?>
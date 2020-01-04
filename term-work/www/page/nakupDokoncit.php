<?php
if(Auth::getAuth()->hasId()){

	$e = ""; //chyby
	if (!isset($_GET['cena'])) { //předání ceny
		$e .= "cena;";
	}

	if (!isset($_GET['doprava'])) { //předání dpravy
		$e .= "doprava;";
	}

	if (!isset($_GET['platba'])) { //předání platby
		$e .= "platba;";
	}
	if (empty($e)) {
		
			$conn = Conn::getPdo();
			$stmt = $conn->prepare("INSERT INTO Objednavka (CelkovaCena, DatumVytvoreni, Uzivatel_ID, Doprava_ID, Platba_ID) 
		VALUES (:cenaCelkem, NOW(), :user_id, :doprava_id, :platba_id)");
			$stmt->bindParam(':user_id', $_SESSION["ID"]);
			$stmt->bindParam(':cenaCelkem', $_GET['cena']);
			$stmt->bindParam(':doprava_id', $_GET['doprava']);
			$stmt->bindParam(':platba_id', $_GET['platba']);
			$stmt->execute();
			$stmt1 = $conn->query("SELECT MAX(ID) FROM Objednavka");
			$aktObj = $stmt1->fetch()['MAX(ID)'];
			
			foreach ($_SESSION['kosik'] as $item => $mnoz) {
				$stmt3 = $conn->query("SELECT Cena FROM Produkt WHERE ID='$item'");
				$aktCena = $stmt3->fetch()['Cena'];
				$stmt2 = $conn->prepare("INSERT INTO rel_Objednavka_Produkt (Kusu, Objednavka_ID, Produkt_ID, AktCena)
			VALUES (:mnozstvi,:obj,:prod,:cena)");
				$stmt2->bindParam(':prod', $item);
				$stmt2->bindParam(':obj', $aktObj);
				$stmt2->bindParam(':mnozstvi', $mnoz['mnoz']);
				$stmt2->bindParam(':cena', $aktCena);
				$stmt2->execute();

			}
		echo '<h1>Objednávka proběhla úspěšně!</h1><hr />
		<div class="card">'; 
		unset($_SESSION['kosik']); //po úspěšné objednávce vyprázdnit košík
		?>
				<a href='<?= BASE_URL . "?page=default" ?>'>
					<div>Pokračujte kliknutím zde</div>
				</a>
			</div>
	<?php
	} else {
		echo '<script>alert("Objednávka selhala, zkuste to ještě jednou.");</script>
		<h1>Omlováme se za komplikace.</h1><hr />
		<div class="card">'; ?>
				<a href='<?= BASE_URL . "?page=nakupKosik" ?>'>
					<div>Návrat do košíku</div>
				</a>
			</div>
<?php }
} else {
	die("Přístup zamítnut");
}
?>

<?php

if($_SESSION["Role"] == "Admin"){
	echo '<h1>Potvrzení plateb</h1><hr />';
	$conn = Conn::getPdo();

	if (isset($_GET["action"])) { //pro přenastavování zaplaceno
		$query = "UPDATE Objednavka SET Zaplaceno=:zapl, DatumPlatby=NULL WHERE ID=:ID";
		$zapl = false;
			if ($_GET["action"] == "potvrdit") { //chci potvrdit zaplacení
				$zapl = true;
				$query = "UPDATE Objednavka SET Zaplaceno=:zapl, DatumPlatby=NOW() WHERE ID=:ID";
			} 
			$stmt1 = $conn->prepare($query);
			$stmt1->bindParam(':ID', $_GET["id"]);
			$stmt1->bindParam(':zapl', $zapl);
			$stmt1->execute();
	}

	$stmt = $conn->query("SELECT objednavka.ID, objednavka.CelkovaCena, Objednavka.DatumVytvoreni, Objednavka.DatumPlatby,
	Uzivatel.Email, CONCAT(Uzivatel.Jmeno,' ',Uzivatel.Prijmeni) AS CeleJmeno, Objednavka.Zaplaceno 
	FROM Objednavka,Uzivatel WHERE Uzivatel.ID=Objednavka.Uzivatel_ID ORDER BY Objednavka.Zaplaceno, Objednavka.DatumVytvoreni ASC"); //tabulka objednávek
	echo '<table class="btn">';
		echo '
		<tr>
			<th>Operace</th>
			<th>Datum platby</th>
			<th>Datum vytvoření</th>
			<th>Jméno uživatele</th>
			<th>Email</th>
			<th>Cena</th>
		</tr>';

	foreach ($stmt as $item) {
		echo '<tr>
			<td>'; 
			if(!empty($item["Zaplaceno"])){echo '<a href="?page=admPlat&action=zrusit&id=' . $item["ID"] . '">Zrušit platbu</a>
				&nbsp<a href="?page=admPlat-polozky&id=' . $item["ID"] . '">Položky</a>
				&nbsp<a href="?page=admPlat-smaz&id=' . $item["ID"] . '">Odstranit</a>
	
			';} else { echo '
					<a href="?page=admPlat&action=potvrdit&id=' . $item["ID"] . '">Potvrdit platbu</a>
					&nbsp<a href="?page=admPlat-polozky&id=' . $item["ID"] . '">Položky</a>
					&nbsp<a href="?page=admPlat-smaz&id=' . $item["ID"] . '">Odstranit</a>
			';}
			echo '</td>
			<td>'; if(empty($item["DatumPlatby"])) echo 'NEPLACENO</td>'; else echo $item["DatumPlatby"].'</td>';
			echo '<td>' . $item["DatumVytvoreni"] . '</td>
			<td> ' . $item["CeleJmeno"] . '</td>
			<td> ' . $item["Email"] . '</td>
			<td>' . $item["CelkovaCena"] . '</td>
		</tr>';
	}
	echo '</table>';
} else {
	die("Přístup zakázán");
}

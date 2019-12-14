
<h1>Seznam uživatelů</h1><hr />
<p>

<?php 
if($_SESSION["Role"] == "Admin"){ //zabránit přístupu neAdminům
	$conn = Conn::getPdo();
	$order = "ID"; //pomocník pro řazení
	$stmt1 = $conn->query("SELECT `COLUMN_NAME` as Sloupce FROM `INFORMATION_SCHEMA`.`COLUMNS` 
	WHERE `TABLE_SCHEMA`='www' AND `TABLE_NAME`='Uzivatel'"); //názvy sloupců tabulky Uzivatel
		echo '<form action="" method="post">
			Řadit dle:
			<select name="Radit">';
			$sel = $_POST["Radit"]; //Název vybraného sloupce
			$s = ""; //selected
			foreach ($stmt1 as $item) {  
				if($sel == $item["Sloupce"]){ //kterou položku v seznamu vybrat po odeslání
					$order = $item["Sloupce"]; 
					$s = "selected";
				}
				echo'<option value="'. $item["Sloupce"] .'" ' . $s .'>
						'; echo $item["Sloupce"].'
					</option>
					';
					$s = "";
			};
			echo '
			</select>
				Sestupně:';
				if(isset($_POST["Sestupne"]) && $_POST["Sestupne"]=="A"){ //zaškrtnout "Sestupně"?
					$order .= " DESC";
					echo '<input type="checkbox" name="Sestupne" method="Post" value="A" checked/>';
				} else {
					echo '<input type="checkbox" name="Sestupne" method="Post" value="A"/>';
				}
				
		echo '<input type="submit" name="subm" value="Filtrovat"/>
		</form>
		</p>';
	$query = "SELECT * from Uzivatel ORDER BY " . $order; //sestavování dotazu
	$stmt = $conn->query($query);
	/* sestavení tabulky */
	echo '<table class="btn">';
	echo '
		<tr>
			<th>Operace</th>
			<th>ID</th>
			<th>Jméno</th>
			<th>Příjmení</th>
			<th>Narození</th>
			<th>E-mailová adresa</th>
			<th>Role</th>
			<th>Registrace</th>
		</tr>';

	foreach ($stmt as $item) {
		echo '
		<tr>
			<td>
				<a href="?page=admUziv-uprav&id=' . $item["ID"] . '">Uprav</a>
				<a href="?page=admUziv-smaz&id=' . $item["ID"] . '">Smaž</a>
			</td>
			<td>'.$item["ID"].'</td>
			<td>'.$item["Jmeno"].'</td>
			<td>'.$item["Prijmeni"].'</td>
			<td>'.$item["DatumNarozeni"].'</td>
			<td>'.$item["Email"].'</td>
			<td>'.$item["Role_ID"].'</td>
			<td>'.$item["DatumRegistrace"].'</td>
		</tr >';
	}
	echo '</table><hr />';
} else {
	die("Přístup zamítnut");
}
?>
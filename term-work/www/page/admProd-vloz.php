<h1>Přidej produkt</h1>
<hr />
<?php
if($_SESSION["Role"] == "Admin"){
	$e = "";
	$regTry = true;
	$conn = Conn::getPdo();
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
			
			$vyrobce = 1;
			$stmt = $conn->prepare("INSERT INTO Produkt (Nazev, Popis, Cena, Skladem, Vyrobce_ID)
		VALUES (:Nazev, :Popis, :Cena, :Skladem, :Vyrobce_ID)");
			$stmt->bindParam(':Nazev', $_POST["Nazev"]);
			$stmt->bindParam(':Popis', $_POST["Popis"]);
			$stmt->bindParam(':Cena', $_POST["Cena"]);
			if (isset($_POST['Skladem']) ){
				$skladem = ($_POST['Skladem'] != 0);
				$stmt->bindParam(':Skladem', $skladem);
			} 
			if (isset($_POST['Vyrobce_ID'])){
				$vyrobce = $_POST['Vyrobce_ID'];
			}
			$stmt->bindParam(':Vyrobce_ID', $vyrobce);
			$stmt->execute();
			$regTry = true;
		}
		if (!empty($e)) {
			echo "<hr /><h3>Produkt nelze přidat.</h3>"."<div class=\"center-wrapper\">".$e."</div>";
		}  else if ($regTry && $_SERVER['REQUEST_METHOD'] == 'POST') {
			header("Location:" . BASE_URL . "?page=admProd");
		}
	}

	?>
    <form method="post">
        <input type="text" name="Nazev" placeholder="Název produktu"/><br /><br />
		Výrobce: <select name="Vyrobce">
            <?php
            $stmt = $conn->query("SELECT * FROM Vyrobce");

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo $row["ID"] ?>">
                    <?php echo $row["Nazev"] ?>
                </option>
            <?php } ?>
        </select><br /><br />
		<textarea name="Popis" rows="5" cols="21" placeholder="Volitelný popis produktu..."></textarea><br /><br />
        <input type="number" name="Cena" placeholder="Cena v Kč"/><br /><br />
        Skladem: <select name="Skladem">
			<option value="0">Ne</option>
			<option value="1">Ano</option>
		</select>
		<br /><br />
        <input type="submit" name="subm" value="Vložit"/>
    </form>
	<hr />
	<div class="btn">
	<strong><a href="<?= BASE_URL ."?page=admProd" ?>">---&gt; Zpět &lt;---</a></strong>
	</div>

<?php
} else {
	die("Přístup zamítnut");
}
?>


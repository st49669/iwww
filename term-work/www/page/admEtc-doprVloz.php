<?php
echo "<h1>Nový typ dopravy</h1><hr />";
$e = "";
$regTry = true;
if (!empty($_POST)) {
	
	if (empty($_POST["Nazev"])) {
        $e .= "<p>Nebyl zadán název.</p>";
		$regTry = false;
    }
    if (empty($_POST["Cena"])) {
        $e .= "<p>Nebyla zadána cena.</p>";
		$regTry = false;
    }
	if (!empty($e)) {
    echo "<h3>Přidání položky selhalo.</h3>"."<div class=\"center-wrapper\">".$e."</div>";
    
	} else if ($regTry && $_SERVER['REQUEST_METHOD'] == 'POST') {
		header("Location:" . BASE_URL . "?page=admEtc");
	}
}

if ($regTry && $_SERVER['REQUEST_METHOD'] == 'POST' && empty($e)) {
		$conn = Conn::getPdo();
		$role = 1;
        $stmt = $conn->prepare("INSERT INTO Doprava (Nazev, Cena) VALUES (:Nazev, :Cena)");
        $stmt->bindParam(':Nazev', $_POST["Nazev"]);
        $stmt->bindParam(':Cena', $_POST["Cena"]);
        $stmt->execute();
}
?>

<div class="center-wrapper">
	<form method="post">
		<table class="regtab">
			<tr>
				<th class="rig"><strong>Název:</strong></th><td><input type="text" name="Nazev" placeholder="Název"/></td>
			</tr><tr>
				<th class="rig"><strong>Cena:</strong></th><td><input type="number" name="Cena"/></td>
			</tr><tr><th colspan="2">&nbsp;</th></tr>
				<th class="cen" colspan="2"><input type="submit" name="submitUser" value="Vložit"/></td>
			</tr>
		</table>
	</form>
</div>
<hr />
<?php
echo "<h1>Nová role</h1><hr />";
$e = "";
$regTry = true;
if (!empty($_POST)) {
	
	if (empty($_POST["Nazev"])) {
        $e .= "<p>Nebyl zadán název.</p>";
		$regTry = false;
    }
}

if ($regTry && $_SERVER['REQUEST_METHOD'] == 'POST' && empty($e)) {
		$conn = Conn::getPdo();
		$role = 1;
        $stmt = $conn->prepare("INSERT INTO Role (Nazev) VALUES (:Nazev)");
        $stmt->bindParam(':Nazev', $_POST["Nazev"]);
        $stmt->execute();
}
?>

<div class="center-wrapper">
	<form method="post">
		<table class="regtab">
			<tr>
				<th class="rig"><strong>Název:</strong></th><td><input type="text" name="Nazev" placeholder="Název"/></td>
			</tr><tr><th colspan="2">&nbsp;</th></tr>
				<th class="cen" colspan="2"><input type="submit" name="submitUser" value="Vložit"/></td>
			</tr>
		</table>
	</form>
</div>
<hr />

<?php
if (!empty($e)) {
    echo "<h3>Přidání položky selhalo.</h3>"."<div class=\"center-wrapper\">".$e."</div>";
    
} else if ($regTry && $_SERVER['REQUEST_METHOD'] == 'POST') {
    header("Location:" . BASE_URL . "?page=admEtc");
}
?>
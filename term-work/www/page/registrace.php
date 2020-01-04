<h1>Registrujte se...</h1>
<hr />
<?php
$e = ""; //chyby
$regTry = true;
$jmeno = "";
$pw = "";
$prijm = "";
$dat = NULL;
$mail = "";

if (!empty($_POST)) { //kontrola vyplnění položek
	if (empty($_POST["mail"])) {
        $e .= "<p>Nebyl zadán e-mail.</p>";
		$regTry = false;
    }
	if (empty($_POST["pw"])) {
        $e .= "<p>Nebylo zadáno heslo.</p>";
		$regTry = false;
    }
	
    if (!empty($_POST["pw"]) && !Sha::getSha()->checkLength($_POST["pw"])){
		$e .= "<p>Zadané heslo musí mít alespoň 8 znaků a nejvýše 40 znaků.</p>";
		$regTry = false;
	}
	
    if (empty($_POST["Jmeno"])) {
        $e .= "<p>Nebylo zadáno jméno.</p>";
		$regTry = false;
    }
	
	if (empty($_POST["Prijmeni"])) {
       $e .= "<p>Nebylo zadáno příjmení.</p>";
	   $regTry = false;
    }
	
	if (empty($_POST["DatumNarozeni"])) {
        $e .= "<p>Nebylo zadáno datum narození.</p>";
		$regTry = false;
    }


  /*pro vplnění dříve zadaných údajů*/
	$jmeno = $_POST["Jmeno"];
	$pw = $_POST["pw"];
	$prijm = $_POST["Prijmeni"];
	$dat = $_POST["DatumNarozeni"];
	$mail = $_POST["mail"]; 
}

if ($regTry && $_SERVER['REQUEST_METHOD'] == 'POST' && empty($e)) { //kontrola, jestli splněny podmínky pro registraci
		$role = 1;
		$shaPw = Sha::getSha()->hashPw($_POST["pw"]);
		$conn = Conn::getPdo();
        $stmt = $conn->prepare("INSERT INTO Uzivatel (Jmeno, Prijmeni, DatumNarozeni, Email, Secret, Role_ID, DatumRegistrace)
    VALUES (:Jmeno, :Prijmeni, :DatumNarozeni, :Email, :Secret , :role, NOW())");
        $stmt->bindParam(':Jmeno', $_POST["Jmeno"]);
        $stmt->bindParam(':Prijmeni', $_POST["Prijmeni"]);
        $stmt->bindParam(':DatumNarozeni', $_POST["DatumNarozeni"]);
        $stmt->bindParam(':Email', $_POST["mail"]);
        $stmt->bindParam(':Secret', $shaPw);
		$stmt->bindParam(':role', $role);
        $stmt->execute();
}
if (!empty($e)) {
    echo "<h3>Registrace selhala. Zkontrolujte správnost zadaných údajů.</h3>"."<div class=\"center-wrapper\">".$e."</div>";
    
} else if ($regTry && $_SERVER['REQUEST_METHOD'] == 'POST') {
    header("Location:" . BASE_URL . "?page=regSucc");
}
?>

<div class="center-wrapper">
	<form method="post">
		<table class="regtab">
			<tr>
				<th class="rig"><strong>E-mail:</strong></th><td><input type="email" name="mail" value="<?= $mail ?>" placeholder="vase@emailova.adresa"/></td>
			</tr><tr>
				<th class="rig"><strong>Heslo:</strong></th><td><input type="password" name="pw" value="<?= $pw ?>" placeholder="Heslo"/></td>
			</tr><tr>
				<th class="rig"><strong>Jméno:</strong></th><td><input type="text" name="Jmeno" value="<?= $jmeno ?>" placeholder="Jméno"/></td>
			</tr><tr>
				<th class="rig"><strong>Příjmení:</strong></th><td><input type="text" name="Prijmeni" value="<?= $prijm ?>" placeholder="Příjmení"/></td>
			</tr><tr>
				<th class="rig"><strong>Datum narození:</strong><td></th><input type="date" value="<?= $dat ?>" name="DatumNarozeni" /></td>
			</tr><tr><th colspan="2">&nbsp;</th></tr>
				<th class="cen" colspan="2"><input type="submit" name="submitUser" value="Potvrdit registraci"/></td>
			</tr>
		</table>
	</form>
</div>
<hr />
<?php
echo'
<h1>Import uživatelů</h1><hr />
<form action="" Method="Post">
	<textarea name="Json" rows="10" cols="40" placeholder="Ponechte prázdné pro nahrání ze souboru ./data/Uzivatel.json"></textarea><br /><br />
	<input type="submit" name="subm" value="Importovat data"/>
</form>';
if($_SESSION["Role"] == "Admin"){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		try
		{
			$conn = Conn::getPdo();
			$query = '';
			$filename = "./data/Uzivatel.json";
			$data = "";
			if(isset($_POST["Json"]) && !empty($_POST["Json"])){
				$data = $_POST["Json"];
			} else {
				$data = file_get_contents($filename);
			}
			$array = json_decode($data, true); 
			foreach($array as $row) 
			{
				$query = "INSERT INTO Uzivatel(Jmeno, Prijmeni, DatumNarozeni, Email, Secret, Role_ID, DatumRegistrace) 
				VALUES ('".$row["Jmeno"]."', '".$row["Prijmeni"]."', '".$row["DatumNarozeni"]."', '".$row["Email"]."', '".$row["Secret"]."', '".$row["Role_ID"]."', '".$row["DatumRegistrace"]."')";
				$conn->query($query);
			}
			echo "<h3>Import dat proběhl v pořádku.</h3>";			
		} 
		catch(Exception $ex)
		{   
			echo "<h3>Při importu došlo k chybám:</h3>";
			print($ex->getMessage());
		}
	}
} else {
	die("Přístup zakázán");
}
	
?>


<hr /><div class="btn">
		<strong><a href="<?= BASE_URL ."?page=data" ?>">---&gt; Zpět &lt;---</a></strong>
</div>

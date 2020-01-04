<?php
if($_SESSION["Role"] == "Admin"){
	$conn = Conn::getPdo();
	$stmt = $conn->query("SELECT Produkt.ID as prodID, Produkt.Nazev, Cena, Skladem, Vyrobce.Nazev as NazVyr 
	FROM Produkt INNER JOIN Vyrobce on Produkt.Vyrobce_ID=Vyrobce.ID ORDER BY Produkt.ID DESC"); //produkty s vyrobceb
	echo '<h1>Seznam produktů:</h1><hr />
	<table class="btn" border="1px">
		<tr>
			<th>Operace</th>
			<th>ID<sup>*</sup></th>
			<th>Obrázek</th>
			<th>Název</th>
			<th>Výrobce</th>
			<th>Cena</th>
			<th>Skladem</th>
		</tr>';
	foreach ($stmt as $item) { //plnění tabulky
		echo '
		<tr>
			<td>
				<a href="?page=admProd-uprav&id=' . $item["prodID"] . '">Uprav</a>
				<a href="?page=admProd-smaz&id=' . $item["prodID"] . '">Smaž</a>
			</td>
			<td>' . $item["prodID"] . '</td>
			<td>'; if(file_exists("img/" . $item["prodID"]  . ".jpg"))
				echo "ANO";
			 else 
				echo "NE"; echo'</td>
			<td>' . $item["Nazev"] . '</td>
			<td>' . $item["NazVyr"] . '</td>
			<td>' . $item["Cena"] . '</td>
			<td>'; if($item["Skladem"] < 1)
				echo "NE";
			 else 
				echo "ANO"; echo'</td>
		</tr>';
	}
	echo '</table><hr />'; ?>
<div class="btn">
<strong><a href="<?= BASE_URL ."?page=admProd-vloz" ?>">---&gt; Přidat další produkt &lt;---</a></strong>
<hr />
<form method="post" enctype="multipart/form-data">
    Nahrát obrázek k produktu<strong><sup>*</sup></strong>:<br />
    <input type="file" name="fileToUpload" id="fileToUpload"/><br />
    <input type="submit" value="Nahrát obrázek" name="submit" />
</form>
</div>
<?php 
if(isset($_POST["submit"])) {
	$target_dir = "img/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if(!empty($_FILES["fileToUpload"]["tmp_name"])){ //tmp_name - dočasný název souboru po nahrání
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($imageFileType != "jpg") {
			$check = false;
		}
		if($check != false) {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				//echo "<h3>Soubor ". basename( $_FILES["fileToUpload"]["name"]). " byl úspěšně nahrán.</h3>";
				header("Location:" . BASE_URL . "?page=admProd");
			} else {
				echo "<h3>Při nahrávání souboru došlo k neznámé chybě...</h3>";
			}
		} else {
			echo '<h3>Nahraný soubor není platný .jpg obrázek, zkuste to znovu...</h3>';
		}
	} else {
		echo '<h3>Před odesláním je nutné vybrat soubor s .jpg obrázkem...</h3>';
	}
}
echo '<hr /><sup><strong>*</strong></sup>Název obrázku musí být ve tvaru 
<strong>X.jpg</strong>, kde <strong>X je ID produktu</strong> (viz tabulka).';
} else {
	die("Přístup zamítnut");
}
?>

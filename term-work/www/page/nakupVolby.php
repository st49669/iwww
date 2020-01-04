<?php
$celkemKC = $_GET['cena'];
$conn = Conn::getPdo();
$stmt = $conn->query("SELECT * FROM Doprava");
$stmt2 = $conn->query("SELECT * FROM Platba");
$dopravaCena = 0;
$dopravaId = 0;
$dobirka = 45.00; //fixní cena - platba hotově mimo osobního odběru
$platba = 1; //platba hotově
echo '<h1>Doprava a platba</h1><hr />

<form method="post">
	<h3>Doprava:</h3>
	<select name="doprava" onchange="this.form.submit();">';
	foreach($stmt as $item){
		$dopravaCena = (isset($_POST["doprava"]) ? $_POST["doprava"] : 0.00);
		if($dopravaCena == $item["Cena"]){
			echo '<option value="'.$item["Cena"].'" selected>'.$item["Nazev"].' - ' .$item["Cena"]. ' Kč</option>';
			$dopravaId = $item["ID"];
		} else {
			echo '<option value="'.$item["Cena"].'">'.$item["Nazev"].' - ' .$item["Cena"]. ' Kč</option>';
		}
	}
	echo'		
	</select><br />
	<h3>Platba:</h3>
	<select name="platba" onchange="this.form.submit();">';
	foreach($stmt2 as $item){
		$platba = (isset($_POST["platba"]) ? $_POST["platba"] : 1);
		if($platba == $item["ID"]){
			echo '<option value="'.$item["ID"].'" selected>'.$item["Nazev"].'</option>';
		} else {
			echo '<option value="'.$item["ID"].'">'.$item["Nazev"].'</option>';
		}
	}
	echo'		
	</select>
</form><br />
Cena dopravy: <strong>'. $dopravaCena . ' Kč.</strong><br />';
$celkemKC += $dopravaCena;
if ($dopravaCena != 0 && $platba == 1){ //není osobní odběr a platí se hotově = dobírka
		echo '+ dobírka: <strong>'.$dobirka.' Kč.</strong>';
		$celkemKC += $dobirka;
	} else {
		echo 'Platba <strong>zdarma.</strong>';
	}
	echo '<h3>Cena celkem:&nbsp;' . $celkemKC . '&nbsp;Kč.</h3><hr />
<div class="card"><a ';
if (Auth::getAuth()->hasId()){ ?>
	 href="<?= BASE_URL . '?page=nakupDokoncit&doprava=' . $dopravaId . '&platba=' . $platba . '&cena=' . $celkemKC ?>"
	<?php
	}else{
	?>
	   onclick="alert('Pro nákup je nutné se registrovat nebo přihlásit!')"
	<?php
   }
   ?>>Závazně objednat</a>
</div>
?>
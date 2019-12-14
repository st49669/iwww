
<?php 
$celkemKC = $_GET['cena']; 
$doprava = $_GET['doprava']; 
$dobirka = 45.00; //fixní cena - platba hotově mimo osobního odběru
$platba = 1; //platba hotově
$conn = Conn::getPdo();
$stmt = $conn->query("SELECT * FROM Platba");
echo '<h1>Platba</h1><hr />
<h2>Vyberte metodu platby:</h2>
<form method="post">
<select name="platba" onchange="this.form.submit();">';
foreach($stmt as $item){
	$platba = (isset($_POST["platba"]) ? $_POST["platba"] : 1);
	if($platba == $item["ID"]){
		echo '<option value="'.$item["ID"].'" selected>'.$item["Nazev"].'</option>';
	} else {
		echo '<option value="'.$item["ID"].'">'.$item["Nazev"].'</option>';
	}
}
echo'		
</select>
</form><br />';
if ($doprava != 0 && $platba == 1){ //není osobní odběr a platí se hotově = dobírka
		echo 'Cena platby dobírkou: <strong>'.$dobirka.' Kč.</strong>';
		$celkemKC += $dobirka;
	} else {
		echo 'Platba <strong>zdarma.</strong>';
	}
	echo '<h3>Cena celkem:&nbsp;' . $celkemKC . '&nbsp;Kč.</h3><hr />
<div class="card"><a ';
if (Auth::getAuth()->hasId()){ ?>
	 href="<?= BASE_URL . '?page=nakupDokoncit&doprava=' . $doprava . '&platba=' . $platba . '&cena=' . $celkemKC ?>"
	<?php
	}else{
	?>
	   onclick="alert('Pro nákup je nutné se registrovat nebo přihlásit!')"
	<?php
   }
   ?>>Závazně objednat</a>
</div>


<?php
$celkemKC = $_GET['cena'];
$conn = Conn::getPdo();
$stmt = $conn->query("SELECT * FROM Doprava");
$dopravaCena = 0;
$dopravaId = 0;
echo '<h1>Doprava</h1><hr />
<h2>Vyberte metodu dopravy:</h2>
<form method="post">
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
</select>
</form><br />
Cena dopravy: <strong>'. $dopravaCena . ' Kč.</strong>';
$celkemKC += $dopravaCena;
echo '<h3>Cena celkem:&nbsp;' . $celkemKC  . '&nbsp;Kč.</h3>
<hr />
<div class="card"><a ';
    if (Auth::getAuth()->hasId()){ ?>
		href="<?= BASE_URL . '?page=nakupPlatba&cena=' . $celkemKC . '&doprava=' . $dopravaId ?>"
<?php
	}else{ ?>
		onclick="alert('Pro nákup je nutné se registrovat nebo přihlásit!')"
<?php
       }
   echo '>Výběr platby</a>
	</div>
</div>';
?>
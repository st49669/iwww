<?php 
echo'<h1>Nákupní košík</h1><hr />
<div class="center-wrapper">'; //košík je přístupný pro všechny
$celkemKC = 0;
$conn = Conn::getPdo();
if (!isset($_SESSION['kosik'])) {
	$_SESSION['kosik'] = array();
}
if (isset($_GET["action"])) {
	if ($_GET["action"] == "pridat") {
		if (array_key_exists($_GET["id"], $_SESSION['kosik'])) { // 
			$_SESSION['kosik'][$_GET['id']]['mnoz']++; //akce - přidat do košíku,  SESSION('kosik'), key=>val:[id]=>[mnoz]++;
			header("Location:" . BASE_URL . "?page=nakupKosik");
		} else {
			$_SESSION['kosik'][$_GET['id']]['mnoz'] = 1; //1. přidání produktu, klíč [id] v SESSION('kosik'),key=>val:[id]=>[mnoz] = 1;
			header("Location:" . BASE_URL . "?page=nakupKosik");
		}
		
	} else if ($_GET["action"] == "odebrat") {
		if (array_key_exists($_GET["id"], $_SESSION['kosik'])) {
			$_SESSION['kosik'][$_GET['id']]['mnoz']--;
			if ($_SESSION['kosik'][$_GET['id']]['mnoz'] == 0) {
				unset($_SESSION['kosik'][$_GET['id']]);
			}
		}
		header("Location:" . BASE_URL . "?page=nakupKosik");
	} else if ($_GET["action"] == "smazat") {
		unset($_SESSION['kosik'][$_GET['id']]);
		header("Location:" . BASE_URL . "?page=nakupKosik");
	}
}
if (empty($_SESSION['kosik'])) {
	echo '<h2>Nákupní košík je prázdný...</h2><br /><br /><br /><br /><br /><p>...přejděte do katalogu a vyberte si.</p>';
} else {
	echo '
	<table class="btn">
		<thead>
		<tr>
			<th>Produkt</th>
			<th>Přidat/odebrat/smazat</th>
			<th>Množství</th>
			<th>Cena [ks]</th>
			<th>Výrobce</th>
		</tr>
		</thead>'; 
	foreach ($_SESSION['kosik'] as $item => $mnoz) {
		$stmt = $conn->prepare("SELECT Produkt.ID, Produkt.Nazev as Prod, Popis, Cena, Vyrobce.Nazev as Vyr FROM Produkt 
			INNER JOIN Vyrobce on Vyrobce_ID = Vyrobce.ID WHERE Produkt.ID = :id");
		$stmt->bindParam(':id', $item);
		$stmt->execute();
		$stmt = $stmt->fetch();
		echo '<tr>
			
			<td>' . $stmt['Prod'] . '</td>
			<td>
				<a href="./index.php?page=nakupKosik&action=pridat&id=' . $item . '"> +1 ks </a>&nbsp;
				<a href="./index.php?page=nakupKosik&action=odebrat&id=' . $item . '"> -1 ks </a>&nbsp;
				<a href="./index.php?page=nakupKosik&action=smazat&id=' . $item . '"> Vymazat </a>
			</td>
			<td>' . $mnoz['mnoz'] . '</td>
			<td>' . $stmt['Cena'] . '</td>
			<td>' . $stmt['Vyr'] . '</td>
			
		</tr>';
		$celkemKC += ($mnoz['mnoz'] * $stmt['Cena']);
		
	}
	echo '
	</table><hr /> 
	<p>Celková cena: <strong>'.$celkemKC.' Kč</strong></p>
	<div class="card"><a';
	if (Auth::getAuth()->hasId()){ ?>
		<a href="<?= BASE_URL . "?page=nakupVolby&cena=" . $celkemKC . "" ?>"
		<?php
			} else { ?>
				onclick="alert('Pro nákup je nutné se registrovat nebo přihlásit!')"
		   <?php }
		   echo '>Výběr dopravy a platby</a>
		</div>
	</div>';
}







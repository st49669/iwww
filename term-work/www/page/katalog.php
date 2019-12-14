<h1>Náš katalog</h1><hr />
<?php
$conn = Conn::getPdo();
$skladem = false;
$stmt1 = $conn->query("SELECT * FROM Vyrobce");
	echo '<form action="" method="post">
		Výrobce: 
		<select name="ID">';
		$sel = $_POST["ID"];
		$s = "";
		echo '<option value="%">Všichni</option>';
		foreach ($stmt1 as $item) {  
			if($sel == $item["ID"]){
				$order = $item["Nazev"];
				$s = "selected";
			}
			echo'<option value="'. $item["ID"] .'" ' . $s .'>
					'; echo $item["Nazev"].'
				</option>
				';
			$s = "";
		};
		echo '
		</select>
			&nbsp;Pouze skladem:';
			if(isset($_POST["Skladem"]) && $_POST["Skladem"]=="A"){
				$skladem = true;
				echo '<input type="checkbox" name="Skladem" method="Post" value="A" checked/>';
			} else {
				echo '<input type="checkbox" name="Skladem" method="Post" value="A"/>';
				$skladem = false;
			}
			
	echo '&nbsp;<input type="submit" name="subm" value="Filtrovat"/>
	</form>
	</p>
	';
$query = "SELECT Produkt.ID, Produkt.Nazev, Popis, Cena, Skladem, Vyrobce.Nazev as Vyr FROM Produkt 
		INNER JOIN Vyrobce on Vyrobce_ID = Vyrobce.ID";
if($_SERVER['REQUEST_METHOD'] == 'POST' && $skladem){
	 $query .= " WHERE Vyrobce_ID LIKE '" . $_POST["ID"] . "' AND Skladem= 0b1";
} else if($_SERVER['REQUEST_METHOD'] == 'POST' && !$skladem) {
	$query .= " WHERE Vyrobce_ID LIKE '" . $_POST["ID"] . "'";
}
$query .= " ORDER BY Skladem DESC, Produkt.ID DESC";
?>
<div class="center-wrapper">
    <section>
        <div class="flex-wrap">
		<?php
		$stmt = $conn->query($query);
		$imgSrc = "";
		foreach($stmt as $item){
			if (file_exists('./img/'.$item["ID"].'.jpg')){ //přiřadit obecný obrázek, pokud žádný neexistuje
				$imgSrc = $item["ID"];
			} else {
				$imgSrc = "dron-gen";
			}
			?>
			<div class="card">
				<img src="./img/<?php echo $imgSrc ?>.jpg" alt="<?php echo $item["Nazev"]?>"/>
				<h3><?php echo $item["Nazev"]?></h3>
				<p><?php if (empty($item["Popis"])){
					echo "Popisek připravujeme...";
				} else {
					echo $item["Popis"];
				}?></p>
				<p>Výrobce: <?php echo $item["Vyr"]?><br />
				Dostupnost: <?php if ($item["Skladem"]){
					echo "<strong>Skladem</strong>";
				} else {
					echo "<strong>Není na skladě</strong>";
				}?></p>
				Cena: <strong><?php echo $item["Cena"] . " Kc"?></strong>
				<a href='<?= BASE_URL . "?page=nakupKosik&action=pridat&id=" . $item["ID"] ?>'>Do košíku</a>
			</div>
		<?php } ?>
    </section>
</div>
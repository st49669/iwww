
<?php
if($_SESSION["Role"] == "Admin"){
	$conn = Conn::getPdo();
	$stmt1 = $conn->query("SELECT * from Platba ORDER BY ID DESC");

	echo '
	<h1>Správa ostatních tabulek</h1><hr />
	<table class="btn" border="1px">
		<tr>
			<th>ID</th>
			<th>Typ platby</th>
			<th>Operace</th>
		</tr>';
	while ($item = $stmt1->fetch(PDO::FETCH_ASSOC)) {	
		echo '
		<tr>
			<td>' . $item["ID"] . '</td>
			<td>' . $item["Nazev"] . '</td>
			<td>
				<a href="?page=admEtc-platUprav&id=' . $item["ID"] . '">Uprav</a>
				<a href="?page=admEtc-platSmaz&id=' . $item["ID"] . '">Smaž</a>
			</td>
		</tr>';
	}
	echo '</table>';
	?>
	<div class="btn">
	<strong><a href="<?= BASE_URL ."?page=admEtc-platVloz" ?>">---&gt; Přidat typ platby &lt;---</a></strong>
	</div>
	<p><hr /></p>

	<?php
	$stmt2 = $conn->query("SELECT * from Doprava ORDER BY ID DESC");
	echo '<table class="btn" border="1px">';
	echo '
		<tr>
			<th>ID</th>
			<th>Typ dopravy</th>
			<th>Cena</th>
			<th>Operace</th>
		</tr>';
	while ($item = $stmt2->fetch(PDO::FETCH_ASSOC)) {	
		echo '
		<tr>
			<td>' . $item["ID"] . '</td>
			<td>' . $item["Nazev"] . '</td>
			<td>' . $item["Cena"] . '</td>
			<td>
				<a href="?page=admEtc-doprUprav&id=' . $item["ID"] . '">Uprav</a>
				<a href="?page=admEtc-doprSmaz&id=' . $item["ID"] . '">Smaž</a>
			</td>
		</tr>';
	}
	echo '</table>';
	?>
	<div class="btn">
	<strong><a href="<?= BASE_URL ."?page=admEtc-doprVloz" ?>">---&gt; Přidat typ dopravy &lt;---</a></strong>
	</div>
	<p><hr /></p>

	<?php
	$stmt3 = $conn->query("SELECT * from Vyrobce ORDER BY ID DESC");
	echo '<table class="btn" border="1px">';
	echo '
		<tr>
			<th>ID</th>
			<th>Název výrobce</th>
			<th>Operace</th>
		</tr>';
	while ($item = $stmt3->fetch(PDO::FETCH_ASSOC)) {	
		echo '
		<tr>
			<td>' . $item["ID"] . '</td>
			<td>' . $item["Nazev"] . '</td>
			<td>
				<a href="?page=admEtc-vyrUprav&id=' . $item["ID"] . '">Uprav</a>
				<a href="?page=admEtc-vyrSmaz&id=' . $item["ID"] . '">Smaž</a>
			</td>
		</tr>';
	}
	echo '</table>';
	?>
	<div class="btn">
	<strong><a href="<?= BASE_URL ."?page=admEtc-vyrVloz" ?>">---&gt; Přidat dalšího výrobce &lt;---</a></strong>
	</div>
	<p><hr /></p>

	<?php
	$stmt4 = $conn->query("SELECT * from Role ORDER BY ID DESC");
	echo '<table class="btn" border="1px">';
	echo '
		<tr>
			<th>ID</th>
			<th>Název role</th>
			<th>Operace</th>
		</tr>';
	while ($item = $stmt4->fetch(PDO::FETCH_ASSOC)) {	
		echo '
		<tr>
			<td>' . $item["ID"] . '</td>
			<td>' . $item["Nazev"] . '</td>
			<td>
				<a href="?page=admEtc-roleUprav&id=' . $item["ID"] . '">Uprav</a>
				<a href="?page=admEtc-roleSmaz&id=' . $item["ID"] . '">Smaž</a>
			</td>
		</tr>';		
	}
	echo '</table>';
} else {
	die("Přístup zakázán");
}
?>
<div class="btn">
<strong><a href="<?= BASE_URL ."?page=admEtc-roleVloz" ?>">---&gt; Přidat další roli &lt;---</a></strong>
</div>
<p><hr /></p>
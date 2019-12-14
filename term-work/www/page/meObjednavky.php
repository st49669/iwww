<?php 
if(Auth::getAuth()->hasId()){ //stránka pouze pro přihlášené	
	echo '<h1>Přehled objednávek</h1><hr />';
	echo '<table class="btn">
	<tr>
		<th>Položky</th>
		<th>Cena [Kč]</th>
		<th>Vytvoření</th>
		<th>Doprava</th>
		<th>Platba</th>
		<th>Zaplaceno</th>
	</tr>';
	$conn = Conn::getPdo();
	$idRel = $_SESSION["ID"]; //zjisti aktuální ID relace
	$stmt = $conn->query("SELECT objednavka.ID, objednavka.CelkovaCena, Objednavka.DatumVytvoreni, Objednavka.Zaplaceno, Objednavka.DatumPlatby, Doprava.Nazev as NazDop, Platba.Nazev as NazPlat
	FROM Doprava INNER JOIN Objednavka ON Objednavka.Doprava_ID=Doprava.ID INNER JOIN Platba on Objednavka.Platba_ID=Platba.ID
	WHERE Objednavka.Uzivatel_ID = '$idRel' order by Objednavka.DatumVytvoreni DESC"); //objednávky včetně platby a dopravy
	foreach ($stmt as $item) {
		echo '   
	   <tr>
		   <td><a href="?page=meObjednavky-polozky&id=' . $item["ID"] . '&rel='.$idRel.'">Zobrazit</a></td>
		   <td>' . $item["CelkovaCena"] . '</td> 
		   <td>' . $item["DatumVytvoreni"] . '</td>
			<td>' . $item["NazDop"] . '</td>
			<td>' . $item["NazPlat"] . '</td>
			<td>'; if(empty($item["DatumPlatby"])) echo '---</td>'; else echo $item["DatumPlatby"].'</td>'; //Zobrazí datum platby nebo ---
		echo '</tr>';
	}
	echo '</table>
	<hr />
	<p>Poznámka: do celkové ceny se promítá i zvolený způsob dopravy a příp. platba dobírkou.</p>';
} else {
	die("Přístup zamítnut");
}

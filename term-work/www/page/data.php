<?php
if($_SESSION["Role"] == "Admin"){
	echo' <h1>Práce s daty</h1><hr />';?>
	<div class="btn">
		<p><strong><a href="<?= BASE_URL ."?page=dataExp&tab=Uzivatel" ?>">---&gt; Export uživatelů &lt;---</a></strong></p>
		<p><strong><a href="<?= BASE_URL ."?page=dataExp&tab=Produkt" ?>">---&gt; Export produktů &lt;---</a></strong></p>
		<p><strong><a href="<?= BASE_URL ."?page=dataExp&tab=Objednavka" ?>">---&gt; Export objednávek &lt;---</a></strong></p>
		<p><strong><a href="<?= BASE_URL ."?page=dataExp&tab=rel_Objednavka_Produkt" ?>">---&gt; Export položek objednávek &lt;---</a></strong></p>
		<p><strong><a href="<?= BASE_URL ."?page=dataExp&tab=Doprava" ?>">---&gt; Export typů dopravy &lt;---</a></strong></p>
		<p><strong><a href="<?= BASE_URL ."?page=dataExp&tab=Platba" ?>">---&gt; Export typů platby &lt;---</a></strong></p>
		<p><strong><a href="<?= BASE_URL ."?page=dataExp&tab=Vyrobce" ?>">---&gt; Export výrobců &lt;---</a></strong></p>
		<p><strong><a href="<?= BASE_URL ."?page=dataExp&tab=Role" ?>">---&gt; Export rolí &lt;---</a></strong></p>
		<hr />
		<p><strong><a href="<?= BASE_URL ."?page=dataImp" ?>">---&gt; Import uživatelů &lt;---</a></strong></p>
	</div>
<?php
} else {
	die("Přístup zamítnut");
}
?>	

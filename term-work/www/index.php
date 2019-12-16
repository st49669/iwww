<!DOCTYPE html>
<?php
include 'config.php';
ob_start(); //chaching pred odeslanim pro posilani v celku misto po castech
session_start(); //zrizeni superglobalni promenne $_SESSION
function __autoload($class) //automatické načtení pomocných tříd (Pdo a Auth)
{
    if (file_exists('./class/' . $class . '.php')) {
        require_once './class/' . $class . '.php';
        return true;
    }
    return false;
}
?>
<html>
<head>
    <title>DroneShop.cz | letíme v tom s vámi!</title>
    <link type="text/css" rel="stylesheet" href="./css/style.css" />
    <link type="text/css" rel="stylesheet" href="./css/res-style.css" />
	<link type="text/css" rel="stylesheet" href="./css/print-style.css" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<header>
	<nav id="menu">
	<a href="<?= BASE_URL . "?page=default"?>"><img class="nav-img" src="./img/drone.png" alt="Logo webu" /><strong>DroneShop.cz</strong></a>
    <a href="<?= BASE_URL . "?page=katalog" ?>">Katalog</a>
    <?php if (Auth::getAuth()->hasId()) { //rozhodovací logika pro zobrazení jednotlivých stránek dle rolí
		if ($_SESSION["Role"] == "Admin") { //pro admina?> 
            <a href="<?= BASE_URL . "?page=admProd" ?>">Správa produktů</a>
			<a href="<?= BASE_URL . "?page=admUziv" ?>">Správa uživatelů</a>
            <a href="<?= BASE_URL . "?page=admPlat" ?>">Správa plateb</a>
			<a href="<?= BASE_URL . "?page=admEtc" ?>">Ostatní tabulky</a>
            <a href="<?= BASE_URL . "?page=data" ?>">Práce s daty</a>
			<a href="<?= BASE_URL . "?page=mujUcet&id=".$_SESSION['ID'] ?>">Můj účet</a>
			<a href="<?= BASE_URL . "?page=logout" ?>">Odhlásit</a>
   <?php } else if ($_SESSION["Role"] != "Admin") {//pro ostatní přihlíšené?>
		<a href="<?= BASE_URL . "?page=meObjednavky" ?>">Mé objednávky</a>
		<a href="<?= BASE_URL . "?page=mujUcet&id=".$_SESSION['ID'] ?>">Můj účet</a>
		<a href="<?= BASE_URL . "?page=logout" ?>">Odhlásit</a>
		<a href="<?= BASE_URL . "?page=nakupKosik"?>"><img class="nav-img" src="./img/cart.png" alt="Nákupní košík"/>Košík</a>
	<?php }
		} else { //i pro nepřihlášené ?>
		<a href="<?= BASE_URL . "?page=login" ?>">Přihlášení</a>
		<a href="<?= BASE_URL . "?page=nakupKosik"?>"><img class="nav-img" src="./img/cart.png" alt="Nákupní košík"/>Košík</a>
		<?php } ?>
    </nav>
</header>
<?php
    $page = "./page/" . $_GET["page"]; //přepínání mezi stránkami z parametru page
    $file = $page . ".php";
    if (file_exists($file)){ //ověření existence stránky v parametru page
        echo "<main><br /><br /><br />";
        include $file; //přechod na stránku dle page
        echo "</main>";

    } else {
        echo "<main><br />";
        include "./page/default.php";
        echo "</main>";
    }
?>
</body>
<?php
include "./page/footer.php"; //patička
?>
</html>

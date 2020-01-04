<?php
echo '
<h1>Přihlašte se...</h1>
<hr />';

if (!empty($_POST) && !empty($_POST["mail"]) && !empty($_POST["pw"])) { //kontrola vyplnění polí
    $auth = Auth::getAuth(); //auth - singleton třída, která obsahuje info o přihlášení
    if ($auth->login($_POST["mail"], $_POST["pw"])) {//pokus o přihlášení
        header("Location:" . BASE_URL);
    } else {
        echo "<p>Přihlášení se nezdařilo. <strong>Zadali jste správné přihlašovací údaje?</strong></p>";
    }
} else if (!empty($_POST)) {
    echo "<p>Zadejte prosím své <strong>přihlašovací údaje.</strong></p>";
}
echo '<div class="center-wrapper">
	<form method="post">
		<table>
			<tr><tr><td colspan="2">&nbsp;</td></tr><tr>
				<th class="rig"><strong>E-mail:</strong></th><td><input type="email" label="E-mail" name="mail" placeholder="vase@emailova.adresa"></td>
			</tr><tr>
				<th class="rig"><strong>Heslo:</strong></th><td><input type="password" label="Vaše heslo" name="pw" placeholder="Heslo"></td>
			</tr><tr><td colspan="2">&nbsp;</td></tr><tr>
				<th colspan="2"><input type="submit" value="&nbsp;&nbsp;&nbsp;Přihlásit&nbsp;&nbsp;&nbsp;"></th>
			</tr>
		</table>

	</form>
</div>';
?>
<hr />
<h2>Nemáte ještě účet?</h2>
<div class="btn">
<strong><a href="<?= BASE_URL . "?page=registrace" ?>">---&gt; Registrujte se kliknutím sem &lt;---</a></strong>
</div>



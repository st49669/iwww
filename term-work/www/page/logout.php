<h1>Odhlášení proběhlo v pořádku.</h1><hr />
<?php
	Auth::getAuth()->logout(); //destroy session
?>
<div class="btn">
<strong><a href="<?= BASE_URL ?>">---&gt; Pokračujte kliknutím sem &lt;---</a></strong>
</div>

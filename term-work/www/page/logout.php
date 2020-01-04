<?php
	Auth::getAuth()->logout(); //destroy session
	header("Location:" . BASE_URL . "?page=default");
?>

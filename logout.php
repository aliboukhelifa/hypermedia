<?php

session_start();

// Suppression des variables de session et de la session
$_SESSION = array();
if(session_destroy())
	{
		// Redirection vers la page de connexion
		header("Location: index.php");
	}
// Suppression des cookies de connexion automatique
setcookie('login', '');
setcookie('pass_hache', '');

?>



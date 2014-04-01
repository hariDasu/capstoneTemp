<?php

session_start();

if (!isset($_SESSION['AUTH']))
{
	session_destroy();
	header('Location: signIn.html');
}
else
{
	session_destroy();
	header('Location: signIn.html');
}

?>
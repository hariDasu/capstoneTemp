<?php
session_start();

//validate session
if (!isset($_SESSION['AUTH']))
{
	session_destroy();
	header('Location: login.html');
}

$username = $_SESSION['USERNAME'];
$utype = $_SESSION['UTYPE'];
$fname = $_SESSION['FNAME'];
$lname = $_SESSION['LNAME'];
$email = $_SESSION['EMAIL'];

echo "Welcome to the splash page!<br /><br />";

echo "User Information from Session:<br /><br />USERNAME: $username<br />UTYPE: $utype<br />Firstname: $fname<br />Lastname: $lname<br />Email: $email";

?>

<br /><br /><a href="logout.php">Logout</a>
<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

$email = $_GET['email'];
$hash = $_GET['hash'];

//echo $email . "password: ". $hash . "<br /><br />";

//connect to database
//$conn = mysqli_connect("sql.njit.edu","ser5","rTlzzhFwz","ser5");
$conn = mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");

//$query = "UPDATE `USERS` SET ACTIVE='1' WHERE EMAIL='$email' AND HASH='$hash' AND ACTIVE='0'";

//echo $query;


if(mysqli_connect_errno($conn))
{
	echo "Database connection failed!" . "<br />";
}
else
{
	//echo "Database connection success!" . "<br />";
	//$query = mysqli_query($conn, "SELECT EMAIL, HASH, ACTIVE FROM `USERS` WHERE EMAIL='".$email."' AND HASH='".$hash."' AND ACTIVE='0'");
	//echo $query;
	//$results = mysqli_fetch_array($query);

	$q = "UPDATE `USERS` SET ACTIVE='1' WHERE EMAIL='$email' AND HASH='$hash' AND ACTIVE='0'";
	$query = mysqli_query($conn, $q) or die ('Error updating database: '.mysql_error());
	$res = mysqli_affected_rows($conn);

	if($res == 1)
	{
		echo "user account associated with $email is now active you may now <br /><a href='login.html'>Login</a>";
	}
	else
	{
		echo "invalid confirmation link or your user account associated with $email is already active";
	}

	//print_r($results);
	//echo "match is $match";

	/*
	if(sizeof($results) != 0)
	{
		//echo "active record <br /><br />";
		//echo mysqli_affected_rows($conn);
		//$q = "UPDATE `USERS` SET ACTIVE='1' WHERE EMAIL='$email' AND HASH='$hash' AND ACTIVE='0'";
		//$update = mysqli_query($conn, $q)or die(mysqli_error($conn);
		//echo $check = mysqli_affected_rows($conn);
		//mysqli_query($conn, "UPDATE `USERS` SET ACTIVE='1' WHERE EMAIL='".$email."' AND HASH='".$hash."' AND ACTIVE='0'");
		
		
		//if($check != 0)
		//{
		//	echo 'Your account has been activated, you can now <a href="login.html">login</a>';
		//}
		//else
		//{
		//	echo mysql_error();
		//}
		
	}
	else
	{
		echo 'The url is either invalid or you already have activated your account.';
	}
	*/
}

?>
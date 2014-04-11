<?php

session_start();

ini_set('display_errors',1);
error_reporting(E_ALL);
//header("Content-type: application/json");

//session_start();

//get form variables
$username = $_POST['username'];
$password = $_POST['password'];

//echo "username entered: " . $username . " password entered: " . $password . "<br />";

//connect to database
//$conn = mysqli_connect("sql.njit.edu","ser5","rTlzzhFwz","ser5");
$conn = mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");

if(mysqli_connect_errno($conn))
{
	echo "Database connection failed!" . "<br />";
}
else
{
	//echo "Database connection success!" . "<br />";
	//$query = mysqli_query($conn, "SELECT * FROM USERS WHERE USERNAME='".$username."' AND ACTIVE='1'");
	$query = mysqli_query($conn, "SELECT * FROM USERS WHERE USERNAME='".$username."'");
	$results = mysqli_fetch_array($query);

	//print_r($results);

	//echo $results["PASSWORD"];

	//while($results = mysqli_fetch_array($query))
	//{
	//		print_r($results);
	//}

	if(sizeof($results) != 0 && $results["ACTIVE"] == 1)
	{
		//records in database found with username

		if($results["PASSWORD"] == $password)
		{
			$_SESSION['AUTH'] = "True";
			$_SESSION['UTYPE'] = $results["UTYPE"];
			$_SESSION['USERID'] = $results["USERID"];
			$_SESSION['USERNAME'] = $results["USERNAME"];
			$_SESSION['FNAME'] = $results["FNAME"];
			$_SESSION['LNAME'] = $results["LNAME"];
			$_SESSION['EMAIL'] = $results["EMAIL"];
			$_SESSION['PASSWORD'] = $results["PASSWORD"];
			//print_r($results);
			header('Location: splashPublic.php');
			//echo "active account you may login";
		}
		else
		{
			//mysql_close($conn);
			session_destroy();
			header('Location: signIn.html');
		}
	}
	else if (sizeof($results) != 0 && $results["ACTIVE"] == 0) {
		session_destroy();
		echo $results["USERNAME"] . " please check your email at ". $results["EMAIL"] ." and confirm your account";
	}
	else
	{
		session_destroy();
		echo "Username not found! Would you like to <a href='register.html'>Register?</a> or retry <a href='signIn.html'>Login?</a>";
	}
}

//echo "connect success";

//mysql_close($conn);
?>

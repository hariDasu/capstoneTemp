<?php

session_start();

ini_set('display_errors',1);
error_reporting(E_ALL);

if (!isset($_SESSION['AUTH']))
{
	session_destroy();
	header('Location: signIn.html');
}

//GET SESSION VARIABLES
$username = $_SESSION['USERNAME'];
$utype = $_SESSION['UTYPE'];
$userid = $_SESSION['USERID'];
$fname = $_SESSION['FNAME'];
$lname = $_SESSION['LNAME'];
$email = $_SESSION['EMAIL'];
$password = $_SESSION['PASSWORD'];

//GET FORM VARIABLES
$f_username = $_POST['username'];
$f_password = $_POST['password'];
$f_firstname = $_POST['firstname'];
$f_lastname = $_POST['lastname'];
$f_email = $_POST['email'];

$query_update_username = "UPDATE `USERS` SET USERNAME='$f_username' WHERE USERID=$userid";
$query_update_password = "UPDATE `USERS` SET PASSWORD='$f_password' WHERE USERID=$userid";
$query_update_firstname = "UPDATE `USERS` SET FNAME='$f_firstname' WHERE USERID=$userid";
$query_update_lastname = "UPDATE `USERS` SET LNAME='$f_lastname' WHERE USERID=$userid";
$query_update_email = "UPDATE `USERS` SET EMAIL='$f_email' WHERE USERID=$userid";

$conn = mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");

if(mysqli_connect_errno($conn))
{
	echo "Database connection failed!" . "<br />";
}
else
{
	//echo "Database connection success!" . "<br />";
	//$query = mysqli_query($conn, $query);
	//echo "You entered: $f_username $f_password $f_firstname $f_lastname $f_email" . "<br />"; 

	//update username
	
	//echo "<pre>" . $query_update_username . "</pre>";

	if(isset($f_username) && !empty($f_username) && $f_username != $username)
	{
		//echo "username field set to: " . $f_username . "<br />";
		$query = mysqli_query($conn, $query_update_username);
		if($query)
		{
			echo "username sucessfully updated to: $f_username . Please logout and re-login to see changes. <br />";
		}
	}
	//else
	//{
		//echo "username field left empty or you are attempting to update the username with the same value. <br />";
	//}

	//update password

	if(isset($f_password) && !empty($f_password) && $f_password != $password)
	{
		//echo "username field set to: " . $f_username . "<br />";
		$query = mysqli_query($conn, $query_update_password);
		if($query)
		{
			echo "password sucessfully updated to: $f_password . Please logout and re-login to see changes. <br />";
		}
	}
	//else
	//{
		//echo "password field left empty or you are attempting to update the username with the same value. <br />";
	//}

	//update firstname

	if(isset($f_firstname) && !empty($f_firstname) && $f_firstname != $fname)
	{
		//echo "username field set to: " . $f_username . "<br />";
		$query = mysqli_query($conn, $query_update_firstname);
		if($query)
		{
			echo "first name sucessfully updated to: $f_firstname . Please logout and re-login to see changes. <br />";
		}
	}
	//else
	//{
		//echo "first name field left empty or you are attempting to update the username with the same value. <br />";
	//}

	//update lastname

	if(isset($f_lastname) && !empty($f_lastname) && $f_lastname != $lname)
	{
		//echo "username field set to: " . $f_username . "<br />";
		$query = mysqli_query($conn, $query_update_lastname);
		if($query)
		{
			echo "last name sucessfully updated to: $f_lastname . Please logout and re-login to see changes. <br />";
		}
	}
	//else
	//{
		//echo "last name field left empty or you are attempting to update the username with the same value. <br />";
	//}

	//update email

	if(isset($f_email) && !empty($f_email) && $f_email != $email)
	{
		//echo "username field set to: " . $f_username . "<br />";
		$query = mysqli_query($conn, $query_update_email);
		if($query)
		{
			echo "email sucessfully updated to: $f_email . Please logout and re-login to see changes. <br />";
		}
	}
	//else
	//{
		//echo "email field left empty or you are attempting to update the username with the same value. <br />";
	//}

	if($_SESSION["UTYPE"] == "3")
	{
		$user_to_change = $_POST["user_account"];
		//$user_utype = $_POST["user_utype"];
		//$user_activity = $_POST["user_active"];

		//echo "you entered $user_to_change $user_utype $user_activity";

		
		if(isset($user_to_change) && !empty($user_to_change))
		{
			$user_utype = $_POST["user_utype"];
			$user_activity = $_POST["user_active"];

			$query_update_utype = "UPDATE `USERS` SET UTYPE=$user_utype WHERE USERNAME='$user_to_change'";
			$query_update_uactivity = "UPDATE `USERS` SET ACTIVE=$user_activity WHERE USERNAME='$user_to_change'";

			//echo "you entered: $user_utype $user_activity";
			//echo "queries: $query_update_utype $query_update_uactivity";

			if(isset($user_utype) && !empty($user_utype))
			{
				$query = mysqli_query($conn, $query_update_utype);

				if($query)
				{
					echo "user: $user_to_change has successfully had usertype changed to $user_utype <br />";
				}
			}

			if(isset($user_activity) && !empty($user_activity))
			{
				$query = mysqli_query($conn, $query_update_uactivity);

				if($query)
				{
					//echo "<pre>" . $query_update_uactivity . "</pre>";
					//echo "you entered user activity level $user_activity for $user_to_change";
					echo "user: $user_to_change has successfully had activity changed to $user_activity <br />";
				}
			}
		}
	}
}

?>

<br /><br /><a href="http://pytools.webfactional.com/capstoneTemp/">Home</a>
<a href="http://pytools.webfactional.com/capstoneTemp/splash.php">Splash</a>
<a href="http://pytools.webfactional.com/capstoneTemp/admin.php">Back To Edit</a>
<a href="http://pytools.webfactional.com/capstoneTemp/logout.php">Logout</a>
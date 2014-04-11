<?php

session_start();

ini_set('display_errors',1);
error_reporting(E_ALL);

if (!isset($_SESSION['AUTH']))
{
	session_destroy();
	header('Location: signIn.html');
}

$admin_option_username = "<input name='user_account' placeholder='Account Username'> <br />";
$admin_option_utype = "<input name='user_utype' placeholder='Enter User Status Code'>";
$admin_option_activity = "<input name='user_active' placeholder='Enter User Active Status'>";
$header = "<h1>User Account Administration Page</h1>";
$help = "<br /> Please enter appropriate information to update aspects of your account. If you are an admin you
			will see extra options to modify or ban other users.<br /><br />";

echo $header . "<br />";
echo "Welcome: " . "<b>" . $_SESSION["USERNAME"] . "</b>" . " user type is: " . $_SESSION["UTYPE"] . $help;

?>

<form action="update.php" method="post">
	<input name="username" placeholder="User Name"> <br />
	<input name="password" type="password" placeholder="Password"> <br />
	<input name="firstname" placeholder="First Name"> <br />
	<input name="lastname" placeholder="Last Name"> <br />
	<input name="email" placeholder="Email Adress"><br />
	<?php
	if($_SESSION["UTYPE"] == "3")
	{
		echo "<h3>Administrative override options for other user accounts. </h3>";
		echo $admin_option_username;
		echo $admin_option_utype;
		echo " 1: Volunteer 2: City Worker 3: Administrator <br />";
		echo $admin_option_activity;
		echo " 0: Set Account to Inactive 1: Set Account to Active 2: Ban the user <br /><br />";
	}

	?>
	<input type="submit" name="submit" value="submit">
</form>

<?php

	if($_SESSION["UTYPE"] == "3")
	{
		echo "<br /><b>CURRENT LIST OF USERS: </b><br /><br />";
		$conn = mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");

		if(mysqli_connect_errno($conn))
		{
			echo "Database connection failed!" . "<br />";
		}
		else
		{
			$list_users = "SELECT USERNAME, EMAIL, ACTIVE FROM `USERS`";
			$result = mysqli_query($conn, $list_users);

			while($row = mysqli_fetch_array($result))
			{
				echo "<pre>" . $row["USERNAME"] . " " . $row["EMAIL"] . " " . $row["ACTIVE"] . "</pre>";
				//echo "<br />";
			}
		}
	}
?>

<br /><br /><a href="http://pytools.webfactional.com/capstoneTemp/">Home</a>
<a href="http://pytools.webfactional.com/capstoneTemp/splash.php">Splash</a>
<a href="http://pytools.webfactional.com/capstoneTemp/logout.php">Logout</a>
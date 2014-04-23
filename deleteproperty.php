<?php


session_start();
if (!isset($_SESSION['AUTH']))
{
    session_destroy();
    header('Location: signIn.html');
}
	
	$sql=mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");
	mysqli_select_db($sql, "paterson");
	
	if (isset($_GET['id']) && is_numeric($_GET['id']) )
	{
		// get id value
		$id = $_GET['id'];
		$query=mysqli_query($sql, "SELECT * 
						FROM PROPERTY
						WHERE PROPID = '$id'");
		$rowtot = 0;
		while($row=mysqli_fetch_assoc($query)){
			if ($_SESSION['UTYPE'] == '1' && trim($_SESSION['USERID']) !== trim($row['LUSERID']) )	
			{
				header('Location: denied.php');
				
			}
			else
			{
				// delete the entry
				mysqli_query($sql, "DELETE FROM `PROPERTY` WHERE `PROPID`='".$id."'")
				or die(mysqli_error()); 
				// redirect back to the view page
				header("Location: splashPublic.php");
			}
		}
	}
	else
	// if id isn't set, or isn't valid, redirect back to view page
	{
		header("Location: splashPublic.php");
	}
?>
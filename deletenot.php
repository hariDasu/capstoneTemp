<?php
	if ($_SESSION['UTYPE'] == '1')
	{
		header('Location: denied.php');
	}
	$sql=mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");
	mysqli_select_db($sql, "paterson");
	
	if (isset($_GET['id']) && is_numeric($_GET['id']) )
	{
		// get id value
		$id = $_GET['id'];
		// delete the entry
		mysqli_query($sql, "DELETE FROM `NOTICES` WHERE `NOTICEID`='".$id."'")
		or die(mysqli_error()); 
		// redirect back to the view page
		header("Location: listNotices.php");
	}
	else
	// if id isn't set, or isn't valid, redirect back to view page
	{
		header("Location: listNotices.php");
	}
?>
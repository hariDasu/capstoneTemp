<?php

	 /**
	  * This function can be used to check the sanity of variables
	  *
	  * @access private
	  *
	  * @param string $type  The type of variable can be bool, float, numeric, string, array, or object
	  * @param string $string The variable name you would like to check
	  * @param string $length The maximum length of the variable
	  *
	  * return bool
	  */

	function sanityCheck($string, $type, $length){

		// assign the type
		$type = 'is_'.$type;

		if(!$type($string))
		{
			return FALSE;
		}
		// now we see if there is anything in the string
		elseif(empty($string))
		{
			return FALSE;
		}
		// then we check how long the string is
		elseif(strlen($string) > $length)
		{
			return FALSE;
		}
		else
		{
			// if all is well, we return TRUE
			return TRUE;
		}
	}
	function checkEmail($email){
		return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
	}
		
	header("Content-Type: text/html");
	
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	if(isset($_POST['back']))
	{
		header("Location: listOwners.php");
	}
	
	if(isset($_POST['writeRecord']))
	{
		$inc_id=$_POST["inputOwnerID"];
		$MNAME=$_POST["inputMName"];
		$LNAME=$_POST["inputLName"];
		$SOCIAL=$_POST["inputSocial"];
		$ADDRESS=$_POST["inputAddress"];
		$CITY=$_POST["inputCity"];
		$STATE=$_POST["inputState"];
		$ZIP=$_POST["inputZip"];
		$HPHONE=$_POST["inputHPhone"];
		$CPHONE=$_POST["inputCPhone"];
		$DOB=$_POST["inputDOB"];
		$CHECKPASS=true;
		$status="";
		// check the POST variable userName is sane, and is not empty
		if(empty($_POST['inputFName'])==FALSE && sanityCheck($_POST['inputFName'], 'string', 50) != FALSE)
		{
		//If all is well we can  assign the value of POST field to a variable
			$FNAME = $_POST['inputFName'];
			$FNameErr = '';
		}
		else
		{
			$FNAME = $_POST['inputFName'];
			$FNameErr = 'First Name is empty or invalid';
			$CHECKPASS = false;
		}
		if( empty($_POST['inputEmail']) || checkEmail($_POST['inputEmail']) != FALSE)
		{
			// if the checks are ok for the email we assign the email address to a variable
			$EMAIL=$_POST["inputEmail"];
			$EmailErr = '';
		}
		else
		{
			$EMAIL=$_POST["inputEmail"];
			$EmailErr = 'Invalid E-mail Address Supplied';
			$CHECKPASS = false;
		}
		if( empty($_POST['inputDOB']) || $DOB=="0000-00-00" || checkdate( intval(substr($DOB,6,2)) , intval(substr($DOB, 8, 2 )) , intval(substr($DOB, 1,4 ) )))
		{
			// if the checks are ok for the email we assign the email address to a variable
			$DOBErr = '';
		}
		else
		{
			$DOBErr = 'Invalid Date of Birth Supplied';
			$CHECKPASS = false;
		}
		if ($CHECKPASS)
		{
			//session_start();
			$sql=mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");
			mysqli_select_db($sql, "paterson");
			if(mysqli_connect_errno($sql))
			{
				$status = "Failed to connect to MySQL: " . mysqli_connect_error() ;
			}
			else if( trim($inc_id) == "new" )
			{
				$check=mysqli_query($sql, "INSERT INTO `OWNERS` (`OWNERID`, `FNAME`, `MNAME`, `LNAME`, 
				`SOCIAL`, `ADDRESS`, `CITY`, `STATE`, `ZIP`, `HPHONE`, `CPHONE`, `DOB`, `EMAIL`) 
				VALUES ( NULL , '".$FNAME."' , '".$MNAME."' , '".$LNAME."' , '".$SOCIAL."' , '".$ADDRESS."' , '".$CITY."' ,
				'".$STATE."' , '".$ZIP."' , '".$HPHONE."' , '".$CPHONE."' , '".$DOB."' , '".$EMAIL."' )");
				
				if ($check)
				{
					$status = "New Owner successfully saved";
					$inc_id = $sql->insert_id;
				}
				else
				{
					$status = "Error Saving New record";
				}
			}
			else
			{
				$check=mysqli_query($sql, "UPDATE `OWNERS` 
				SET `FNAME` = '".$FNAME."', `MNAME` = '".$MNAME."', `LNAME` = '".$LNAME."' , `SOCIAL` = '".$SOCIAL."' , `ADDRESS` = '".$ADDRESS."',
				`CITY` = '".$CITY."', `STATE` = '".$STATE."', `ZIP` = '".$ZIP."', `HPHONE` = '".$HPHONE."', `CPHONE` = '".$CPHONE."', `DOB` = '".$DOB."',
				`EMAIL` = '".$EMAIL."'
				WHERE OWNERID = '".$inc_id."'");
			
				
				if ($check)
				{	
					$status = "Update successfully saved";
				}
				else
				{
					$status = "Error updating record";
					/*var_dump("INSERT INTO `OWNERS` (`OWNERID`, `FNAME`, `MNAME`, `LNAME`, 
				`SOCIAL`, `ADDRESS`, `CITY`, `STATE`, `ZIP`, `HPHONE`, `CPHONE`, `DOB`, `EMAIL`) 
				VALUES ( '".$inc_id."' , '".$FNAME."' , '".$MNAME."' , '".$LNAME."' , '".$SOCIAL."' , '".$ADDRESS."' , '".$CITY."' ,
				'".$STATE."' , '".$ZIP."' , '".$HPHONE."' , '".$CPHONE."' , '".$DOB."' , '".$EMAIL."' )");*/
				}
				
			}
		}
		else 
		{
			if ( $status == "")
			{
				$status = "Correct errors listed below then submit again";
			}
		}
	}
	else
	{
		if ( empty($inc_id) )
		{
			$inc_id = $_REQUEST['ownerid'];
		}
		if ( $inc_id == "new")
		{
			$FNAME="";
			$MNAME="";
			$LNAME="";
			$SOCIAL="";
			$ADDRESS="";
			$CITY="";
			$STATE="";
			$ZIP="";
			$HPHONE="";
			$CPHONE="";
			$DOB="";
			$EMAIL="";
			$FNameErr="";
			$EmailErr="";
			$DOBErr="";
			$status="Please fill out as much information as possible.";
		}
		else
		{

			//session_start();
			
			$sql=mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");
			
			
			if(mysqli_connect_errno($sql))
			{
				print("<tr>
							<td>Failed to connect to MySQL: " . mysqli_connect_error() . ";</td>
							
						</tr>");
			}
			else
			{
				$query=mysqli_query($sql, "
					SELECT * 
					FROM OWNERS
					WHERE OWNERID = ".$inc_id."
				");
				$rowtot = 0;
				while($row=mysqli_fetch_assoc($query)){
					$FNAME=$row["FNAME"];
					$MNAME=$row["MNAME"];
					$LNAME=$row["LNAME"];
					$SOCIAL=$row["SOCIAL"];
					$ADDRESS=$row["ADDRESS"];
					$CITY=$row["CITY"];
					$STATE=$row["STATE"];
					$ZIP=$row["ZIP"];
					$HPHONE=$row["HPHONE"];
					$CPHONE=$row["CPHONE"];
					$DOB=$row["DOB"];
					$EMAIL=$row["EMAIL"];
					$rowtot++;
					$FNameErr="";
					$EmailErr="";
					$DOBErr="";
					$status="Please fill out as much information as possible.";
				}
				if ( $rowtot == 0){
					//header('HTTP/1.0 404 Not Found');
					echo "Add Error Messge";
				}
			}
		}
	}
?>

<link type="text/css" href="css/jquery.datepick.css" rel="stylesheet">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript" src="js/datepick/jquery.datepick.js"></script>

<script type="text/javascript">
	jQuery(function($){
	   $("#inputSocial").mask("999-99-9999");
	   $("#inputHPhone").mask("(999)-999-9999");
	   $("#inputCPhone").mask("(999)-999-9999");
	   $("#inputDOB").mask("9999-99-99");
	});
</script>

<script type="text/javascript">
$(function() {
	$('#inputDOB').datepick({dateFormat: 'yyyy-mm-dd'});
});
</script>

<form id='login' action='<?php echo $_SERVER['PHP_SELF'];?>' method='post' >
<table>
<input type='hidden' id='inputOwnerID' name='inputOwnerID' value='<?php echo "$inc_id" ?> '>
	<tr>
		<td colspan="3"><?echo "$status" ?></td>
	</tr>
	<tr>
		<td>First Name</td>
		<td><input type='text' 	id='inputFName' name='inputFName' value='<?php echo "$FNAME" ?>' maxlength='50' ></td>
		<td><?php echo $FNameErr;?></td>
	</tr>
	<tr>
		<td>Middle Name</td>
		<td><input type='text' 	id='inputMName' name='inputMName' value='<?php echo "$MNAME" ?>'></td>
	</tr>
	
	<tr>
		<td>Last Name</td>
		<td><input type='text' 	id='inputLName' name='inputLName' value='<?php echo "$LNAME" ?>'></td>
	</tr>
	<tr>
		<td>Social Security #</td>
		<td><input type='text' 	id='inputSocial' name='inputSocial' value='<?php echo "$SOCIAL" ?>'></td>
	</tr>
	<tr>
		<td>Address Line</td>
		<td><input type='text' 	id='inputAddress' name='inputAddress' value='<?php echo "$ADDRESS" ?>'></td>
	</tr>
	<tr>
		<td>City</td>
		<td><input type='text' 	id='inputCity' name='inputCity' value='<?php echo "$CITY" ?>'></td>
	</tr>
	<tr>
		<td>State</td>
		<td><input type='text' 	id='inputState' name='inputState' value='<?php echo "$STATE" ?>'></td>
	</tr>
	<tr>
		<td>Zip</td>
		<td><input type='text' 	id='inputZip' name='inputZip' value='<?php echo "$ZIP" ?>'></td>
	</tr>
	<tr>
		<td>Home Phone #</td>
		<td><input type='text' 	id='inputHPhone' name='inputHPhone' value='<?php echo "$HPHONE" ?>'></td>
	</tr>
	<tr>
		<td>Cell Phone #</td>
		<td><input type='text' 	id='inputCPhone' name='inputCPhone' value='<?php echo "$CPHONE" ?>'></td>
	</tr>
	<tr>
		<td>Date of Birth</td>
		<td><input type='text' 	id='inputDOB' name='inputDOB' value='<?php echo "$DOB" ?>'></td>
		<td><?php echo $DOBErr;?></td>
	</tr>
	<tr>
		<td>E-mail</td>
		<td><input type='text' 	id='inputEmail' name='inputEmail' value='<?php echo "$EMAIL" ?>'></td>
		<td><?php echo $EmailErr;?></td>
	
	<tr><td><input type='submit' name='save' value='Save' class='button'><input type='submit' name='back' value='Back to list' class='button'></td>
	<input type='hidden' name='writeRecord' value='1'>
	</tr>
</table>
</form>
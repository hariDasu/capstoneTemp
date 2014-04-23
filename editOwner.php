<?php
	
	session_start();
	if (!isset($_SESSION['AUTH']))
	{
		session_destroy();
		header('Location: signIn.html');
	}
	if ($_SESSION['UTYPE'] == '1')
	{
		header('Location: denied.php');
	}
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
		}
		else
		{
			$FNAME = $_POST['inputFName'];
			$status = 'First Name is empty or invalid';
			$CHECKPASS = false;
		}
		
		if( empty($_POST['inputDOB']) || $DOB=="0000-00-00" || checkdate( intval(substr($DOB,6,2)) , intval(substr($DOB, 8, 2 )) , intval(substr($DOB, 1,4 ) )))
		{
			// if the checks are ok for the email we assign the email address to a variable
		}
		else
		{
			$status = 'Invalid Date of Birth Supplied';
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
			$status = "<FONT COLOR='FF0000'>".$status."</FONT>";
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

<!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/bootstrap-switch.css" rel="stylesheet">
  </head>

  <body>

    <div class="navbar navbar-default navbar" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="splash.php">Spot The Lot - City of Paterson</a>
        </div>
      </div>
    </div><!--/.navbar-collapse -->

<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method="post" class="form-horizontal" role="form" >
	<input type='hidden' id='inputOwnerID' name='inputOwnerID' value='<?php echo "$inc_id" ?> '>
	<div class="col-xs-6 col-xs-offset-3">
        <div class="form-group">
            <label class="col-sm-6 control-label"><?echo "$status" ?></label>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">First Name</label>
            <div class="col-sm-6">
			  <input class="form-control" type='text' 	id='inputFName' name='inputFName' value='<?php echo "$FNAME" ?>' maxlength='50' pattern=".{3,}" required title="First Name is a Required Field" ></td>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Middle Name</label>
            <div class="col-sm-6">
			  <input class="form-control" type='text' 	id='inputMName' name='inputMName' value='<?php echo "$MNAME" ?>' maxlength='50' >
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Last Name</label>
            <div class="col-sm-6">
			  <input class="form-control" type='text' 	id='inputLName' name='inputLName' value='<?php echo "$LNAME" ?>' maxlength='50' >
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Social Security #</label>
            <div class="col-sm-4">
			  <input class="form-control" type='text' 	id='inputSocial' name='inputSocial' value='<?php echo "$SOCIAL" ?>' >
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Address Line</label>
            <div class="col-sm-6">
			  <input class="form-control" type='text' 	id='inputAddress' name='inputAddress' value='<?php echo "$ADDRESS" ?>'>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">City</label>
            <div class="col-sm-4">
			  <input class="form-control" type='text' 	id='inputCity' name='inputCity' value='<?php echo "$CITY" ?>'>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">State</label>
            <div class="col-sm-1">
			  <input class="form-control" type='text' 	id='inputState' name='inputState' value='<?php echo "$STATE" ?>' maxlength='3''>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Zip</label>
            <div class="col-sm-2">
			  <input class="form-control" type='text' 	id='inputZip' name='inputZip' value='<?php echo "$ZIP" ?>'>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Home Phone #</label>
            <div class="col-sm-2">
			  <input class="form-control" type='text' 	id='inputHPhone' name='inputHPhone' value='<?php echo "$HPHONE" ?>'>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Cell Phone #</label>
            <div class="col-sm-2">
			  <input class="form-control" type='text' 	id='inputCPhone' name='inputCPhone' value='<?php echo "$CPHONE" ?>'>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Date of Birth</label>
            <div class="col-sm-2">
			  <input class="form-control" type='text' 	id='inputDOB' name='inputDOB' value='<?php echo "$DOB" ?>'>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">E-mail</label>
            <div class="col-sm-3">
			  <input class="form-control" type='text' 	id='inputEmail' name='inputEmail' value='<?php echo "$EMAIL" ?>' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' title='E-mail must be in the form sample@sampleemail.com' ></td>
            </div>
        </div>
		<input type='submit' name='save' value='Save' class='button'><input type='submit' formnovalidate='formnovalidate' name='back' value='Back to list' class='button'>
		<input type='hidden' name='writeRecord' value='1'>
	</div>
</table>
</form>
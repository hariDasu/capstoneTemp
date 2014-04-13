<?php
	session_start();
	if (!isset($_SESSION['AUTH']))
	{
		session_destroy();
		header('Location: signIn.html');
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
		
	header("Content-Type: text/html");
	
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	
	
	if(isset($_POST['back']))
	{
		header("Location: splashPublic.php");
	}
	
	$sql=mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");
	mysqli_select_db($sql, "paterson");
				
	if(mysqli_connect_errno($sql))
	{
		print("<tr>
					<td>Failed to connect to MySQL: " . mysqli_connect_error() . ";</td>
					
				</tr>");
	}
	
	if(isset($_POST['writeRecord']))
	{
		$userID=$_POST["inputUserID"];
		$FNAME=$_POST["inputFName"];
		$LNAME=$_POST["inputLName"];
		$EMAIL=$_POST["inputEmail"];
		$PASSWORD=$_POST["inputPassword"];
		if ($_SESSION['UTYPE'] == 3)
		{
			$UTYPE = $_POST["inputUType"];
			$selUTYPE = "<select class='form-control' name='inputUType'><option value='1' ";
			if ( $UTYPE == 1)
			{
				$selUTYPE .= " selected";
			}
			$selUTYPE .= ">Volunteer</option>";
			$selUTYPE .= "<option value='2' ";
			if ( $UTYPE == 2)
			{
				$selUTYPE .= " selected";
			}
			$selUTYPE .= ">City Worker</option>";
			$selUTYPE .= "<option value='3' ";
			if ( $UTYPE == 3)
			{
				$selUTYPE .= " selected";
			}
			$selUTYPE .= ">Administrator</option></select>";
			$ACTIVE = $_POST["inputActive"];
			$selACTIVE = "<select class='form-control' name='inputActive'><option value='0' ";
			if ( $ACTIVE == 0)
			{
				$selACTIVE .= " selected";
			}
			$selACTIVE .= ">Inactive</option>";
			$selACTIVE .= "<option value='1' ";
			if ( $ACTIVE == 1)
			{
				$selACTIVE .= " selected";
			}
			$selACTIVE .= ">Validated</option>";
			$selACTIVE .= "<option value='2' ";
			if ( $ACTIVE == 2)
			{
				$selACTIVE .= " selected";
			}
			$selACTIVE .= ">Banned</option></select>";
		}	
		$CHECKPASS=true;
		$status="";
		/*
		if( !empty($PAMOUNT) && is_numeric($PAMOUNT) && $PAMOUNT != '0' )
		{
		}
		else
		{
			$status = 'Payment amount invalid. Must be a number larger than 0';
			$CHECKPASS = false;
		}*/
		if ($CHECKPASS)
		{
			if ($_SESSION['UTYPE'] == 3)
			{
				$check=mysqli_query($sql, "UPDATE `USERS` 
				SET `LNAME` = '".$LNAME."', `FNAME` = '".$FNAME."', `EMAIL` = '".$EMAIL."',
				`PASSWORD` = '".$PASSWORD."', `UTYPE` = '".$UTYPE."', `ACTIVE` = '".$ACTIVE."'
				WHERE USERID = '".$userID."'");
			}
			else
			{
				$check=mysqli_query($sql, "UPDATE `USERS` 
				SET `LNAME` = '".$LNAME."', `FNAME` = '".$FNAME."', `EMAIL` = '".$EMAIL."',
				`PASSWORD` = '".$PASSWORD."'
				WHERE USERID = '".$userID."'");
			}
			
			if ($check)
			{	
				$status = "Update successfully saved";
				
			}
			else
			{
				$status = "Error updating record";
			}
		}
		else 
		{
			$status = "<FONT COLOR='FF0000'>".$status."</FONT>";
			
		}
	}
	else
	{
		if ( empty($userID) )
		{
			$userID = $_REQUEST['userid'];
		}
		

		$query=mysqli_query($sql, "
			SELECT * 
			FROM USERS
			WHERE USERID = ".$userID."
		");
		$rowtot = 0;
		while($row=mysqli_fetch_assoc($query)){
			$FNAME=$row["FNAME"];
			$LNAME=$row["LNAME"];
			$EMAIL=$row["EMAIL"];
			$PASSWORD=$row["PASSWORD"];
			if ($_SESSION['UTYPE'] == 3)
			{
				$UTYPE = $row["UTYPE"];
				$selUTYPE = "<select class='form-control' name='inputUType'><option value='1' ";
				if ( $UTYPE == 1)
				{
					$selUTYPE .= " selected";
				}
				$selUTYPE .= ">Volunteer</option>";
				$selUTYPE .= "<option value='2' ";
				if ( $UTYPE == 2)
				{
					$selUTYPE .= " selected";
				}
				$selUTYPE .= ">City Worker</option>";
				$selUTYPE .= "<option value='3' ";
				if ( $UTYPE == 3)
				{
					$selUTYPE .= " selected";
				}
				$selUTYPE .= ">Administrator</option></select>";
				$ACTIVE = $row["ACTIVE"];
				$selACTIVE = "<select class='form-control' name='inputActive'><option value='0' ";
				if ( $ACTIVE == 0)
				{
					$selACTIVE .= " selected";
				}
				$selACTIVE .= ">Inactive</option>";
				$selACTIVE .= "<option value='1' ";
				if ( $ACTIVE == 1)
				{
					$selACTIVE .= " selected";
				}
				$selACTIVE .= ">Validated</option>";
				$selACTIVE .= "<option value='2' ";
				if ( $ACTIVE == 2)
				{
					$selACTIVE .= " selected";
				}
				$selACTIVE .= ">Banned</option></select>";
			}
			$rowtot++;
			$status="Please Modify any fields necessary";
			if ( $rowtot == 0){
				//header('HTTP/1.0 404 Not Found');
				echo "Add Error Messge";
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
	   $("#inputPDate").mask("9999-99-99");
	});
</script>

<script type="text/javascript">
$(function() {
	$('#inputPDate').datepick({dateFormat: 'yyyy-mm-dd'});
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
	<input type='hidden' id='inputUserID' name='inputUserID' value='<?php echo "$userID" ?> '>
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
            <label class="col-sm-3 control-label">Last Name</label>
            <div class="col-sm-6">
			  <input class="form-control" type='text' 	id='inputLName' name='inputLName' value='<?php echo "$LNAME" ?>' maxlength='50' >
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">E-mail</label>
            <div class="col-sm-3">
			  <input class="form-control" type='text' 	id='inputEmail' name='inputEmail' value='<?php echo "$EMAIL" ?>' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' title='E-mail must be in the form sample@sampleemail.com' ></td>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Password</label>
            <div class="col-sm-3">
			  <input class="form-control" type='password' 	id='inputPassword' name='inputPassword' value='<?php echo "$PASSWORD" ?>' ></td>
            </div>
        </div>
		
		<?php 
		if ($_SESSION['UTYPE'] == 3)
		{
			print('
			<div class="form-group">
				<label class="col-sm-3 control-label">User Type</label>
				<div class="col-sm-3">'.$selUTYPE.'
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">User Status</label>
				<div class="col-sm-3">
				  '.$selACTIVE.'
				</div>
			</div>');
		}
		?>
	<tr><td><input type='submit' name='save' value='Save' class='button'><input type='submit' name='back' value='Back to dashboard' class='button'></td>
	<input type='hidden' name='writeRecord' value='1'>
	</div>
</form>
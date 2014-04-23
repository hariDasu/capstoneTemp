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
		
	header("Content-Type: text/html");
	
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	
	
	if(isset($_POST['back']))
	{
		header("Location: listNotices.php");
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
		$inc_id=$_POST["inputNoticeID"];
		$OWNER=$_POST["inputOwner"];
		$TYPE=$_POST["inputNType"];
		$selTYPE = "<select class='form-control' name='inputNType'><option value='1' ";
		if ( $TYPE == 1)
		{
			$selTYPE .= " selected";
		}
		$selTYPE .= ">Notification</option>";
		$selTYPE .= "<option value='2' ";
		if ( $TYPE == 2)
		{
			$selTYPE .= " selected";
		}
		$selTYPE .= ">Invoice</option>";
		$selTYPE .= "<option value='3' ";
		if ( $TYPE == 3)
		{
			$selTYPE .= " selected";
		}
		$selTYPE .= ">Court Summons</option></select>";
		$SDATE=$_POST["inputSDate"];
		$RDATE=$_POST["inputRDate"];
		//$PROPID=$_POST["PROPID"];
		$FEE=$_POST["inputFee"];
		$NOTES=$_POST["inputNotes"];
		$CHECKPASS=true;
		$status="";
		if( checkdate( intval(substr($SDATE,6,2)) , intval(substr($SDATE, 8, 2 )) , intval(substr($SDATE, 1,4 ) )))
		{
			// if the checks are ok for the email we assign the email address to a variable
		}
		else
		{
			$status = 'Invalid Date Sent Supplied';
			$CHECKPASS = false;
		}
		if( empty($RDATE) || $RDATE=="0000-00-00" || checkdate( intval(substr($RDATE,6,2)) , intval(substr($RDATE, 8, 2 )) , intval(substr($RDATE, 1,4 ) )))
		{
			// if the checks are ok for the email we assign the email address to a variable
		}
		else
		{
			$status = 'Invalid Date of Reply Supplied';
			$CHECKPASS = false;
		}
		if ($CHECKPASS)
		{
			
			if( trim($inc_id) == "new" )
			{
				$check=mysqli_query($sql, "INSERT INTO `NOTICES` (`NOTICEID`, `OWNERID`, `NTYPE`, `SDATE`, 
				`RDATE`, `FEE`, `NOTES`) 
				VALUES ( NULL , '".$OWNER."' , '".$TYPE."' , '".$SDATE."' , '".$RDATE."' , '".$FEE."' , '".$NOTES."' )");
			
				if ($check)
				{
					$status = "New Notice successfully saved";
					$inc_id = $sql->insert_id;
				}
				else
				{
					$status = "Error Saving New record";
				}
			}
			else
			{
				$check=mysqli_query($sql, "UPDATE `NOTICES` 
				SET `OWNERID` = '".$OWNER."', `NTYPE` = '".$TYPE."', `SDATE` = '".$SDATE."' , `RDATE` = '".$RDATE."', `FEE` = '".$FEE."' , `NOTES` = '".$NOTES."'
				WHERE NOTICEID = '".$inc_id."'");
			
				
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
			$inc_id = $_REQUEST['noticeid'];
		}
		
		if ( $inc_id == "new")
		{
			$OWNER="1";
			$TYPE="1";
			$selTYPE = "<select name='inputNType'><option value='1' selected >Notification</option>";
			$selTYPE .= "<option value='2' >Invoice</option>";
			$selTYPE .= "<option value='3' >Court Summons</option></select>";
			$SDATE="";
			$RDATE="";
			$PROPID="";
			$FEE="";
			$NOTES="";
			$status="Please fill out as much information as possible.";
		}
		else
		{

			$query=mysqli_query($sql, "
				SELECT * 
				FROM NOTICES
				WHERE NOTICEID = ".$inc_id."
			");
			$rowtot = 0;
			while($row=mysqli_fetch_assoc($query)){
				$OWNER=$row["OWNERID"];
				$TYPE=$row["NTYPE"];
				$selTYPE = "<select  class='form-control'  name='inputNType'><option value='1' ";
				if ( $TYPE == 1)
				{
					$selTYPE .= " selected";
				}
				$selTYPE .= ">Notification</option>";
				$selTYPE .= "<option value='2' ";
				if ( $TYPE == 2)
				{
					$selTYPE .= " selected";
				}
				$selTYPE .= ">Invoice</option>";
				$selTYPE .= "<option value='3' ";
				if ( $TYPE == 3)
				{
					$selTYPE .= " selected";
				}
				$selTYPE .= ">Court Summons</option></select>";
				$SDATE=$row["SDATE"];
				$RDATE=$row["RDATE"];
				$PROPID=$row["PROPID"];
				$FEE=$row["FEE"];
				$NOTES=$row["NOTES"];
				$rowtot++;
				$status="Please fill out as much information as possible.";
			}
			if ( $rowtot == 0){
				//header('HTTP/1.0 404 Not Found');
				echo "Add Error Messge";
			}
			
		}
	}
	
	// Setup Selection Box
	$query=mysqli_query($sql, "
		SELECT * 
		FROM OWNERS
		ORDER BY `OWNERS`.`FNAME` ASC 
	");
	$rowtot = 0;
	$selection = "<select  class='form-control' name='inputOwner'>";
	while($row=mysqli_fetch_assoc($query)){
		$result[]=$row;
		$rowtot++;
	}
	if ( $rowtot > 0)
	{
		foreach($result as $key=>$value){
			$selection .= "<option value='";
			$selection .= $value["OWNERID"];
			$selection .= "'";
			if ( $OWNER == $value["OWNERID"])
			{
				$selection .= " selected";
			}
			
			$selection .= ">";
			$selection .= $value["FNAME"];
			$selection .= " ";
			$selection .= $value["LNAME"];
			$selection .= "</option>";
		}
		$selection .= "</select>";
	}
	else
	{
		print("<tr>
				<td> No Owners on File - Click Add Owner to continue</td>
				</tr>");
	}
?>

<link type="text/css" href="css/jquery.datepick.css" rel="stylesheet">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript" src="js/datepick/jquery.datepick.js"></script>

<script type="text/javascript">
	jQuery(function($){
	   $("#inputSDate").mask("9999-99-99");
	   $("#inputRDate").mask("9999-99-99");
	});
</script>

<script type="text/javascript">
$(function() {
	$('#inputSDate').datepick({dateFormat: 'yyyy-mm-dd'});
	$('#inputRDate').datepick({dateFormat: 'yyyy-mm-dd'});
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
<input type='hidden' id='inputNoticeID' name='inputNoticeID' value='<?php echo "$inc_id" ?> '>
	<div class="col-xs-6 col-xs-offset-3">
        <div class="form-group">
            <label class="col-sm-6 control-label"><?echo "$status" ?></label>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Notice To - Owner</label>
            <div class="col-sm-6">
			  <?php echo $selection;?>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Notice Type</label>
            <div class="col-sm-3">
			  <?php echo $selTYPE;?>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Date Sent</label>
            <div class="col-sm-2">
			  <input class="form-control" type='text' 	id='inputSDate' name='inputSDate' value='<?php echo "$SDATE" ?>'>
            </div>
		</div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Date Received</label>
            <div class="col-sm-2">
			  <input class="form-control" type='text' 	id='inputRDate' name='inputRDate' value='<?php echo "$RDATE" ?>'>
            </div>
		</div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Notice Fee</label>
            <div class="col-sm-2">
			  <input class="form-control" type='number' 	id='inputFee' name='inputFee' value='<?php echo "$FEE" ?>'>
            </div>
		</div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Notes </label>
            <div class="col-sm-6">
			  <textarea rows='7' cols='60' class='form-control' id='inputNotes' name='inputNotes'><?php echo "$NOTES" ?></textarea>
            </div>
		</div>
		<input type='submit' name='save' value='Save' class='button'><input type='submit' formnovalidate='formnovalidate' name='back' value='Back to list' class='button'>
		<input type='hidden' name='writeRecord' value='1'>
	</div>
<?php
	include 'listPayments.php';
?>
</form>
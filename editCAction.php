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
		header("Location: listCourtA.php");
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
		$inc_id=$_POST["inputCActionID"];
		$OWNER=$_POST["inputOwner"];
		$PROPID=$_POST["inputProperty"];
		$CDATE=$_POST["inputCDate"];
		$ADESC=$_POST["inputADesc"];
		$CDISP=$_POST["inputCDisp"];
		$CHECKPASS=true;
		$status="";
		if( checkdate( intval(substr($CDATE,6,2)) , intval(substr($CDATE, 8, 2 )) , intval(substr($CDATE, 1,4 ) )))
		{
			// if the checks are ok for the email we assign the email address to a variable
		}
		else
		{
			$status = 'Invalid Court Date Supplied';
			$CHECKPASS = false;
		}
		$rowtot = 0;
		unset($result);
		unset($query);
		unset($result);
		$query=mysqli_query($sql, "
			SELECT * 
			FROM PROPERTY
			WHERE `PROPID` = ".$PROPID."
			AND `OWNERID` = ".$OWNER."
		");
		$valid = mysqli_affected_rows($sql);
		if ($valid)
		{
		}
		else
		{
			$status = 'Owner selected is not associated with the property selected.';
			$CHECKPASS= false;
		}
		
		if ($CHECKPASS)
		{
			
			if( trim($inc_id) == "new" )
			{
				$check=mysqli_query($sql, "INSERT INTO `CACTIONS` (`COURTID`, `OWNERID`, `PROPID`, `CDATE`, 
				`CDISP`, `ADESC`) 
				VALUES ( NULL , '".$OWNER."' , '".$PROPID."' , '".$CDATE."' , '".$CDISP."' , '".$ADESC."' )");
			
				if ($check)
				{
					$status = "New Court Action successfully saved";
					$inc_id = $sql->insert_id;
				}
				else
				{
					$status = "Error Saving New record";
				}
			}
			else
			{
				$check=mysqli_query($sql, "UPDATE `CACTIONS` 
				SET `OWNERID` = '".$OWNER."', `PROPID` = '".$PROPID."', `CDATE` = '".$CDATE."' , `ADESC` = '".$ADESC."' , `CDISP` = '".$CDISP."'
				WHERE COURTID = '".$inc_id."'");
			
				
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
			$inc_id = $_REQUEST['courtid'];
		}
		
		if ( $inc_id == "new")
		{
			$OWNER="1";
			$PROPID="";
			$CDATE="";
			$CDISP="";
			$ADESC="";
			$status="Please fill out as much information as possible.";
		}
		else
		{

			$query=mysqli_query($sql, "
				SELECT * 
				FROM CACTIONS
				WHERE COURTID = ".$inc_id."
			");
			$rowtot = 0;
			while($row=mysqli_fetch_assoc($query)){
				$OWNER=$row["OWNERID"];
				$CDATE=$row["CDATE"];
				$PROPID=$row["PROPID"];
				$CDISP=$row["CDISP"];
				$ADESC=$row["ADESC"];
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
	$selection = "<select class='form-control' name='inputOwner'>";
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
	$rowtot = 0;
	unset($result);
	unset($query);
	unset($result);
	$query=mysqli_query($sql, "
		SELECT * 
		FROM PROPERTY
		ORDER BY `ADDRNUM`,`STREET` ASC 
	");
	$pselection = "<select class='form-control' name='inputProperty'>";
	while($row=mysqli_fetch_assoc($query)){
		$result[]=$row;
		$rowtot++;
	}
	if ( $rowtot > 0)
	{
		foreach($result as $key=>$value){
			$pselection .= "<option value='";
			$pselection .= $value["PROPID"];
			$pselection .= "'";
			if ( $PROPID == $value["PROPID"])
			{
				$pselection .= " selected";
			}
			
			$pselection .= ">";
			$pselection .= $value["ADDRNUM"];
			$pselection .= " ";
			$pselection .= $value["STREET"];
			$pselection .= "</option>";
		}
		$pselection .= "</select>";
	}
	
?>

<link type="text/css" href="css/jquery.datepick.css" rel="stylesheet">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript" src="js/datepick/jquery.datepick.js"></script>

<script type="text/javascript">
	jQuery(function($){
	   $("#inputCDate").mask("9999-99-99");
	});
</script>

<script type="text/javascript">
$(function() {
	$('#inputCDate').datepick({dateFormat: 'yyyy-mm-dd'});
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
	
	<input type='hidden' id='inputCActionID' name='inputCActionID' value='<?php echo "$inc_id" ?> '>
	
	<div class="col-xs-6 col-xs-offset-3">
        <div class="form-group">
            <label class="col-sm-6 control-label"><?echo "$status" ?></label>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Action Against - Owner</label>
            <div class="col-sm-6">
			  <?php echo $selection;?>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Action Against - Property</label>
            <div class="col-sm-6">
			  <?php echo $pselection;?>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Court Date</label>
            <div class="col-sm-2">
			  <input class="form-control" type='text' 	id='inputCDate' name='inputCDate' value='<?php echo "$CDATE" ?>'>
            </div>
		</div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Action Description </label>
            <div class="col-sm-6">
			  <textarea rows='7' cols='60' class='form-control' id='inputADesc' name='inputADesc'><?php echo "$ADESC" ?></textarea>
            </div>
		</div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Court Disposition </label>
            <div class="col-sm-6">
			  <textarea rows='7' cols='60' class='form-control' id='inputCDisp' name='inputCDisp'><?php echo "$CDISP" ?></textarea>
            </div>
		</div>
	<input type='submit' name='save' value='Save' class='button'><input type='submit' name='back' value='Back to list' class='button'>
	<input type='hidden' name='writeRecord' value='1'>
	</div>
</form>
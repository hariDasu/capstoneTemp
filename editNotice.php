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
		$selTYPE = "<select name='inputNType'><option value='1' ";
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
			$SDATEErr = '';
		}
		else
		{
			$SDATEErr = 'Invalid Date Sent Supplied';
			$CHECKPASS = false;
		}
		if( empty($RDATE) || $RDATE=="0000-00-00" || checkdate( intval(substr($RDATE,6,2)) , intval(substr($RDATE, 8, 2 )) , intval(substr($RDATE, 1,4 ) )))
		{
			// if the checks are ok for the email we assign the email address to a variable
			$RDATEErr = '';
		}
		else
		{
			$RDATEErr = 'Invalid Date of Reply Supplied';
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
			if ( $status == "")
			{
				$status = "Correct errors listed below then submit again";
			}
		}
	}
	else
	{
		$inc_id = $_REQUEST['noticeid'];
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
			$SDATEErr="";
			$RDATEErr="";
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
				$selTYPE = "<select name='inputNType'><option value='1' ";
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
				$RDATEErr="";
				$SDATEErr="";
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
	$selection = "<select name='inputOwner'>";
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
$(function() {
	$('#inputSDate').datepick({dateFormat: 'yyyy-mm-dd'});
	$('#inputRDate').datepick({dateFormat: 'yyyy-mm-dd'});
});
</script>

<form id='login' action='<?php echo $_SERVER['PHP_SELF'];?>' method='post' >
<table>
<input type='hidden' id='inputNoticeID' name='inputNoticeID' value='<?php echo "$inc_id" ?> '>
	<tr>
		<td colspan="3"><?echo "$status" ?></td>
	</tr>
	<tr>
		<td>Notice To - Owner</td>
		<td><?php echo $selection;?></td>
	</tr>
	<tr>
		<td>Notice Type</td>
		<td><?php echo $selTYPE;?></td>
	</tr>
	<tr>
		<td>Date Sent</td>
		<td><input type='text' 	id='inputSDate' name='inputSDate' value='<?php echo "$SDATE" ?>'></td>
		<td><?php echo $SDATEErr;?></td>
	</tr>
	<tr>
		<td>Response Received Date</td>
		<td><input type='text' 	id='inputRDate' name='inputRDate' value='<?php echo "$RDATE" ?>'></td>
		<td><?php echo $RDATEErr;?></td>
	</tr>
	<tr>
		<td>Notice Fee</td>
		<td><input type='text' 	id='inputFee' name='inputFee' value='<?php echo "$FEE" ?>'></td>
	</tr>
	<tr>
		<td>Notes</td>
		<td><textarea rows='7' cols='60' maxlength='400' name='inputNotes'><?php echo "$NOTES" ?></textarea></td>
	</tr>
	<tr><td><input type='submit' name='save' value='Save' class='button'><input type='submit' name='back' value='Back to list' class='button'></td>
	<input type='hidden' name='writeRecord' value='1'>
	</tr>
</table>
</form>
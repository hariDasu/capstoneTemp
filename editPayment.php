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
		
	header("Content-Type: text/html");
	
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	
	
	if(isset($_POST['back']))
	{
		$noticeID=$_POST["inputNoticeID"];
		header("Location: editNotice.php?noticeid=".$noticeID);
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
		$noticeID=$_POST["inputNoticeID"];
		$paymentID=$_POST["inputPaymentID"];
		$PTYPE=$_POST["inputPType"];
		$selPTYPE = "<select name='inputPType'><option value='1' ";
		if ( $PTYPE == 1)
		{
			$selPTYPE .= " selected";
		}
		$selPTYPE .= ">Cash</option>";
		$selPTYPE .= "<option value='2' ";
		if ( $PTYPE == 2)
		{
			$selPTYPE .= " selected";
		}
		$selPTYPE .= ">Credit Card</option>";
		$selPTYPE .= "<option value='3' ";
		if ( $PTYPE == 3)
		{
			$selPTYPE .= " selected";
		}
		$selPTYPE .= ">Check</option></select>";
		$PDATE=$_POST["inputPDate"];
		//$PROPID=$_POST["PROPID"];
		$PAMOUNT=$_POST["inputPAmount"];
		$CHECKPASS=true;
		$status="";
		if( checkdate( intval(substr($PDATE,6,2)) , intval(substr($PDATE, 8, 2 )) , intval(substr($PDATE, 1,4 ) )))
		{
			$PDATEErr = '';
		}
		else
		{
			$PDATEErr = 'Invalid Payment Date Supplied';
			$CHECKPASS = false;
		}
		if( !empty($PAMOUNT) && is_numeric($_GET['id']) && $PAMOUNT != '0' )
		{
			$PAMOUNTErr = '';
		}
		else
		{
			$PAMOUNTErr = 'Payment amount invalid. Must be a number larger than 0';
			$CHECKPASS = false;
		}
		if ($CHECKPASS)
		{
			
			if( trim($paymentID) == "new" )
			{
				$check=mysqli_query($sql, "INSERT INTO `PAYMENTS` ( `PAYID`, `NOTICEID`, `PTYPE`, `PDATE`, `PAMOUNT` )
				VALUES ( NULL , '".$noticeID."' , '".$PTYPE."' , '".$PDATE."' , '".$PAMOUNT."' )");
			
				if ($check)
				{
					$status = "New Payment successfully saved";
					$paymentID = $sql->insert_id;
				}
				else
				{
					$status = "Error Saving New record";
				}
			}
			else
			{
				$check=mysqli_query($sql, "UPDATE `PAYMENTS` 
				SET `PTYPE` = '".$PTYPE."', `PDATE` = '".$PDATE."', `PAMOUNT` = '".$PAMOUNT."'
				WHERE PAYID = '".$paymentID."'");
			
				
				if ($check)
				{	
					$status = "Update successfully saved";
					
				}
				else
				{
					$status = "Error updating record";
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
		if ( empty($paymentID) )
		{
			$paymentID = $_REQUEST['paymentid'];
		}
		if ( $paymentID == "new")
		{
			$noticeID = $_REQUEST['noticeid'];
			$PTYPE="1";
			$selPTYPE = "<select name='inputPType'><option value='1' selected >Cash</option>";
			$selPTYPE .= "<option value='2' >Credit Card</option>";
			$selPTYPE .= "<option value='3' >Check</option></select>";
			$PDATE="";
			$PAMOUNT="";
			$PDATEErr="";
			$PAMOUNTErr = "";
			$status="Please fill out as much information as possible.";
		}
		else
		{

			$query=mysqli_query($sql, "
				SELECT * 
				FROM PAYMENTS
				WHERE PAYID = ".$paymentID."
			");
			$rowtot = 0;
			while($row=mysqli_fetch_assoc($query)){
				$noticeID = $row["NOTICEID"];
				$PTYPE=$row["PTYPE"];
				$selPTYPE = "<select name='inputPType'><option value='1' ";
				if ( $PTYPE == 1)
				{
					$selPTYPE .= " selected";
				}
				$selPTYPE .= ">Cash</option>";
				$selPTYPE .= "<option value='2' ";
				if ( $PTYPE == 2)
				{
					$selPTYPE .= " selected";
				}
				$selPTYPE .= ">Credit Card</option>";
				$selPTYPE .= "<option value='3' ";
				if ( $PTYPE == 3)
				{
					$selPTYPE .= " selected";
				}
				$selPTYPE .= ">Check</option></select>";
				$PDATE=$row["PDATE"];
				$PAMOUNT=$row["PAMOUNT"];
				$PDATEErr="";
				$PAMOUNTErr="";
				$rowtot++;
				$status="Please fill out as much information as possible.";
			}
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
$(function() {
	$('#inputSDate').datepick({dateFormat: 'yyyy-mm-dd'});
	$('#inputRDate').datepick({dateFormat: 'yyyy-mm-dd'});
});
</script>

<form id='login' action='<?php echo $_SERVER['PHP_SELF'];?>' method='post' >
<table>
	<tr>
		<td colspan="3"><?echo "$status" ?></td>
	</tr>
	<tr>
		<td>Notice # </td>
		<td><?php echo $noticeID;?></td>
		<input type='hidden' id='inputNoticeID' name='inputNoticeID' value='<?php echo "$noticeID" ?> '>
		<input type='hidden' id='inputPaymentID' name='inputPaymentID' value='<?php echo "$paymentID" ?> '>
	</tr>
	<tr>
		<td>Payment Type</td>
		<td><?php echo $selPTYPE;?></td>
	</tr>
	<tr>
		<td>Payment Date</td>
		<td><input type='text' 	id='inputSDate' name='inputPDate' value='<?php echo "$PDATE" ?>'></td>
		<td><?php echo $PDATEErr;?></td>
	</tr>
	<tr>
		<td>Payment Amount</td>
		<td><input type='text' 	id='inputPAmount' name='inputPAmount' value='<?php echo "$PAMOUNT" ?>'></td>
		<td><?php echo $PAMOUNTErr;?></td>
	</tr>
	<tr><td><input type='submit' name='save' value='Save' class='button'><input type='submit' name='back' value='Back to list' class='button'></td>
	<input type='hidden' name='writeRecord' value='1'>
	</tr>
</table>
</form>
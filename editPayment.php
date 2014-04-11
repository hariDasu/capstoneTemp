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
		$selPTYPE = "<select class='form-control' name='inputPType'><option value='1' ";
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
		}
		else
		{
			$status = 'Invalid Payment Date Supplied';
			$CHECKPASS = false;
		}
		if( !empty($PAMOUNT) && is_numeric($PAMOUNT) && $PAMOUNT != '0' )
		{
		}
		else
		{
			$status = 'Payment amount invalid. Must be a number larger than 0';
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
			$status = "<FONT COLOR='FF0000'>".$status."</FONT>";
			
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
			$selPTYPE = "<select class='form-control' name='inputPType'><option value='1' selected >Cash</option>";
			$selPTYPE .= "<option value='2' >Credit Card</option>";
			$selPTYPE .= "<option value='3' >Check</option></select>";
			$PDATE="";
			$PAMOUNT="";
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
				$selPTYPE = "<select class='form-control' name='inputPType'><option value='1' ";
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
	<input type='hidden' id='inputNoticeID' name='inputNoticeID' value='<?php echo "$noticeID" ?> '>
	<input type='hidden' id='inputPaymentID' name='inputPaymentID' value='<?php echo "$paymentID" ?> '>
	<div class="col-xs-6 col-xs-offset-3">
        <div class="form-group">
            <label class="col-sm-6 control-label"><?echo "$status" ?></label>
        </div>
		<div class="form-group">
            <label class="col-sm-4 control-label">Notice # <?php echo $noticeID;?></label>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Payment Type</label>
            <div class="col-sm-3">
			  <?php echo $selPTYPE;?>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Payment Date</label>
            <div class="col-sm-2">
			  <input class="form-control" type='text' 	id='inputPDate' name='inputPDate' value='<?php echo "$PDATE" ?>'>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-3 control-label">Payment Amount</label>
            <div class="col-sm-2">
			  <input class="form-control" type='number' 	id='inputPAmount' name='inputPAmount' value='<?php echo "$PAMOUNT" ?>' pattern=".{3,}" required title="Payment Amount is a required field"'>
            </div>
		</div>
	
	<tr><td><input type='submit' name='save' value='Save' class='button'><input type='submit' name='back' value='Back to list' class='button'></td>
	<input type='hidden' name='writeRecord' value='1'>
	</div>
</form>
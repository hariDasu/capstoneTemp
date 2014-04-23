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
    
  //  header("Content-Type: text/html");
    
    ini_set('display_errors',1);
    error_reporting(E_ALL);

    if(isset($_POST['back']))
    {
        if($_SESSION['UTYPE']=="1"){
            header("Location: splashPublic.php");
        }elseif($_SESSION['UTYPE']=="2" || $_SESSION['UTYPE']=="3" ){
            header("Location: splashPublic.php");
        }
        else{
            header("Location: splash.php");
        }
    }
    
    
    $sql=mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");
    mysqli_select_db($sql, "paterson");
    
    if(isset($_GET['property_id'])){
        $_SESSION['PROPID']=(int)$_GET['property_id'];
    }
    $PROPID = (int)$_SESSION['PROPID'];
   

                
    if(mysqli_connect_errno($sql))
    {
        print("<tr>
                    <td>Failed to connect to MySQL: " . mysqli_connect_error() . ";</td>
                    
                </tr>");
    }

if(isset($_POST['writeRecord'])) {
    $PROPID = $_SESSION['PROPID'];
    $BLOCK = $_POST["inputBlock"];
    $LOT = $_POST["inputLot"];
    $WARD = $_POST["inputWard"];
    $ADDRNUM = trim($_POST["inputAddrNum"]);
    $STREET = trim($_POST["inputStreet"]);
    $ZIP = $_POST["inputZip"];
    $BOARDED= $_POST["inputBoarded"];
    $SPOST = $_POST["inputSign"];
    $PDESC = $_POST["inputDescription"];
    $LCOMMENT = $_POST["inputComments"];
    if($_SESSION['UTYPE']=='2' || $_SESSION['UTYPE']=='3'){
        $OWNERID=$_POST["OWNERID"];
        $PAMSPIN=$_POST["PAMSPIN"];
        $AGENTID=$_POST["AGENTID"];
        $VDATE=$_POST["VDATE"];
        $VERIFIED=$_POST["VERIFIED"];
    }
    $CHECKPASS=true;
    $status="";
        
        // check the POST variable userName is sane, and is not empty
        if(empty($_POST['inputAddrNum'])==FALSE && sanityCheck($_POST['inputAddrNum'], 'string', 10) != FALSE){
         //If all is well we can  assign the value of POST field to a variable
            $ADDRNUM = $_POST['inputAddrNum'];
            $ADDRNUMErr = '';
        }
        else{
            $ADDRNUM = $_POST['inputAddrNum'];
            $ADDRNUMErr = 'Building number is empty or invalid';
            $CHECKPASS = false;
        }

        //check street valid
        if(empty($_POST['inputStreet'])==FALSE && sanityCheck($_POST['inputStreet'], 'string', 50) != FALSE){
            // if the checks are ok assign the street to a variable
            $STREET=$_POST["inputStreet"];
            $STREETErr = '';
        }
        else{
            $STREET=$_POST["inputStreet"];
            $STREETErr = 'Invalid Street Supplied';
            $CHECKPASS = false;
        }

        if( empty($_POST['VDATE']) || $VDATE=="0000-00-00" || checkdate( intval(substr($VDATE,6,2)) , intval(substr($VDATE, 8, 2 )) , intval(substr($VDATE, 1,4 ) )))
        {
            // if the checks are ok for the email we assign the email address to a variable
        }
        else
        {
            $status = 'Invalid Date of vacant date Supplied';
            $CHECKPASS = false;
        }

        if ($CHECKPASS)
        {
            
            $sql=mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");
            mysqli_select_db($sql, "paterson");




            if(mysqli_connect_errno($sql))
            {
                $status = "Failed to connect to MySQL: " . mysqli_connect_error() ;
            }
            else 
            {
             
                if($_SESSION['UTYPE']=="1"){
                    $check="UPDATE `PROPERTY` 
                    SET BLOCK = '$BLOCK', LOT = '$LOT', WARD = '$WARD', ADDRNUM = '$ADDRNUM', STREET = '$STREET', ZIP = '$ZIP', 
                    BOARDED = '$BOARDED', SPOST = '$SPOST', PDESC = '$PDESC', LCOMMENT = '$LCOMMENT' WHERE PROPID = '$PROPID'";

                    mysqli_query($sql, $check);
                    if (!mysqli_query($sql,$check))
                     {
                      die('Error: ' . mysqli_error($sql));
                    }
                    else{
                        print '<script type="text/javascript">'; 
                        print 'alert("Changes saved")'; 
                        print '</script>'; 
                        
                    }
                }
                elseif($_SESSION['UTYPE']=="2" || $_SESSION['UTYPE']=="3"){
                    $check="UPDATE `PROPERTY` 
                    SET BLOCK = '$BLOCK', LOT = '$LOT', WARD = '$WARD', ADDRNUM = '$ADDRNUM', STREET = '$STREET', ZIP = '$ZIP', 
                    BOARDED = '$BOARDED', SPOST = '$SPOST', PDESC = '$PDESC', LCOMMENT = '$LCOMMENT', OWNERID='$OWNERID', 
                            PAMSPIN='$PAMSPIN', AGENTID='$AGENTID', VDATE='$VDATE', VERIFIED='$VERIFIED' WHERE PROPID = '$PROPID'";

                    mysqli_query($sql, $check);
                    if (!mysqli_query($sql,$check))
                     {
                      die('Error: ' . mysqli_error($sql));
                    }
                    else{
                        print '<script type="text/javascript">'; 
                        print 'alert("Changes saved")'; 
                        print '</script>'; 
                        
                    }
                }
            }
        
            if ( $status == "")
            {
                $status = "Correct errors listed below then submit again";
            }
        }
    }
    else
    {
        

            $sql=mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");


            if(mysqli_connect_errno($sql))
            {
                print("<tr>
                            <td>Failed to connect to MySQL: " . mysqli_connect_error() . ";</td>
                            
                        </tr>");
            }
            else{
            
                $query=mysqli_query($sql, "SELECT * 
                    FROM PROPERTY
                    WHERE PROPID = '$PROPID'");
                $rowtot = 0;
                while($row=mysqli_fetch_assoc($query)){
					if ($_SESSION['UTYPE'] == '1' && $_SESSION['USERID'] !== $row['LUSERID'] )	
					{
						header('Location: denied.php');
					}
                    $BLOCK=$row["BLOCK"];
                    $LOT=$row["LOT"];
                    $WARD=$row["WARD"];
                    $ADDRNUM=$row["ADDRNUM"];
                    $STREET=$row["STREET"];
                    $ZIP=$row["ZIP"];
                    $BOARDED=$row["BOARDED"];
                    $SPOST=$row["SPOST"];
                    $PDESC=$row["PDESC"];
                    $LCOMMENT=$row["LCOMMENT"];
                    $rowtot++;
                    if($_SESSION['UTYPE']=='2' || $_SESSION['UTYPE']=='3'){
                        $OWNERID=$row["OWNERID"];
                        $PAMSPIN=$row["PAMSPIN"];
                        $AGENTID=$row["AGENTID"];
                        $VDATE=$row["VDATE"];
                        $VERIFIED=$row["VERIFIED"];
                    }
                    $status="Please fill out as much information as possible.";
                }
                if ( $rowtot == 0){
                    //header('HTTP/1.0 404 Not Found');
                    echo "Add Error Messge";
                }
            }
        
    }
	$BOARDSEL = "<select class='form-control' name='inputBoarded'><option value='1' ";
	if ( $BOARDED == 1)
	{
		$BOARDSEL .= " selected";
	}
	$BOARDSEL .= ">Yes</option>";
	$BOARDSEL .= "<option value='2' ";
	if ( $BOARDED == 2)
	{
		$BOARDSEL .= " selected";
	}
	$BOARDSEL .= ">No</option></select>";
	$SIGNSEL = "<select class='form-control' name='inputSign'><option value='1' ";
	if ( $SPOST == 1)
	{
		$SIGNSEL .= " selected";
	}
	$SIGNSEL .= ">Yes</option>";
	$SIGNSEL .= "<option value='2' ";
	if ( $SPOST == 2)
	{
		$SIGNSEL .= " selected";
	}
	$SIGNSEL .= ">No</option></select>";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Spot The Lot - City of Paterson</title>

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
	
<link type="text/css" href="css/jquery.datepick.css" rel="stylesheet">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript" src="js/datepick/jquery.datepick.js"></script>

<script type="text/javascript">
	jQuery(function($){
	   $("#VDATE").mask("9999-99-99");
	});
</script>

<script type="text/javascript">
$(function() {
	$('#VDATE').datepick({dateFormat: 'yyyy-mm-dd'});
});
</script>

 <div class="container-fluid">
    <div class="row">
        <br>
        <a href="splashPublic.php">Return to your entries... </a>   
    </div>  

  <div class="row">
  
  
<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method="post" class="form-horizontal" role="form" >
  <input type="hidden" name="property_id" value="<?=$property_id ?> ">
    <div class="col-xs-6 col-xs-offset-3">
    
        <div class="form-group">
            <label for="inputBlock" class="col-sm-3 control-label">Block</label>
            <div class="col-sm-9">
              <input  class="form-control" id="inputBlock" name="inputBlock" type="number" value="<?=$BLOCK;?>">
            </div>
        </div>

        <div class="form-group">
            <label for="inputLot" class="col-sm-3 control-label">Lot</label>
            <div class="col-sm-9">
                <input  class="form-control" id="inputLot" name="inputLot" type="number" value="<?=$LOT;?>">
            </div>
        </div>

        <div class="form-group">
            <label for="inputWard" class="col-sm-3 control-label">Ward</label>
            <div class="col-sm-9">
                <input class="form-control" id="inputWard" name="inputWard" type="number" value="<?=$WARD;?>">
            </div>
        </div>
              
        <div class="form-group">
            <label for="inputAddrNum" class="col-sm-3 control-label">Address Number</label>
            <div class="col-sm-9">
                <input class="form-control" id="inputAddrNum" name="inputAddrNum" value="<?=$ADDRNUM;?>">
            </div>
        </div>
      
        <div class="form-group">
            <label for="inputStreet" class="col-sm-3 control-label">Street</label>
            <div class="col-sm-9">
             <input class="form-control" id="inputStreet" name="inputStreet" value="<?=$STREET;?>">
            </div>
        </div>

        <div class="form-group">
            <label for="inputZip" class="col-xs-3 control-label">Zip code</label>
            <div class="col-xs-4">
                <input  class="form-control" id="inputZip" name="inputZip" type="text" pattern="^[0-9]{5}$" maxlength="5" value="<?=$ZIP;?>">
            </div>
        </div>

        <div class="form-group">
            <label for="inputBoarded" class="col-xs-3 control-label">Boarded</label>
            <div class="col-xs-2">
				<?=$BOARDSEL;?>
            </div>
        </div>

        <div class="form-group">
            <label for="inputSign" class="col-xs-3 control-label">Sign</label>
            <div class="col-xs-2">
                <?=$SIGNSEL;?>
            </div>
        </div>
        
        <div class="form-group">
            <label for="inputDescription" class="col-sm-3 control-label">Property Description</label>
            <div class="col-sm-9">
                <textarea rows='7' cols='60' class='form-control' id='inputDescription' name='inputDescription'><?php echo "$PDESC" ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="inputComments" class="col-sm-3 control-label">Comments</label>
            <div class="col-sm-9">
				<textarea rows='7' cols='60' class='form-control' id='inputComments' name='inputComments'><?php echo "$LCOMMENT" ?></textarea>				
            </div>
        </div>
                      
    


   <!--user type 2 or 3-->
   <?php if($_SESSION['UTYPE']=='2' || $_SESSION['UTYPE']=='3') :
   
   $query=mysqli_query($sql, "
		SELECT * 
		FROM OWNERS
		ORDER BY `OWNERS`.`FNAME` ASC 
	");
	$rowtot = 0;
	$OWNERSEL = "<select class='form-control' name='OWNERID'>";
	while($row=mysqli_fetch_assoc($query)){
		$result[]=$row;
		$rowtot++;
	}
	if ( $rowtot > 0)
	{
		foreach($result as $key=>$value){
			$OWNERSEL .= "<option value='";
			$OWNERSEL .= $value["OWNERID"];
			$OWNERSEL .= "'";
			if ( $OWNERID == $value["OWNERID"])
			{
				$OWNERSEL .= " selected";
			}
			
			$OWNERSEL .= ">";
			$OWNERSEL .= $value["FNAME"];
			$OWNERSEL .= " ";
			$OWNERSEL .= $value["LNAME"];
			$OWNERSEL .= "</option>";
		}
		$OWNERSEL .= "</select>";
	}
	$rowtot = 0;
	unset($result);
	unset($query);
	
	$query=mysqli_query($sql, "
		SELECT * 
		FROM OWNERS
		ORDER BY `OWNERS`.`FNAME` ASC 
	");
	$rowtot = 0;
	$AGENTSEL = "<select class='form-control' name='AGENTID'>";
	while($row=mysqli_fetch_assoc($query)){
		$result[]=$row;
		$rowtot++;
	}
	if ( $rowtot > 0)
	{
		foreach($result as $key=>$value){
			$AGENTSEL .= "<option value='";
			$AGENTSEL .= $value["OWNERID"];
			$AGENTSEL .= "'";
			if ( $AGENTID == $value["OWNERID"])
			{
				$AGENTSEL .= " selected";
			}
			
			$AGENTSEL .= ">";
			$AGENTSEL .= $value["FNAME"];
			$AGENTSEL .= " ";
			$AGENTSEL .= $value["LNAME"];
			$AGENTSEL .= "</option>";
		}
		$AGENTSEL .= "</select>";
	}
	
	$VALSEL = "<select class='form-control' name='VERIFIED'><option value='0' ";
	if ( $VERIFIED == 0)
	{
		$VALSEL .= " selected";
	}
	$VALSEL .= ">Not Validated</option>";
	$VALSEL .= "<option value='1' ";
	if ( $VERIFIED == 1)
	{
		$VALSEL .= " selected";
	}
	$VALSEL .= ">Validated</option></select>";
   
   ?>
        <div class="form-group">
            <label for="OWNERID" class="col-sm-3 control-label">Ownerid</label>
            <div class="col-sm-9">
              <?=$OWNERSEL;?>
            </div>
        </div>

        <div class="form-group">
            <label for="PAMSPIN" class="col-sm-3 control-label">PAMSPIN</label>
            <div class="col-sm-9">
                <input  class="form-control" id="PAMSPIN" name="PAMSPIN" type="number" value="<?=$PAMSPIN;?>">
            </div>
        </div>

        <div class="form-group">
            <label for="AGENTID" class="col-sm-3 control-label">AgentID</label>
            <div class="col-sm-9">
                <?=$AGENTSEL;?>
            </div>
        </div>
              
        <div class="form-group">
            <label for="VDATE" class="col-sm-3 control-label">Vacant Date</label>
            <div class="col-sm-3">
                <input class="form-control" type='text' id="VDATE" name="VDATE" value="<?=$VDATE;?>">
            </div>
        </div>
      
        <div class="form-group">
            <label for="inputStreet" class="col-sm-3 control-label">Verified</label>
            <div class="col-sm-3">
             <?=$VALSEL;?>
            </div>
        </div>
                        
        <?php endif; ?>
    </div>
       

    <div><a class="btn btn-default" href="<?php echo( "imgEdit.php?property_id=".$_SESSION['PROPID']) ?>">Edit Images</a></div>
    
    <tr><td><input type='submit' name='save' value='Save' class='btn btn-default'>

            <input type='hidden' name='writeRecord' value='1'>
    </tr>
    </table>
</form>
<?php

session_start();
if (!isset($_SESSION['AUTH']))
{
    session_destroy();
    header('Location: signIn.html');
}
   

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
    
  //  header("Content-Type: text/html");
    
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    
    $sql=mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");
    mysqli_select_db($sql, "paterson");
    
    if(isset($_GET['property_id'])){
        $_SESSION['PROPID']=$_GET['property_id'];
    }
    $PROPID = $_SESSION['PROPID'];
   

                
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
                    //$FNameErr="";
                    //$EmailErr="";
                    //$DOBErr="";
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
            <div class="col-xs-3">
                <input  class="form-control" id="inputBoarded" name="inputBoarded"  pattern="^[yYnN]{1}$" maxlength="1" value="<?=$BOARDED;?>">
            </div>
        </div>

        <div class="form-group">
            <label for="inputSign" class="col-xs-3 control-label">Sign</label>
            <div class="col-xs-3">
                <input  class="form-control" id="inputSign" name="inputSign" pattern="^[yYnN]{1}$" maxlength="1" value="<?=$SPOST;?>">
            </div>
        </div>
        
        <div class="form-group">
            <label for="inputDescription" class="col-sm-3 control-label">Property Description</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="inputDescription" name="inputDescription" value="<?=$PDESC;?>">
            </div>
        </div>

        <div class="form-group">
            <label for="inputComments" class="col-sm-3 control-label">Comments</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="inputComments" name="inputComments" value="<?=$LCOMMENT;?>">
            </div>
        </div>
                      
    </div>
   
    
    <tr><td><input type='submit' name='save' value='Save' class='button'>

            <input type='hidden' name='writeRecord' value='1'>
    </tr>
    </table>
</form>
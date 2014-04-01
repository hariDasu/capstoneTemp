<?php
//variables for mysql
session_start();
if (!isset($_SESSION['AUTH']))
{
    session_destroy();
    header('Location: signIn.html');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $BLOCK = $_POST["inputBlock"];
      $LOT = $_POST["inputLot"];
      $WARD = $_POST["inputWard"];
      $ADDRNUM = $_POST["AddrNum"];
	    $STREET = $_POST["inputStreet"];
      $ZIP = $_POST["inputZip"];
      $BOARDED= $_POST["inputBoarded"];
      $SPOST = $_POST["inputSign"];
      $PDESC = $_POST["inputDescription"];
      $LCOMMENT = $_POST["inputComments"];


      //goes to edit page and keeps the back button from resubmitting
      header("Location: editEntry.php");
      exit;
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

    <title>Abandoned Properties in Paterson</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/bootstrap-switch.css" rel="stylesheet">
  </head>

  <body>

    <div class="navbar navbar-default navbar" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">Abandoned Property List</a>
        </div>
      </div>
    </div><!--/.navbar-collapse -->

    


    <!-- Main  -->
    

    <div class="container">
      
      
      <div>
        <br>
        <a  href="splash.php">Go back... </a>  <br><br>      
      
          <form action="upload.php" method="post" class="form-horizontal pull-left" role="form" enctype="multipart/form-data">

 
              <div class="form-group">
                <label for="inputBlock" class="col-sm-2 control-label">Block</label>
                <div class="col-sm-10">
                  <input  class="form-control" id="inputBlock" name="inputBlock" type="text" placeholder="Block">
                </div>
              </div>

              <div class="form-group">
                <label for="inputLot" class="col-sm-2 control-label">Lot</label>
                <div class="col-sm-10">
                    <input  class="form-control" id="inputLot" name="inputLot" placeholder="Lot">
                  </div>
              </div>

              <div class="form-group">
                <label for="inputWard" class="col-sm-2 control-label">Ward</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputWard" name="inputWard" placeholder="Ward">
                </div>
              </div>
				
              <div class="form-group">
                <label for="inputAddrNum" class="col-sm-2 control-label">Address Number</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputAddrNum" name="inputAddrNum" placeholder="Address Number">
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputStreet" class="col-sm-2 control-label">Street</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputStreet" name="inputStreet" placeholder="Street">
                </div>
              </div>

              <div class="form-group">
                <label for="inputZip" class="col-xs-2 control-label">Zip code</label>
                <div class="col-xs-10">
                  <input  class="form-control" id="inputZip" name="inputZip" placeholder="Zip Code">
                </div>
              </div>

              <div class="form-group">
                <label for="inputBoarded" class="col-xs-2 control-label">Boarded</label>
                <div class="col-xs-10">
                  <input  class="form-control" id="inputBoarded" name="inputBoarded" placeholder="Y/N">
                </div>
              </div>

              <div class="form-group">
                <label for="inputSign" class="col-xs-2 control-label">Sign</label>
                <div class="col-xs-10">
                  <input  class="form-control" id="inputSign" name="inputSign" placeholder="Y/N">
                </div>
              </div>
                
              <div class="form-group">
                <label for="inputDescription" class="col-sm-3 control-label">Property Description</label>
                <div class="col-sm-9">
                  <textarea rows="3" type="text" class="form-control" id="inputDescription" name="inputDescription" placeholder="Property Description"></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="inputComments" class="col-sm-3 control-label">Comments</label>
                <div class="col-sm-9">
                  <textarea rows="3" type="text"class="form-control" id="inputComments" name="inputComments" placeholder="Comments..."> </textarea>
                   
                </div>
              </div>
                   <p>File <input type="file" name="image"><p>
                   <input TYPE="submit" name="upload" title="Add data to the Database" value="submit"/>           
           
          </form><!--form collapse-->
      </div> 
  
       
    </div> 





      <hr>

      <footer>
        <p>&copy; 2014</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-switch.js"></script>

    
  </body>
</html>

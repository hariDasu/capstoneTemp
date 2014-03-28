<?php
//variables for mysql

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

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          
          <a class="navbar-brand" href="#">Abandoned Property List</a>
        </div>
          
        <div class="navbar-collapse pull-right">
          <form class="navbar-form" role="form">
            
            <div class="button-group">
             
              <div class="dropdown-menu pull-right">
              
              </div>
            </div>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
    <br><br><br>
    


    <!-- Main  -->
    

    <div class="container clear-top">
      <div class="row">
          <div class="col md-12">
        
        <br><br><br>
        <br>
        <a href="index.html">Go back... </a>  
              </div>
      
          <form action="upload.php" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

           <div class="col-xs-6 col-xs-offset-3">
            
              <div class="form-group">
                <label for="inputBlock" class="col-sm-3 control-label">Block</label>
                <div class="col-sm-9">
                  <input  class="form-control" id="inputBlock" name="inputBlock" type="text" placeholder="Block">
                </div>
              </div>

              <div class="form-group">
                <label for="inputLot" class="col-sm-3 control-label">Lot</label>
                <div class="col-sm-9">
                    <input  class="form-control" id="inputLot" name="inputLot" placeholder="Lot">
                  </div>
              </div>

              <div class="form-group">
                <label for="inputWard" class="col-sm-3 control-label">Ward</label>
                <div class="col-sm-9">
                  <input class="form-control" id="inputWard" name="inputWard" placeholder="Ward">
                </div>
              </div>
				
			  <div class="form-group">
                <label for="inputAddrNum" class="col-sm-3 control-label">Address Number</label>
                <div class="col-sm-9">
                  <input class="form-control" id="inputAddrNum" name="inputAddrNum" placeholder="Address Number">
                </div>
              </div>
              
			  <div class="form-group">
                <label for="inputStreet" class="col-sm-3 control-label">Street</label>
                <div class="col-sm-9">
                  <input class="form-control" id="inputStreet" name="inputStreet" placeholder="Street">
                </div>
              </div>

              <div class="form-group">
                <label for="inputZip" class="col-sm-3 control-label">Zip code</label>
                <div class="col-sm-9">
                  <input  class="form-control" id="inputZip" name="inputZip" placeholder="Zip Code">
                </div>
              </div>

              <div class="form-group">
                <label for="inputBoarded" class="col-sm-3 control-label">Boarded</label>
                <div class="col-sm-9">
                  <input  class="form-control" id="inputBoarded" name="inputBoarded" placeholder="Y/N">
                </div>
              </div>

              <div class="form-group">
                <label for="inputSign" class="col-sm-3 control-label">Sign</label>
                <div class="col-sm-9">
                  <input  class="form-control" id="inputSign" name="inputSign" placeholder="Y/N">
                </div>
              </div>
                
              <div class="form-group">
                <label for="inputDescription" class="col-sm-3 control-label">Property Description</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="inputDescription" name="inputDescription" placeholder="Property Description">
                </div>
              </div>

              <div class="form-group">
                <label for="inputComments" class="col-sm-3 control-label">Comments</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="inputComments" name="inputComments" placeholder="Comments...">
                </div>
              </div>
                   <p>File <input type="file" name="image"> 
                   <p>
                   <input TYPE="submit" name="upload" title="Add data to the Database" value="submit"/>
                 
                
              
              
            </div>
          </form><!--form collapse-->
          
          
      </div>    
    </div>
    
      

   
        


      
      

      <footer class="footer">
          <nav class="navbar navbar-inverse" role="navigation">


        <p><a href="contact.php">&nbsp;&nbsp;Contact Us</a></p>
              </nav>
      </footer>
  


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
      <script>$(document).ready(function() {

   var docHeight = $(window).height();
   var footerHeight = $('#footer').height();
   var footerTop = $('#footer').position().top + footerHeight;

   if (footerTop < docHeight) {
    $('#footer').css('margin-top', 10+ (docHeight - footerTop) + 'px');
   }
  });
      </script>
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-switch.js"></script>

    
  </body>
</html>

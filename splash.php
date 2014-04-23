<?php
/*
  vi: sw=4 ts=4 expandtab
*/
session_start();

//validate session
if (!isset($_SESSION['AUTH']))
{
	session_destroy();
	header('Location: signIn.html');
}

$username = $_SESSION['USERNAME'];
$utype = $_SESSION['UTYPE'];
$userid = $_SESSION['USERID'];
$fname = $_SESSION['FNAME'];
$lname = $_SESSION['LNAME'];
$email = $_SESSION['EMAIL'];

//echo "Welcome to the splash page!<br /><br />";

//echo "User Information from Session:<br /><br />USERNAME: $username<br />UTYPE: $utype<br />USERID: $userid<br />Firstname: $fname<br />Lastname: $lname<br />Email: $email";
?>

<!DOCTYPE html>
<html lang='en''>
<head>
<meta charset='utf-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<meta name='description' content=''>
<meta name='author' content=''>
<link rel='shortcut icon' href='../../assets/ico/favicon.ico'>

<title>Spot The Lot - City of Paterson</title>

<!-- Bootstrap core CSS -->
<link href='css/bootstrap.min.css' rel='stylesheet'>
<link href='css/bootstrap-switch.css' rel='stylesheet'>
<link href='css/dataTables.bootstrap.css' rel='stylesheet'>
<link href='css/dataTables.editor.css' rel='stylesheet'>
<link href='css/dataTables.tabletools.css' rel='stylesheet'>



<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src='../../assets/js/ie8-responsive-file-warning.js'></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
<script src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js'></script>
<![endif]-->

<script src='js/jquery-1.11.0.js'></script>
<script src='js/jquery.dataTables.js'></script>
<script src='js/bootstrap.min.js'></script>
<script src='js/bootstrap-switch.js'></script>
<script type="text/javascript" language="javascript" charset="utf-8" src="js/dataTables.tabletools.min.js"></script>
<script type="text/javascript" language="javascript" charset="utf-8" src="DataTablesEditor/js/dataTables.editor.min.js"></script>
<script type="text/javascript" language="javascript" charset="utf-8" src="js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" charset="utf-8" src="js/dataTables.bootstrap.js"></script>
<script type="text/javascript" language="javascript" charset="utf-8" src="DataTablesEditor/js/dataTables.editor.bootstrap.js"></script>
<script type="text/javascript" language="javascript" charset="utf-8" src="table.PROPERTY.js"></script>
</head>

<body>

<div class='navbar navbar-default navbar-fixed-top' role='navigation'>
<div class='container'>
<div class='navbar-header'>

  <a class='navbar-brand' href='#'>Spot The Lot - City of Paterson</a>
</div>

<div class='navbar-collapse pull-right'>
  <form class='navbar-form' role='form'>

    <div class='button-group'>

	<div class='pull-right'>
      <a class='pull-right button btn btn-primary' href='logout.php'>
    Log Out</a>
<b><?php $username=$_SESSION['USERNAME']; 
echo "$username"; ?></b>&nbsp;&nbsp;
            </div>
                </div>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->


    <div class='container'>
      <!-- Example row of columns -->
      <div class='row'>
        <div class='col-md-12'>
            <br><br><br>

            <!--<div class='text-center modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='myModalLabel'>Sign In</h4>
      </div>
        <form id='login' action='auth.php' method='post' accept-charset='UTF-8'>
      <div class='modal-body'>

                  <input id='username'  type='text' name='username' size='30' placeholder='Username...' /><br>
                  <input id='password' type='password' name='password' size='30' placeholder='Password...'/><br><br>
                  <input id='user_remember_me'  type='checkbox' name='user[remember_me]' value='1' />
                     <br>




                  <p class='text-center'>Entry for authorized City of Paterson Personnel only</p>



      </div>
      <div class='modal-footer'>
          <a href='register.html'>
          <button type='button' class='pull-left btn btn-success'>New User?</button>
              </a>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        <input type='submit button' class='button btn btn-primary' name='login' value='submit'>

      </div>
            </form>
    </div>
  </div>
</div>-->


            <div class='panel-heading'><h2><b>Properties</b></h2>
<form class='navbar-form navbar-left' role='form'>
        <div class="btn-group">
        
            
                <a class="btn btn-default" href="splashPublic.php">My Entries</a>
                 
                <a class="btn btn-default" href="addPublicEntry.php">Add Property</a>
     
                <a class="btn btn-default" href="<?php echo( "editUser.php?userid=".$_SESSION['USERID']) ?>">Edit User Account</a>
            
        
            </div>
        </form>
        <?php 
        if ($_SESSION['UTYPE'] > 1)
            {
                print("
                    <form class='navbar-form navbar-right' role='form'>
                        <div class='btn-group'>
                            <a class='btn btn-default' href='listCourtA.php'>Create/Edit Court Actions</a>
                            <a class='btn btn-default' href='listNotices.php'>Create/Edit Notices</a>
                            <a class='btn btn-default' href='listOwners.php'>Create/Edit Owners</a>
                            </div>
                    </form>
                    ");
                    
                
            }
            if ($_SESSION['UTYPE'] == 3)
            {
                print("
                    <form class='navbar-form navbar-left' role='form'>
                        <div class='form-group'>
                            &nbsp;
                            <a class='btn btn-success' href='listUsers.php'>User Administration</a>
                        </div>
                    </form>

                    
                    ");
            }
            
            
        ?>
            </div>


  <!-- Table -->



            <br><br>
<?php
                            //header("Content-Type: text/html");

                            ini_set('display_errors',1);
                            error_reporting(E_ALL);

                            

                            //project db
                            $sql=mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");
                           
                            if(mysqli_connect_errno($sql))
                            {
                                print("<tr>
                                            <td>Failed to connect to MySQL: " . mysqli_connect_error() . ";</td>
                                            
                                        </tr>");
                            }
                            else
                            {
                            
                               // find all entries for user
                                $query=mysqli_query($sql, "SELECT * FROM PROPERTY
                                ");
                                $rowtot = 0;
                                while($row=mysqli_fetch_assoc($query)){
                                    $result[]=$row;
                                    $rowtot++;
                                }

                                if ( $rowtot > 0)
                                { 
                                    ?>
            <table  cellpadding="0" cellspacing="0" border="0" id="prettyTable" class="table table-hover table-bordered" width="100%">
                          
                                          <thead>
                                              <tr>
                                                <?php  
                                                    if ($_SESSION['UTYPE'] > 1) {
                                                ?>
                                                        <th width="4%">
                                                           Edit/Delete
                                                        </th>
                                                <?php
                                                    }
                                                ?>
                                                  <th width="9%">
                                                      Block
                                                  </th>
                                        
                                              
                                                  <th width="9%">
                                                      Lot
                                                  </th>
                                              
                                          
                                              
                                                  <th width="9%">
                                                      Ward
                                                  </th>
                                                  
                                                  <th width="9%">
                                                      Address
                                                  </th>
                                                  <th width="9%">
                                                      Street
                                                  </th>
                                                  <th width="8%">
                                                      Zip Code
                                                  </th>
                                                  <th width="8%">
                                                      Boarded
                                                  </th>
                                                  <th width="9%">
                                                      Sign Posted
                                                  </th>
                                                  <th width="8%">
                                                      Description
                                                  </th>
                                                  <th width="9%">
                                                      Comments
                                                  </th>
                                                  <th width="9%">
                                                      Photo
                                                  </th>
                                              
                                          
                                            </tr>
                                          </thead>
        <tbody>
<?php
                                        // echo '<tr>';
                                        $rowCnt=0 ;
                                        foreach($result as $key=>$value){
                                                $rowCnt++ ;
                                                $property_id = $value["PROPID"];
                                                print("&nbsp;");
                                                echo '<tr>';
                                            if ($_SESSION['UTYPE'] > 1){
                                                print("<td><a href='editEntry.php?property_id=".$value["PROPID"]."'>Edit </a>");
                                                print ("<a href='deleteproperty.php?id=".$value["PROPID"]."' onclick=\"return confirm('Remove ".$value["PROPID"]."?');\"> Delete</a></td>");
}                                               
 echo  '<td>',$value["BLOCK"],' </td>  <td>', $value["LOT"],'</td><td>',$value["WARD"],' </td>  <td>', $value["ADDRNUM"],'</td> <td>',$value["STREET"],'</td> <td>',$value["ZIP"],' </td>';
                                                                        if ( $value["BOARDED"] == 1)
                                                                        {
                                                                            echo '<td>Y</td>'; 
                                                                        }
                                                                        else 
                                                                        {
                                                                            echo '<td>N</td>'; 
                                                                        }
                                                                        if ( $value["SPOST"] == 1)
                                                                        {
                                                                            echo '<td>Y</td>'; 
                                                                        }
                                                                        else 
                                                                        {
                                                                            echo '<td>N</td>'; 
                                                                        }
                                                echo '<td>', $value["PDESC"],'</td>  <td>', $value["LCOMMENT"],'</td>';
                                                        //-***********image processing includes modal***************************
                                                  if(!empty($value["PHOTOLOC"]) && is_dir($value["PHOTOLOC"])){ 
                                                      $string =array();
                                                      $filePath=$value["PHOTOLOC"];  
                                                      $dir = opendir($filePath);
                                                      while ($file = readdir($dir)) { 
                                                         if (preg_match("/.png/",$file) || preg_match("/.jpg/",$file) || preg_match("/.gif/",$file) || preg_match("/.bmp/",$file) || preg_match("/.jpeg/",$file)) { 
                                                              $string[] = $file;
                                                         }
                                                      }
                                                      $imgCntr=0 ;
                                                      $imgCnt=count($string) ;
                                                      while (sizeof($string) != 0){
                                                        $img = array_pop($string);
                                                      ?> 
                                                      <html>
                                                          <div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                                              <div class="modal-dialog">
                                                                  <div class="modal-content">
                                                                      <div class="modal-header">
                                                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Image</button>
                                                                      </div>
                                                                      <div class="modal-body">
                                                                          <p><img src="<?php echo $filePath.$img; ?>"  width="400" height="200"></p>
                                                                      </div>
                                                                      <div class="modal-footer">
                                                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                                        
                                                              <?php
                                                                   if ($imgCntr == 0 ) {
                                                                       echo '<td>' ;
                                                                   }
                                                              ?>
                                                              
                                                          </div> 
                                                          <a data-toggle="modal" href="#imgModal"><img class="img-responsive" src="<?php echo $filePath.$img; ?>" width="30" height="30" ></a> 
                                                      </html>
                                                      <?php
                                                        $imgCntr++;
                                                      }
                                                      
                                                  }//***********************end image processing******************    
                                                  else{
														echo "<td> ";
                                                    
                                                    }
                                                //echo '<tr>';   
                                            }
                                        }
                                }
                            
                        ?>
        </tbody>
            </table>

            </div>


          </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Company 2014</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <script src="js/bootstrap-switch.js"></script>
    <script type="text/javascript" src="js/dataTables.bootstrap.js"></script>  

<script>
    $( document ).ready(function() {
        $('#login').submit(function(){
            console.log($(this));
            return false;
        });
            });
</script>
    <script>
      $(document).ready(function(){
           $('img').on('click',function(){
                var src = $(this).attr('src');
                var img = '<img src="' + src + '" class="img-responsive"/>';
                $('#imgModal').modal();
                $('#imgModal').on('shown.bs.modal', function(){
                    $('#imgModal .modal-body').html(img);
                });
                $('#mimgModal').on('hidden.bs.modal', function(){
                    $('#imgModal .modal-body').html('');
                });

                });
            // {"aLengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]] }
            $('#prettyTable').dataTable();  
        })</script>
  </body>
</html>




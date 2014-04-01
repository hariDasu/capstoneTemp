<?php
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

<title>Abandoned Properties in Paterson</title>

<!-- Bootstrap core CSS -->
<link href='css/bootstrap.min.css' rel='stylesheet'>
<link href='css/bootstrap-switch.css' rel='stylesheet'>
<link href='css/dataTables.bootstrap.css' rel='stylesheet'>



<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src='../../assets/js/ie8-responsive-file-warning.js'></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
<script src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js'></script>
<![endif]-->
</head>

<body>

<div class='navbar navbar-default navbar-fixed-top' role='navigation'>
<div class='container'>
<div class='navbar-header'>

  <a class='navbar-brand' href='#'>Abandoned Property List</a>
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

            <form class='navbar-form navbar-right' role='form'>
            <div class='form-group'>
              &nbsp;

            </div>
                </form>
            </div>


  <!-- Table -->



            <br><br>

            <div id="container">

                <table cellpadding="0" cellspacing="0" border="0" id="PROPERTY" class="table table-hover table-bordered" width="100%">

                    <thead>
                    <tr>
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
                        <th width="9%">
                            City
                        </th>
                        <th width="9%">
                            Zip
                        </th>
                        <th width="9%">
                            State
                        </th>
                        <th width="8%">
                            Boarded
                        </th>
                        <th width="10%">
                            Description
                        </th>
                        <th width="10%">
                            Comments
                        </th>


                    </tr>
                    </thead>

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
    <script src='js/jquery-1.11.0.js'></script>
    <script src='js/jquery.dataTables.js'></script>
    <script src='js/bootstrap.min.js'></script>
    <script src='js/bootstrap-switch.js'></script>
    <script type="text/javascript" language="javascript" charset="utf-8" src="DataTablesEditor/js/dataTables.tabletools.min.js"></script>
    <script type="text/javascript" language="javascript" charset="utf-8" src="DataTablesEditor/js/dataTables.editor.min.js"></script>
    <script type="text/javascript" language="javascript" charset="utf-8" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" charset="utf-8" src="js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" language="javascript" charset="utf-8" src="DataTablesEditor/js/dataTables.editor.bootstrap.js"></script>
    <script type="text/javascript" language="javascript" charset="utf-8" src="DataTablesEditor/js/table.PROPERTY.js"></script>

<script>
        $( document ).ready(function() {
            $('#login').submit(function(){
console.log($(this));
    return false;
});
    $('#prettyTable').dataTable({
        'aLengthMenu': [[5,10, 25, 50, -1], [5,10, 25, 50, 'All']],
        'iDisplayLength' : 10,
        'bProcessing': true,
        'bServerSide': true,
        'sAjaxSource': 'properties.php'
    });


});



    </script>

  </body>
</html>


<br /><br /><a href="logout.php">Logout</a>

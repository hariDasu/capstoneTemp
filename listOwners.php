<?php 
session_start();


if (!isset($_SESSION['AUTH']))
{
    session_destroy();
    header('Location: signIn.html');
}
if ($_SESSION['UTYPE'] == '1')
{
    header('Location: denied.php');
}
ini_set('display_errors',1);
        error_reporting(E_ALL);

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
      <link href="css/dataTables.bootstrap.css" rel="stylesheet">
      <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>property Listing</title>

  
</head>
<body>
        <div class="navbar navbar-default navbar" role="navigation">
      <div class="container">
        <div class="navbar-header">
          
          <a class="navbar-brand" href="index.html">Spot The Lot - City of Paterson: User Dashboard</a>
        </div>
          
        <div class="navbar-collapse pull-right">
          <form class="navbar-form" role="form">
           
           <div class='pull-right'>
              <a class='pull-right button btn btn-primary' href='logout.php'>
            Log Out</a>
        <b><?php $username=$_SESSION['USERNAME']; 
        echo "$username"; ?></b>&nbsp;&nbsp;
                    </div>
            <div class="button-group">
             
                <div class="dropdown-menu pull-right">
              
            </div>
                </div>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
    <div class='panel-heading'><h2><b>Owners</b></h2>
        <form class='navbar-form navbar-left' role='form'>
        <div class="btn-group">
        
            
                <a class="btn btn-default" href="splashPublic.php">My Entries</a>
                <a class="btn btn-default" href="splash.php">Main List</a>
                 
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

                    <form class='navbar-form navbar-right' role='form'>
                        <div class='form-group'>
                            &nbsp;
                            <a class='btn btn-success' href='editOwner.php?ownerid=new'>New Owner</a>
                        </div>
                    </form>
                    ");
            }
            
            
        ?>
    </div>
  
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            	
				<br>
            	<table cellpadding="0" cellspacing="0" border="0" id="prettyTable" class="table table-hover table-bordered" width="100%">
				<thead>
					  <tr>
							<th width="4%">
								Edit
								Delete
							</th>				
					  
						  <th width="9%">
							  Owner First Name
						  </th>
					  
						  <th width="9%">
							  Owner Last Name
						  </th>
				  
					</tr>
				  </thead>
<?php
		//header("Content-Type: text/html");

		ini_set('display_errors',1);
		error_reporting(E_ALL);

		//session_start();
		
		$sql=mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");
		
		
		if(mysqli_connect_errno($sql))
		{
			print("<tr>
						<td>Failed to connect to MySQL: " . mysqli_connect_error() . ";</td>
						
					</tr>");
		}
		else
		{
			
			$query=mysqli_query($sql, "
				SELECT * 
				FROM OWNERS
				ORDER BY `OWNERS`.`FNAME` ASC 
			");
			$rowtot = 0;
			while($row=mysqli_fetch_assoc($query)){
				$result[]=$row;
				$rowtot++;
			}
			if ( $rowtot > 0)
			{
				foreach($result as $key=>$value){
				print("&nbsp;");
						print("<tr>
						<td><a href='editOwner.php?ownerid=".$value["OWNERID"]."'>Edit</a>
						<a href='deleteown.php?id=".$value["OWNERID"]."' onclick=\"return confirm('Remove ".$value["FNAME"]."?');\">Delete</a></td>
						<td>".$value["FNAME"]." </td>  <td> ".$value["LNAME"]."</td></tr>");			
				}
			}
			else
			{
				print("<tr>
						<td> No Owners on File - Click Add Owner to continue</td>
						</tr>");
			}
		}
	?>
</table>
                    
            </div>
        </div>
    </div>

</body>

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
    <script src="js/jquery.dataTables.js"></script>
    <script src="js/bootstrap-switch.js"></script>
    <script type="text/javascript" src="js/dataTables.bootstrap.js"></script>  
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
            $('#prettyTable').dataTable(
                        {"aLengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]]
                        });  
        })</script>

      
<script>
        $( document ).ready(function() {
            $('#login').submit(function(){
    console.log($(this));
    return false;
});
    


});
 
    
   
    </script>
    
  </body>
</html>





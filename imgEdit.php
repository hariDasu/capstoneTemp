<?php
session_start();
if (!isset($_SESSION['AUTH']))
{
    session_destroy();
    header('Location: signIn.html');
}
ob_start();
?>

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
    //sanitize only integer entry
    $PROPID = (int)$_SESSION['PROPID'];
    
    $sql=mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");
    if(mysqli_connect_errno($sql))
    {
        print("<tr><td>Failed to connect to MySQL: " . mysqli_connect_error() . ";</td></tr>");
    }
    else
	{
        if($_SESSION['UTYPE']=='1'){
            // find all entries for user
            $query=mysqli_query($sql, "SELECT * 
                    FROM PROPERTY WHERE LUSERID='$_SESSION[USERID]' AND PROPID='$_SESSION[PROPID]'
                    ");
        }
        elseif($_SESSION['UTYPE']=='2' || $_SESSION['UTYPE']=='3'){   
               // find all entries
                $query=mysqli_query($sql, "SELECT * 
                    FROM PROPERTY WHERE  PROPID='$PROPID'
                    
                ");
            }
            $rowtot = 0;
            while($row=mysqli_fetch_assoc($query)){
                $result[]=$row;
                $rowtot++;
            }
            if ( $rowtot > 0)
            { 
                foreach($result as $key=>$value){
                    if($_SESSION['USERID'] = $value["LUSERID"]){
                        $property_id = $value["PROPID"];
                        
                            //-***********image processing includes modal***************************
                        if(!empty($value["PHOTOLOC"]) ){
                            $string =array();
                            $filePath=$value["PHOTOLOC"];  
                            $dir = opendir($filePath);
                            while ($file = readdir($dir)) { 
                                if (preg_match("/.png/",$file) || preg_match("/.jpg/",$file) || preg_match("/.gif/",$file) || preg_match("/.bmp/",$file) || preg_match("/.jpeg/",$file)) { 
                                    $string[] = $file;
}
                            }
                            while (sizeof($string) != 0){
                                $img = array_pop($string);
?> 
                            <html> 
                            <div class="row">   
                                <div class="col-md-3 col-md-offset-1">                            
                                <form name="form1" method="post"> 
                                    <td><input type="checkbox" name="file[]" value="<? echo $filePath.$img;?>"></td>
                                    <td><input  type="submit" name="Delete" value="Delete"></td>
                                    <td><a><img class="img-responsive" src="<? echo $filePath.$img;?>" width="150" height="150" ></a></td>
                                    <br><br>
                                </form>
                            </div>
                            </div>
                            </html>
<?php
                                if(isset($_POST['file']) && is_array($_POST['file']))
								{
                                    if (file_exists($filePath.$img)){
	                                    foreach($_POST['file'] as $file)
	                                    {   
	                                        unlink( $file) or die("Failed to delete file");
	                                    }
	                                    header('Location: imgEdit.php');
	                                }
	                                else{
	                                    echo "no such file";
	                                }
                                }
                            }
						}//***********************end image processing******************    
                                else{
                                  
                                   
                                }
ob_end_flush();
?>
								<html>
									<form action="uploadAdd.php" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
										<p>Add images<input type="file" multiple name="image[]"><p>
										<input type="submit" name="upload"  value="submit"/>
										<br><br>
									</form>
									</div>
									<a class="btn btn-default" href="<?php echo( "editEntry.php?property_id=".$_SESSION['PROPID'])?>">return</a>
                                </html>
<?php
								}
                }
            }
            else
            {
                echo '<tr>
                        <td> No Records found</td>
                        </tr>';
            }
    }
?>
</table>
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
    <script src="js/bootstrap-switch.js"></script>
    <!---modal---->
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
        })</script>
    
  </body>
</html>
<?php
/* close connection */
mysqli_close($sql);
?>
<?php session_start(); ?>
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

    <div class="navbar navbar-inverse navbar" role="navigation">
      <div class="container">
        <div class="navbar-header">
          
          <a class="navbar-brand" href="index.html">Abandoned Property List</a>
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

    
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Owner Listing</title>
</head>
<body>
<table>
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
            $query=mysqli_query($sql, "SELECT * 
                FROM PROPERTY 
                ORDER BY `STREET` ASC 
            ");
            $rowtot = 0;
            while($row=mysqli_fetch_assoc($query)){
                $result[]=$row;
                $rowtot++;
            }

            if ( $rowtot > 0)
            { 
                ?>
                   <div class="table-responsive">
                        <table class="table">
                               <tr> <td></td>
                                    <td>Block</td>
                                    <td>Lot</td>
                                    <td>Ward</td>
                                    <td>Street</td>
                                    
                                    <td>Zip Code</td>
                                    
                                    <td>Boarded</td>
                                    <td>Sign Posted</td>
                                    <td>Descriptions</td>
                                    <td>Comments</td>
                                    <td>Photo</td>
                                </tr>
                
                    <?php
                    echo '<tr>';
                    foreach($result as $key=>$value){
                        if($username = $value["USERNAME"]){
                            $property_id = $value["PROPID"];
                            print("&nbsp;");
                        
                            echo '<tr>';
                            print("<td><a href='editEntry.php?$=".$value["PROPID"]."'>Edit</a>");

                            echo  '<td>',$value["BLOCK"],' </td>  <td>', $value["LOT"],'</td><td>',$value["WARD"],' </td>  <td>', $value["STREET"],'</td> <td>',$value["ZIP"],' </td>  <td>', $value["BOARDED"];
                            echo '</td><td>',$value["SPOST"],' </td>  <td>', $value["PDESC"],'</td>  <td>', $value["LCOMMENT"],'</td>';
                                if(!empty($value["PHOTOLOC"]) ){ 
                                    echo '<td> Y </td>' ;
                                 
                                }
                                else{
                                   echo '<td></td>';
                                }
                            echo '<tr>';   
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

    
  </body>
</html>
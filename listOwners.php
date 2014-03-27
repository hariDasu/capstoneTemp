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
			print("<tr><td><a href='editOwner.php?ownerid=new'>New Owner</a></td><tr>");
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
</body>
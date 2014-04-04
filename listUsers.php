<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>User Listing</title>
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
			// print("<tr><td><a href='editUser.php?ownerid=new'>New User</a></td><tr>");
			$query=mysqli_query($sql, "
				SELECT * 
				FROM USERS
				ORDER BY `USERS`.`USERNAME` ASC 
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
						<td><a href='editUser.php?ownerid=".$value["USERID"]."'>Edit</a>
						<a href='deleteuser.php?id=".$value["USERID"]."' onclick=\"return confirm('Remove ".$value["USERNAME"]."?');\">Delete</a></td>
						<td>".$value["USERNAME"]." </td>  <td> ".$value["LNAME"]."</td>
						<td>".$value["FNAME"]." </td> <td>");			
						
						switch ($value["UTYPE"]){
							case "1":
								print( "Volunteer");
								break;
							case "2":
								print( "City-Worker");
								break;
							case "3":
								print( "Administrator");
								break;
						}
						print("</td> <td> ".$value["EMAIL"]."</td> </tr>");
				}
			}
			else
			{
				print("<tr>
						<td> No Users on File</td>
						</tr>");
			}
		}
	?>
</table>
</body>
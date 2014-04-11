<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Court Action Listing</title>
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
			print("<tr><td><a href='editCAction.php?courtid=new'>New Court Action</a></td><tr>");
			$query=mysqli_query($sql, "
				SELECT * 
				FROM CACTIONS
					JOIN OWNERS
							ON OWNERS.OWNERID = CACTIONS.OWNERID
					JOIN PROPERTY
							ON PROPERTY.PROPID = CACTIONS.PROPID
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
						<td><a href='editCAction.php?courtid=".$value["COURTID"]."'>Edit</a>
						<a href='deleteca.php?id=".$value["COURTID"]."' onclick=\"return confirm('Remove ".$value["COURTID"]."?');\">Delete</a></td>
						<td>".$value["COURTID"]." </td> <td>".$value["FNAME"]." </td>  <td> ".$value["LNAME"]."</td>
						<td>".$value["ADDRNUM"]." </td> <td>".$value["STREET"]." </td>
						</tr>");			
				}
			}
			else
			{
				print("<tr>
						<td> No Court Actions on File - Click Add Court Action to continue</td>
						</tr>");
			}
		}
	?>
</table>
</body>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Notices Listing</title>
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
			print("<tr><td><a href='editNotice.php?noticeid=new'>New Notice</a></td><tr>");
			$query=mysqli_query($sql, "
				SELECT * 
				FROM `NOTICES` t1
				LEFT JOIN `OWNERS` t2 ON t1.OWNERID = t2.OWNERID
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
						<td><a href='editNotice.php?noticeid=".$value["NOTICEID"]."'>Edit</a>
						<a href='deletenot.php?id=".$value["NOTICEID"]."' onclick=\"return confirm('Remove ".$value["NOTICEID"]."?');\">Delete</a></td>
						<td>".$value["FNAME"]." </td> <td>");
						switch ($value["NTYPE"]){
							case "1":
								print( "Notification");
								break;
							case "2":
								print( "Invoice");
								break;
							case "3":
								print( "Court Summons");
								break;
						}
						print("</td> <td> ".$value["SDATE"]."</td> <td>".$value["NOTES"]." </td></tr>");			
				}
			}
			else
			{
				print("<tr>
						<td> No Notices on File - Click Add Notices to continue</td>
						</tr>");
			}
		}
	?>
</table>
</body>
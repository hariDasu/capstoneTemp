<body>
<table>
<?php
		/* This code assumes the following variables are set before running.
			$inc_id = set to the noticeid of the payments we are listing
		*/
		ini_set('display_errors',1);
		error_reporting(E_ALL);

		//session_start();
		
		print("<tr><td><a href='editPayment.php?noticeid=".$inc_id."&paymentid=new'>New Payment</a></td><tr>");
		$query=mysqli_query($sql, "
			SELECT * 
			FROM `PAYMENTS` 
			WHERE NOTICEID = '".$inc_id."'
			ORDER BY `PAYMENTS`.`PDATE` ASC 
			
		");
		$rowtot = 0;
		while($row=mysqli_fetch_assoc($query)){
			$payresult[]=$row;
			$rowtot++;
		}
		if ( $rowtot > 0)
		{	
			
			foreach($payresult as $key=>$value){
			print("&nbsp;");
					print("<tr>
					<td><a href='editPayment.php?paymentid=".$value["PAYID"]."'>Edit</a>
					<a href='deletepay.php?id=".$value["PAYID"]."&noticeid=".$inc_id."' onclick=\"return confirm('Remove ".$value["PAYID"]."?');\">Delete</a></td>
				    <td> ".$value["PDATE"]."</td> <td>");
					switch ($value["PTYPE"]){
						case "1":
							print( "Cash");
							break;
						case "2":
							print( "Credit Card");
							break;
						case "3":
							print( "Check");
							break;
					}
					print("</td> <td>".$value["PAMOUNT"]." </td></tr>");			
			}
		}
		else
		{
			print("<tr>
					<td> No Payments on File - Click Add Payments to continue</td>
					</tr>");
		}
		
	?>
</table>
</body>
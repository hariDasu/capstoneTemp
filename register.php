<?php

//get form variables from front
$username = $_POST['username'];
$password = $_POST['password'];
$utype = 1;
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$email = $_POST['emailaddr'];
$active = 0;
$hash = md5( rand(0,1000) );
$subject = 'City of Paterson | Please Confirm Your Email Address';

$message = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
If the link is not clickable please copy and paste it into your preferred web browser.
 
------------------------
Username: '.$username.'
Password: '.$password.'
------------------------
 
Please click this link to activate your account:
http://pytools.webfactional.com/capstoneTemp/verify.php?email='.$email.'&hash='.$hash.'
 
';



//echo "<pre>" . $message . "</pre><br />";

//echo "you entered: $username $password $firstname $lastname $email";

//connect to database
//$conn = mysqli_connect("sql.njit.edu","ser5","rTlzzhFwz","ser5");
$conn = mysqli_connect("web178.webfaction.com","pytools","patersonDB","paterson");

if(mysqli_connect_errno($conn))
{
	$nullDB = file_get_contents('nulldb.html');
	echo "$nulldb";
}
else
{
	//echo "Database connection success!" . "<br />";
	$query = mysqli_query($conn, "INSERT INTO `USERS` ( `USERNAME` , `PASSWORD`, `UTYPE`, `FNAME`, `LNAME`, `EMAIL`, `ACTIVE`, `HASH`) 
		VALUES('".$username."','".$password."','".$utype."','".$fname."','".$lname."','".$email."','".$active."','".$hash."')");
	//$results = mysqli_fetch_array($query);

	if($query)
	{
		$send = send_email($email,$subject,$message);
		if($send['email-sent'] == "True")
		{
			echo "$username Thanks for registering with the City of Paterson. A verification email has been sent to the following address $email.";
		}
		else
		{
			$verFail = file_get_contents('verFail.html');
			echo "$verFail";
	}
	else
	{
		echo "query failed!";
	}

}


function send_email($email, $subject, $msg)
{
	$json = array();

	$data = http_build_query(array(
				//"username" => $user,
				//"password" => $pass,
				//"hash" => $hash,
				"email" => $email,
				"subject" => $subject,
				"msg" => $msg
				));

	//$data_string = json_encode($data);
	$crl=curl_init();
	curl_setopt($crl, CURLOPT_URL,"http://pytools.webfactional.com/capstoneTemp/send_confirmation.php");
	//curl_setopt($crl, CURLOPT_POST, 1);
	curl_setopt($crl, CURLOPT_POSTFIELDS, $data);
	//curl_setopt($crl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
	$res = curl_exec($crl);

	//echo($res);
	curl_close($crl);
	$res = json_decode($res, true);

	return $res;
}
?>
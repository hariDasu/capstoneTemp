<?php

//$username = $_POST['username'];
//$password = $_POST['password']
//$hash = $_POST['hash'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$msg = $_POST['msg'];
$headers = 'From:noreply@pytools.webfactional.com' . "\r\n";

$send = mail($email, $subject, $msg, $headers);

$result = array();

if($send)
{
	$result["email-sent"] = "True";
}
else
{
	$result["email-sent"] = "False";
}

echo json_encode($result);

?>

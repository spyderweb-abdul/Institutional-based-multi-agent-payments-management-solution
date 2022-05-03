<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

$userId = trim_input($_POST['userId']);
$merchantId = $_POST['merchantId'];
$user_name = strtoupper(trim_input($_POST['user_name']));
$user_email = trim_input($_POST['user_email']);
$user_phone = trim_input($_POST['user_phone']);
$roleId = 6;
$passcode = trim_input($_POST['passcode']);

$secure_code = hash('sha256', $passcode);

//Do a check first
$check = $paydb->query("SELECT * FROM ".USERS." WHERE userId = '$userId' AND merchantId = '$merchantId'") or die(mysqli_error($paydb));

if(mysqli_num_rows($check) > 0)
{
	echo '<p class="alert alert-danger"> <strong> A user already exist with the same ID for the selected merchant </strong> </p>';
}
else
{
	$insert_details = $paydb->query("INSERT INTO ".USERS." (userId, secure_code, user_name, user_email, user_phone, merchantId, roleId) VALUES ('$userId', '$secure_code', '$user_name', '$user_email', '$user_phone', '$merchantId', '$roleId') ") or die(mysqli_error($paydb));

	if($insert_details == true)
	{
	  echo '<p class="alert alert-success"> <strong> <i class="fa fa-ok"> </i> You are succesfully signed up. You may login now. </strong> </p>';
	}
	else
	{
		echo 'Fatal Error: Sign Up Failed';
	}
}
?>
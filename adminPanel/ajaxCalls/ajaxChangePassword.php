<?php
include_once('../../include/constant_connection.php');

$userID = $_POST['userID'];
$passcode = $_POST['passCode'];

$sql = $paydb->query("UPDATE ".TBL_ADMIN." SET passcode = '$passcode', active = 'YES' WHERE userID = '$userID'");

if($sql)
{
	echo '<div class="alert alert-success styleTb">Password changed successfully </div>';
}
else
{
	echo '<div class="alert alert-danger styleTb">Password change failed permanently. Please try again </div>';
}

?>
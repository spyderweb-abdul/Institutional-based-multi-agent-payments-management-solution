<?php
include_once('../include/connect.php');

$userID = $_POST['userID'];
$passcode = $_POST['passCode'];

$sql = mysql_query("UPDATE admin_tb SET passcode = '$passcode', active = 'YES' WHERE userID = '$userID'");

if($sql)
{
	echo '<div class="alert alert-success styleTb">Password changed successfully </div>';
}
else
{
	echo '<div class="alert alert-danger styleTb">Password change failed permanently. Please try again </div>';
}

?>
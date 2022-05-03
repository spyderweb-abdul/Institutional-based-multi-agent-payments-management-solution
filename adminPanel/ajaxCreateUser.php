<?php
include_once('../include/connect.php');

$userID = $_POST['userID'];
$passcode = $_POST['passCode'];
$accesslevel = $_POST['accessLevel'];

$chk = mysql_query("SELECT userID FROM admin_tb WHERE userID = '$userID'"); //Checks if user exist already
if(mysql_num_rows($chk) > 0)
{
	if($userID = $passcode){ //Checks if it's a reset  call
	
	   $upd = mysql_query("UPDATE admin_tb SET passcode = '$passcode', accessLevel = '$accesslevel' WHERE userID = '$userID'"); //then update the password only
	   echo '<div class="alert alert-success styleTb"> PASSWORD RESET FOR USER: &quot;'.$userID.'&quot </div>';
	}
	else{ echo '<div class="alert alert-danger styleTb"> This USER ID already exist. Kindly choose another User ID. </div>'; }//else flag that user already exist.
}
else //If user does not exist already, then Insert a new one
{
$sql = mysql_query("INSERT INTO admin_tb (userID, passcode, accessLevel, active) VALUES ('$userID', '$passcode', '$accesslevel', 'NO')");

if($sql == 1)//If Insert query runs correctly, do this
{ echo '<span class="alert alert-success styleTb">NEW USER &quot;'.$userID. '&quot; CREATED. </span>'; }

else //otherwise, flag this

{ echo '<span class="alert alert-danger styleTb">User cannot be created. Please try again </span>'; }

}
?>
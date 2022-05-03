<?php
include_once('../include/connect.php');

if(isset($_GET['userid']))
{
$userID = $_GET['userid'];
}


$sql = mysql_query("DELETE FROM admin_tb WHERE userID = '$userID'");

if($sql == 1)
{
	echo '<span class="alert alert-success styleTb"> USER &quot;'.$userID. '&quot; DELETED SUCCESSFULLY. </span>';
}
else
{
	echo '<span class="alert alert-danger styleTb">User cannot be deleted. Please try again </span>';
}

?>
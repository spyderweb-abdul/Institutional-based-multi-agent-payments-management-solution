<?php
include_once('../../include/constant_connection.php');

if(isset($_GET['userid']))
{
$userID = $_GET['userid'];
}


$sql = $paydb->query("DELETE FROM ".TBL_ADMIN." WHERE userID = '$userID'");

if($sql == 1)
{
	echo '<span class="alert alert-success styleTb"> USER &quot;'.$userID. '&quot; DELETED SUCCESSFULLY. </span>';
}
else
{
	echo '<span class="alert alert-danger styleTb">User cannot be deleted. Please try again </span>';
}

?>
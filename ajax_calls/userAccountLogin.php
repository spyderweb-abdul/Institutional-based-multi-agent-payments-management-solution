<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

$userId = trim_input($_POST['userId']);
$securecode = trim_input($_POST['securecode']);


$hashcode = hash('sha256', $securecode);

$sql = $paydb->query("SELECT * FROM ".USERS." WHERE userId = '$userId' AND secure_code = '$hashcode'");
if(mysqli_num_rows($sql) == 1)
{
	$_SESSION['userId'] = $userId;	

	 $folder = 'adminDashboard/production/user_pics/';

                   $fetch = $sql->fetch_array();

                   $pics = $fetch['pics'];

                   $path = $folder.$pics;

                   if($pics != NULL)
                   {
                     echo '<img src="'.$path.'" class="img-circle" width="180px" height="190px"  />';
                   }
                   else
                   {
                     echo '<img src="images/avatar.png" class="img-circle" width="180px" height="190px" />';
                   } 

	echo '<br/>

	     <h3> <i class="glyphicon glyphicon-ok"> </i> User Identified </h3> <br/>';

	     $usr = "'".$_SESSION['userId']."'"; //quote the param
	     $token = "'".$hashcode."'";
	     
	     echo '<p> <button type="button" class="btn btn-primary button_trans" onclick="log_auth('.$usr.', '.$token.')"> Continue <i class="fa fa-angle-double-right></i> </button> </p>';

	//header("Refresh:5; url=../adminDashboard/production/index.php?auth=".$_SESSION['userId'], true, 303);
}
else
{
	echo '<p style="color:red; font-size: 13px;"> <i class="fa fa-angle-double-left"></i> Username and Password Do Not Match! <i class="fa fa-angle-double-right"></i> </p>';
}
?>
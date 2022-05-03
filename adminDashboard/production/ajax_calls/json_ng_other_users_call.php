<?php

session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];


 $admin_users = $paydb->query("SELECT * FROM ".USERS." a INNER JOIN ".USERS_ROLES." b ON a.roleId = b.roleId WHERE a.merchantId = '$merchantId' AND a.roleId = '6' ");
  $num = mysqli_num_rows($admin_users);
			   
	 if($num > 0)
	 {
       $output = "";
	   
	   while($list = $admin_users->fetch_array())
	   {
		   if($output != "") {$output .= ","; }
	   
		   $output .= '{"userId":"'.$list['userId'].'",';
		   $output .= '"userName":"'.$list['user_name'].'",';
		   $output .= '"email":"'.$list['user_email'].'",';
		   $output .= '"phone":"'.$list['user_phone'].'",';
		   $output .= '"roles":"'.$list['roles'].'"}';
	   
	   }
	   $output = '{ "userlist":['.$output.']}';

	  echo ($output);
	 }

?>
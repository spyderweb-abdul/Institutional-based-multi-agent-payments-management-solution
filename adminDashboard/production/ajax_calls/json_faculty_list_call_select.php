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


$sel_fac_list = $paydb->query("SELECT facId, faculty FROM ".FACULTY." WHERE merchantId = '$merchantId' ORDER BY faculty ASC");
$num = mysqli_num_rows($sel_fac_list);
			   
	 if($num > 0)
	 {
       $output = "";
	   
	   while($res = $sel_fac_list->fetch_array())
	   {
		   if($output != "") {$output .= ","; }
	   
		   $output .= '{"facId":"'.$res['facId'].'",';
		   $output .= '"faculty":"'.$res['faculty'].'"}';
	   
	   }
	   $output = '{ "facList":['.$output.']}';

	  echo ($output);
	 }

?>
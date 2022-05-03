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


$sel_setup = $paydb->query("SELECT * FROM ".SETUP." a INNER JOIN ".FEES." b ON b.setupId = a.setupId WHERE a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));
 
    $num = mysqli_num_rows($sel_setup);
			   
	 if($num > 0)
	 {
       $output = "";
	   
	   while($res = $sel_setup->fetch_array())
	   {

		   if($output != "") {$output .= ","; }
	   
		   $output .= '{"setupId":"'.$res['setupId'].'",';
		   $output .= '"setupName":"'.$res['setup_name'].'",';
		   $output .= '"amount":"'.$res['fee_amount'].'"}';
	   
	   }
	   $output = '{ "records":['.$output.']}';

	  echo ($output);
	 }

?>
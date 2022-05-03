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


$sel_pay_choice = $paydb->query("SELECT * FROM ".PAYMENT_CHOICE." WHERE merchantId = '$merchantId' ") or die (mysqli_error($paydb));
 
    $num = mysqli_num_rows($sel_pay_choice);
			   
	 if($num > 0)
	 {
       $output = "";
	   
	   while($res = $sel_pay_choice->fetch_array())
	   {

		   if($output != "") {$output .= ","; }
	   
		   $output .= '{"choiceName":"'.$res['payment_choice_name'].'",';
		   $output .= '"choiceId":"'.$res['choiceId'].'",';
		   $output .= '"req":"'.$res['req_fee_items'].'"}';
	   
	   }
	   $output = '{ "records":['.$output.']}';

	  echo ($output);
	 }

?>
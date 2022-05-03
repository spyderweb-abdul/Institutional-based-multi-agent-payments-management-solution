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


$sel_pay_code = $paydb->query("SELECT * FROM ".SETUP." a INNER JOIN ".CHANNEL." b ON b.gatewayId = a.gatewayId INNER JOIN ".MERCHANT_PROFILE." c ON c.gatewayId = a.gatewayId WHERE a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));
 
    $num = mysqli_num_rows($sel_pay_code);
			   
	 if($num > 0)
	 {
       $output = "";
	   
	   while($res = $sel_pay_code->fetch_array())
	   {

		   if($output != "") {$output .= ","; }
	   
		   $output .= '{"setupName":"'.$res['setup_name'].'",';
		   $output .= '"setupId":"'.$res['setupId'].'",';
		   $output .= '"paymentCode":"'.$res['payment_code'].'",';
		   $output .= '"gatewayName":"'.$res['gateway_name'].'",';
		   $output .= '"serviceId":"'.$res['service_type_id'].'",';
		   $output .= '"apikey":"'.$res['merchant_apikey'].'",';
		   $output .= '"merchGatewayId":"'.$res['merchant_gateway_id'].'",';
		   $output .= '"reprocess":"'.$res['reprocessible'].'"}';
	   
	   }
	   $output = '{ "records":['.$output.']}';

	  echo ($output);
	 }

?>
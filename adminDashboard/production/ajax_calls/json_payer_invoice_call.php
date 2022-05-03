<?php

session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

    $userId = $postData->payerid;

 		$sel_pay_details = $paydb->query(" SELECT * FROM ".PAYMENT_RECORDS." a INNER JOIN ".USERS." b ON b.userId = a.userId INNER JOIN ".USER_DETAILS." c ON c.userId = a.userId INNER JOIN ".SETUP." d ON d.setupId = a.setupId INNER JOIN ".CHANNEL." e ON e.gatewayId = a.gatewayId INNER JOIN ".PAY_OPTIONS." f ON f.optionId = a.optionId INNER JOIN ".MERCHANTS." g ON g.merchantId = a.merchantId WHERE a.userId = '$userId' and a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));

 		$num = mysqli_num_rows($sel_pay_details);
			   
	 if($num > 0)
	 {
       $output = "";
	   
	   while($res = $sel_pay_details->fetch_array())
	   {
		   if($output != "") {$output .= ","; }
	   
		   $output .= '{"userId":"'.$res['userId'].'",';
		   $output .= '"invoice":"'.$res['invoice'].'",';
		   $output .= '"transactionId":"'.$res['transactionId'].'",';
		   $output .= '"amount":"'.$res['amount'].'",';
		   $output .= '"level":"'.$res['level'].'",';
		   $output .= '"setup_name":"'.$res['setup_name'].'",';
		   $output .= '"session":"'.$res['session'].'",';
		   $output .= '"status":"'.$res['status'].'",';
		   $output .= '"dateTime":"'.$res['dateTime'].'"}';
	   
	   }
	   $output = '{ "invoiceList":['.$output.']}';

	 }


	  echo ($output);

?>
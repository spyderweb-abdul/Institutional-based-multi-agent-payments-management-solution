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


$sel_fee_item = $paydb->query("SELECT feeID, feeItem, amount FROM ".FEE_ITEMS." WHERE merchantId = '$merchantId' ORDER BY feeItem ASC");
$num = mysqli_num_rows($sel_fee_item);
			   
	 if($num > 0)
	 {
       $output = "";
	   
	   while($res = $sel_fee_item->fetch_array())
	   {
		   if($output != "") {$output .= ","; }
	   
		   $output .= '{"feeID":"'.$res['feeID'].'",';
		   $output .= '"feeItem":"'.$res['feeItem'].'",';
		   $output .= '"amount":"'.$res['amount'].'"}';
	   
	   }
	   $output = '{ "records":['.$output.']}';

	  echo ($output);
	 }

?>
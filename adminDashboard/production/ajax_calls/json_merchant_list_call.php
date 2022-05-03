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


$sel_merch_list = $paydb->query("SELECT * FROM ".MERCHANTS." a INNER JOIN ".MERCHANT_TYPE." b ON a.merchantTypeId = b.merchantTypeId ORDER BY a.merchantId ASC ");
$num = mysqli_num_rows($sel_merch_list);
			   
	 if($num > 0)
	 {

       $output = "";
	   
	   while($res = $sel_merch_list->fetch_array())
	   {

	   	  $merchid = $res['merchantId'];
	   	  $merchant_type_name = $res['merchant_type_name'];

	   	  //Get number of payment setups for selected merchants
	   	  $sel_setup = $paydb->query("SELECT * FROM ".SETUP." WHERE merchantId = '$merchid' ") or die(mysqli_error($paydb));
	   	   $setup_num = mysqli_num_rows($sel_setup);


		   if($output != "") {$output .= ","; }
	   
		   $output .= '{"merchantid":"'.$merchid.'",';
		   $output .= '"merchantName":"'.htmlspecialchars_decode($res['merchant_name']).'",';
		   $output .= '"currentSession":"'.$res['current_session'].'",';
		   $output .= '"merchantEmail":"'.$res['merchant_email'].'",';
		   $output .= '"merchantType":"'.$merchant_type_name.'",';
		   $output .= '"setnum":"'.$setup_num.'"}';
	   
	    }
	    $output = '{ "merchantList" :['.$output.']}';

	  echo ($output);
	 }

?>
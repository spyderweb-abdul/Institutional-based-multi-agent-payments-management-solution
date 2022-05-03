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


$sel_item_summary = $paydb->query("SELECT feeItem, feeID FROM ".FEE_ITEMS." WHERE merchantId = '$merchantId' GROUP BY feeItem ") or die (mysqli_error($paydb));
 
    $num = mysqli_num_rows($sel_item_summary);
			   
	 if($num > 0)
	 {
       $output = "";

       $amt = 0;
	   
	   while($res = $sel_item_summary->fetch_array())
	   {

	   	   $feeItem = $res['feeItem'];
	   	   $feeID = $res['feeID'];
            
            //Get all records associated with the setupID
	   	     $get_item_sum = $paydb->query("SELECT * FROM ".FEES_ORDER." WHERE feeItem = '$feeItem' AND status = 'PAID' AND session = '$current_session' ") or die (mysqli_error($paydb));

	   	         $depositors = 0;
	   	         $amnt = 0;

		   	     while($sum_res = $get_item_sum->fetch_array()){
                   
                     $depositors ++;
                     $amnt += $sum_res['fee_amount'];
		   	   
		   	      }

		   	     $amt += $amnt;

		   if($output != "") {$output .= ","; }
	   
		   $output .= '{"feeitem":"'.$feeItem.'",';
		   $output .= '"feeid":"'.$feeID.'",';
		   $output .= '"depositors":"'.$depositors.'",';
		   $output .= '"amount":"'.number_format($amnt, 0).'"}';
	   
	   }
	   $output = '{ "records":['.$output.'], "total":[{"itemTotalSum":"'.number_format($amt, 2).'"}]}';

	  echo ($output);
	 }

?>
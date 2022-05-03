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


$sel_pay_summary = $paydb->query("SELECT * FROM ".SETUP." WHERE merchantId = '$merchantId'") or die (mysqli_error($paydb));
 
    $num = mysqli_num_rows($sel_pay_summary);
			   
	 if($num > 0)
	 {
       $output = "";

       $amt = 0;
	   
	   while($res = $sel_pay_summary->fetch_array())
	   {

	   	   $setupId = $res['setupId'];
	   	   $setup_name = $res['setup_name'];
            
            //Get all records associated with the setupID
	   	     $get_summary = $paydb->query("SELECT SUM(amount), COUNT(userId) FROM ".PAYMENT_RECORDS." WHERE setupId = '$setupId' AND status = 'PAID' AND session = '$current_session' ");

		   	     $sum_res = $get_summary->fetch_array();


		   	     $num_of_rec = $sum_res['COUNT(userId)']; //Number of Records

		   	     $sum_amt = $sum_res['SUM(amount)'];  //Total Amount

		   	     $amt += $sum_amt;

		   if($output != "") {$output .= ","; }
	   
		   $output .= '{"setupName":"'.$setup_name.'",';
		   $output .= '"setupId":"'.$setupId.'",';
		   $output .= '"depositors":"'.$num_of_rec.'",';
		   $output .= '"amount":"'.number_format($sum_amt, 0).'"}';
	   
	   }
	   $output = '{ "records":['.$output.'], "total":[{"totalSum":"'.number_format($amt, 2).'"}]}';

	  echo ($output);
	 }

?>
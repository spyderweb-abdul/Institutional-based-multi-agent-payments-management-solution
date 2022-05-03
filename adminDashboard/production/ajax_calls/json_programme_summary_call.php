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


$sel_prog_summary = $paydb->query("SELECT * FROM ".PROGRAMME." WHERE merchantId = '$merchantId' ") or die (mysqli_error($paydb));
 
    $num = mysqli_num_rows($sel_prog_summary);
			   
	 if($num > 0)
	 {
       $output = "";

       $amt = 0;
	   
	   while($res = $sel_prog_summary->fetch_array())
	   {

	   	   $progname = $res['programme'];
	   	   $progid = $res['progId'];
            
            //Get all records associated with the setupID
	   	     $get_prog_sum = $paydb->query("SELECT * FROM ".FEES_ORDER." a INNER JOIN ".PAYMENT_RECORDS." b ON b.invoice = a.invoice WHERE a.progId = '$progid' AND a.status = 'PAID' AND a.session = '$current_session' GROUP BY a.userId") or die (mysqli_error($paydb));

	   	         $depositors = 0;
	   	         $amnt = 0;

		   	     while($sum_res = $get_prog_sum->fetch_array()){
                   
                     $depositors ++;
                     $amnt += $sum_res['amount'];
		   	   
		   	      }

		   	     $amt += $amnt;

		   if($output != "") {$output .= ","; }
	   
		   $output .= '{"progName":"'.$progname.'",';
		   $output .= '"progId":"'.$progid.'",';
		   $output .= '"depositors":"'.$depositors.'",';
		   $output .= '"amount":"'.number_format($amnt, 0).'"}';
	   
	   }
	   $output = '{ "records":['.$output.'], "total":[{"progTotalSum":"'.number_format($amt, 2).'"}]}';

	  echo ($output);
	 }

?>
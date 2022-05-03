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

      $fetch = $paydb->query("SELECT feeID FROM ".TBL_FEE_STRUCTURE." WHERE progId ='$_SESSION[progid]' AND level = '$_SESSION[levid]' AND nationality = '$_SESSION[natid]' AND merchantId = '$merchantId' ") or die (mysqli_error($paydb));
 
          $num = mysqli_num_rows($fetch);
			   
				 if($num > 0)
				 {
			        $output = "";
				    $amt = 0;
				   while($r = mysqli_fetch_array($fetch))
				   {
					   $feeID = $r['feeID'];
					   
					   $trace = $paydb->query("SELECT feeID, feeItem, amount FROM ".FEE_ITEMS." WHERE feeID = '$feeID'");
					   $f = $trace->fetch_array();
					 
					        if($output != "") {$output .= ","; }
				     
					        $feeID = $f['feeID'];
							$feeItem = $f['feeItem'];
					        $amount = $f['amount'];
					 
				             $output .= '{"feeItem":"'.$feeItem.'",';
							 $output .= '"feeID":"'.$feeID.'",';
				             $output .= '"amount":"'.number_format($amount, 0).'"}';
				   
				             $amt += $amount;
				   }
				   
				   $output = '{ "records":['.$output.'] , "total":[{"totalSum":"'.number_format($amt, 0).'"}] } ';
				   
				  echo ($output);
				 }


?>
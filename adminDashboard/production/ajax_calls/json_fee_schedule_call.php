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


$sel_fee_schedule = $paydb->query("SELECT * FROM ".TBL_FULL_FEE_STRUCTURE." a INNER JOIN ".PROGRAMME." b ON a.progId = b.progId WHERE a.merchantId = '$merchantId' ORDER BY b.programme, a.level, a.nationality ASC") or die (mysqli_error($paydb));
 
    $num = mysqli_num_rows($sel_fee_schedule);
			   
	 if($num > 0)
	 {
       $output = "";
	   
	   while($res = $sel_fee_schedule->fetch_array())
	   {

	   	  $level = $res['level'];
	   	  $nationality = $res['nationality'];

	   	   if($level == 1) { $level = 'Fresh'; } elseif($level == 2) { $level = 'Returning'; } 
	   	   if($nationality == 1) { $nationality = 'Local'; } else { $nationality = 'Foreign'; }


		   if($output != "") {$output .= ","; }
	   
		   $output .= '{"progId":"'.$res['progId'].'",';
		   $output .= '"programme":"'.$res['programme'].'",';
		   $output .= '"amount":"'.number_format($res['amount'], 0).'",';
		   $output .= '"level":"'.$level.'",';
		   $output .= '"nationality":"'.$nationality.'"}';
	   
	   }
	   $output = '{ "records":['.$output.']}';

	  echo ($output);
	 }

?>
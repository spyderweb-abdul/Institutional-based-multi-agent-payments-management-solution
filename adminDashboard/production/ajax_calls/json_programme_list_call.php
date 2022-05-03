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


$sel_prog_list = $paydb->query("SELECT * FROM ".PROGRAMME." a INNER JOIN ".DEPARTMENT." b ON a.deptId = b.deptId INNER JOIN ".FACULTY." c ON c.facId = b.facId WHERE a.merchantId = '$merchantId' ORDER BY a.programme, b.department, c.faculty ASC") or die (mysqli_error($paydb));

   $num = mysqli_num_rows($sel_prog_list);
			   
	 if($num > 0)
	 {
       $output = "";
	   
	   while($res = $sel_prog_list->fetch_array())
	   {
				   if($output != "") {$output .= ","; }
			   
				   $output .= '{"progId":"'.$res['progId'].'",';
				   $output .= '"department":"'.$res['department'].'",';
				   $output .= '"programme":"'.$res['programme'].'"}';
	   
	   }
	   $output = '{ "programmeList":['.$output.']}';

	  echo ($output);
	 }

?>
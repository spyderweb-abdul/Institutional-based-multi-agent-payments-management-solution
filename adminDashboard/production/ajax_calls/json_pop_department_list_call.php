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


    $fId  = $postData->fID;


$sel_dept_list = $paydb->query("SELECT * FROM ".DEPARTMENT." WHERE facId = '$fId' AND merchantId = '$merchantId' ORDER BY department ASC") or die (mysqli_error($paydb));

   $num = mysqli_num_rows($sel_dept_list);
			   
	 if($num > 0)
	 {
       $output = "";
	   
	   while($res = $sel_dept_list->fetch_array())
	   {
				   if($output != "") {$output .= ","; }
			   
				   $output .= '{"deptId":"'.$res['deptId'].'",';
				   $output .= '"department":"'.$res['department'].'"}';
	   
	   }
	   $output = '{ "departmentList":['.$output.']}';

	  echo ($output);
	 }

?>
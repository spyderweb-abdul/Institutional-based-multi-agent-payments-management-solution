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

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $setupId = $postData->setupid;


$sel_fee_amount = $paydb->query("SELECT * FROM ".SETUP." a INNER JOIN ".FEES." b ON b.setupId = a.setupId WHERE a.setupId = '$setupId' AND a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));
 
    $num = mysqli_num_rows($sel_fee_amount);
			   
	 if($num > 0)
	 {    

       $res = $sel_fee_amount->fetch_array();	   
	
	   echo $res['fee_amount'];
	}
	else
	{
		echo 'No Amount';
	}

?>
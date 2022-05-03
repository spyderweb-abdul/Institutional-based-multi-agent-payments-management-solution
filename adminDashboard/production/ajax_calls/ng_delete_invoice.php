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


    $invoices  = $postData->invoices;


    foreach($invoices as $i)
    {
    	$del_pay_record = $paydb->query("DELETE FROM ".PAYMENT_RECORDS." WHERE invoice = '$i' ") or die(mysqli_error($paydb));

    	//Also check if there are instances of invoice in FEES_ORDER

    	$check_record = $paydb->query("SELECT * FROM ".FEES_ORDER." WHERE invoice = '$i' ");

    	if(mysqli_num_rows($check_record) > 0)
    	{
             $del_from_fees_order = $paydb->query("DELETE FROM ".FEES_ORDER." WHERE invoice = '$i' ") or die(mysqli_error($paydb));
    	}
    }

	  if($del_pay_record == true)
			{
			  $data =  'Invoice Record Deleted Successfuly';
			}
			else
			{ 
			  $data = 'Error: Operation Failed';
		    }

		echo json_encode($data);

?>
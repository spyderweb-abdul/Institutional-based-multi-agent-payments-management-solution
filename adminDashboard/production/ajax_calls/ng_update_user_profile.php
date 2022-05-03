<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

     $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

    $data = file_get_contents("php://input");
    $postData = json_decode($data);
    
    $userId = $postData->userid;
    $user_name  = $postData->username;
    $user_phone = $postData->userphone;
    $user_email = $postData->useremail;


       //Insert Fee Items
        $update_profile = $paydb->query("UPDATE ".USERS. " SET user_name = '$user_name', user_email = '$user_email', user_phone = '$user_phone' WHERE userId = '$userId' AND merchantId = '$merchantId' ") or die(mysqli_error($paydb));

            	if($update_profile == true)
            	{
            		$data = 'Profile Edited Successfully';
            	}
                else
                {
                	$data =  'Operation Failed. Please try again.';
                }
                
                echo json_encode($data);
            


?>
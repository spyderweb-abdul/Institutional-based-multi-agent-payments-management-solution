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
    
    $userId = $_SESSION['userId'];
    $passcode  = $postData->new_pass;

    $securecode = hash('sha256', $passcode);



       //Insert Fee Items
        $update_passcode = $paydb->query("UPDATE ".USERS. " SET secure_code = '$securecode' WHERE userId = '$userId' AND merchantId = '$merchantId' ") or die(mysqli_error($paydb));

            	if($update_passcode == true)
            	{
            		$data = 'Password Updated Successfully';
            	}
                else
                {
                	$data =  'Operation Failed. Please try again.';
                }
                
                echo json_encode($data);
            


?>
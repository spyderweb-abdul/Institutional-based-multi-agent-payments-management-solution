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
 
			 if(isset($_GET['deleteItem']))
			 {
			   $userId = $_GET['deleteItem'];
			 
			    
		
					 $del = $paydb->query("DELETE FROM ".USERS." WHERE userId ='$userId' AND merchantId = '$merchantId' ") or die (mysqli_error($paydb));

					// $data = "";
					 
					 if($del == true)
					 {
						 $data = 'User\'s Profile Deleted Successfully.';
					 }
					 else
					 {
						 $data = 'Operation Failed. Please try again.';
					 }

				echo json_encode($data);
			}
				
			 
		

?>
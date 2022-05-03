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
 
			 if(isset($_GET['delSetup']))
			 {
			   $setupId= $_GET['delSetup'];
			 
			    
		
					 $del = $paydb->query("DELETE a, b, c FROM ".SETUP." a INNER JOIN ".FEES." b ON b.setupId = a.setupId INNER JOIN ".PAYMENT_TYPE." c ON c.typeId = a.typeId WHERE a.setupId ='$setupId' ") or die (mysqli_error($paydb));

					// $data = "";
					 
					 if($del == true)
					 {
						 $data = 'Payment Setup and all Associated Payment Profiles have been Deleted Successfully.';
					 }
					 else
					 {
						 $data = 'Operation Failed. Please try again.';
					 }

				echo json_encode($data);
			}
				
			 
		

?>
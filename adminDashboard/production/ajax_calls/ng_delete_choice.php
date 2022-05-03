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
 
			 if(isset($_GET['delChoice']))
			 {
			   $choiceId= $_GET['delChoice'];
			 
			    
		
					 $del = $paydb->query("DELETE a, b, c, d FROM ".PAYMENT_CHOICE." a INNER JOIN ".PAYMENT_TYPE." b ON b.choiceId = a.choiceId INNER JOIN ".SETUP." c ON c.choiceId = a.choiceId INNER JOIN ".FEES." d ON d.setupId = c.setupId WHERE a.choiceId ='$choiceId' ") or die (mysqli_error($paydb));

					// $data = "";
					 
					 if($del == true)
					 {
						 $data = 'Payment Choice and Associated Payment Profiles have been  Deleted Successfully.';
					 }
					 else
					 {
						 $data = 'Operation Failed. Please try again.';
					 }

				echo json_encode($data);
			}
				
			 
		

?>
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
 
			 if(isset($_GET['cmdelete']))
			 {
			   $facId = $_GET['cmdelete'];
			 
			    
		
					 $del = $paydb->query("DELETE a, b, c FROM ".FACULTY." a INNER JOIN ".DEPARTMENT." b ON b.facId = a.facId LEFT JOIN ".PROGRAMME." c ON c.facId = a.facId WHERE a.facId ='$facId' AND a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));

					 //$data = "";
					 
					 if($del == true)
					 {
						 $data = 'Faculty/Section and all other associated components have been deleted successfully.';
					 }
					 else
					 {
						 $data = 'Operation Failed. Please try again.';
					 }

				echo json_encode($data);
			}
				
			 
		

?>
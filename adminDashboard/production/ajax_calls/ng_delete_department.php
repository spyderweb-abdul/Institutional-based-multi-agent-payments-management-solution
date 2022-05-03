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
			   $deptId = $_GET['cmdelete'];
			 
			    
		
					 $del = $paydb->query("DELETE a, b FROM ".DEPARTMENT." a LEFT JOIN ".PROGRAMME." b ON b.deptId = a.deptId WHERE a.deptId ='$deptId' AND a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));

					 //$data = "";
					 
					 if($del == true)
					 {
						 $data = 'Department and all other associated components have been deleted successfully.';
					 }
					 else
					 {
						 $data = 'Operation Failed. Please try again.';
					 }

				echo json_encode($data);
			}
				
			 
		

?>
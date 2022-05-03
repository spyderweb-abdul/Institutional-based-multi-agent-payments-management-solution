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
 
			 if(isset($_GET['delId']))
			 {
			   $progId = $_GET['delId'];
			   $nationality = $_GET['natId'];
			   $level = $_GET['levId'];			 


			   if($nationality == 'Local'){ $nationality = 1; } else { $nationality = 2; }
			   if($level == 'Fresh'){ $level = 1; } elseif($level == 'Returning'){ $level = 2; }

		            //Delete from Fee structure table
					 $del = $paydb->query("DELETE a, b FROM ".TBL_FEE_STRUCTURE." a INNER JOIN ".TBL_FULL_FEE_STRUCTURE." b ON b.progId = a.progId WHERE a.progId = '$progId' AND a.level = '$level' AND a.nationality = '$nationality' AND a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));
                     
					 
					 if($del == true)
					 {
						 $data = 'Fee Schedules Deleted Successfully.';
					 }
					 else
					 {
						 $data = 'Operation Failed. Please try again.';
					 }
               
				echo json_encode($data);
			}
				
			 
		

?>
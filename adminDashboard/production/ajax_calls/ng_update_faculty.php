<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $faculty  = $postData->faculty;
    $facId = $postData->facID;


       //Insert Fee Items
        $update_faculty = $paydb->query("UPDATE ".FACULTY. " SET faculty = '$faculty' WHERE facId = '$facId' ") or die(mysqli_error($paydb));

            	if($update_faculty == true)
            	{
            		$data = 'Faculty Details Edited Successfully';
            	}
                else
                {
                	$data =  'Operation Failed. Please try again.';
                }
                
                echo json_encode($data);
            


?>
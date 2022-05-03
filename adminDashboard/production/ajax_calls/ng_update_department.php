<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $department  = $postData->department;
    $deptId = $postData->deptID;


       //Insert Fee Items
        $update_department = $paydb->query("UPDATE ".DEPARTMENT. " SET department = '$department' WHERE deptId = '$deptId' ") or die(mysqli_error($paydb));

            	if($update_department == true)
            	{
            		$data = 'Department Details Edited Successfully';
            	}
                else
                {
                	$data =  'Operation Failed. Please try again.';
                }
                
                echo json_encode($data);
            


?>
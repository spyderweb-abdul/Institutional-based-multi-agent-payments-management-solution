<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $programme  = trim_input($postData->programme);
    $progId = $postData->progID;


       //Insert Fee Items
        $update_programme = $paydb->query("UPDATE ".PROGRAMME. " SET programme = '$programme' WHERE progId = '$progId' ") or die(mysqli_error($paydb));

            	if($update_programme == true)
            	{
            		$data = 'Programme Details Edited Successfully';
            	}
                else
                {
                	$data =  'Operation Failed. Please try again.';
                }
                
                echo json_encode($data);
            


?>
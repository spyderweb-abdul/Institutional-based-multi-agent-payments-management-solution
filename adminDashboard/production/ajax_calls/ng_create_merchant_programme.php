<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $facId  =  $postData->facultyId;
    $deptId =  $postData->departmentId;
    $prog =    trim_input($postData->prog);
    $merchId = $postData->merchantId;


       //Insert Fee Items
        $insert_merchant_programme = $paydb->query("INSERT INTO ".PROGRAMME. "(facId, deptId, programme, merchantId) VALUES ('$facId', '$deptId', '$prog', '$merchId') ") or die(mysqli_error($paydb));

                 //$data = "";

            	if($insert_merchant_programme == true)
            	{
            		$data = 'Programme Created Successfully';
            	}
                else
                {
                	$data =  'Operation Failed. Please try again.';
                }
                
                echo json_encode($data);
            


?>
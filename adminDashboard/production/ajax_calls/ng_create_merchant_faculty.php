<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $faculty  = trim_input($postData->faculty);
    $merchId = $postData->merchantId;


       //Insert Fee Items
        $insert_merchant_faculty = $paydb->query("INSERT INTO ".FACULTY. "(faculty, merchantId) VALUES ('$faculty', '$merchId') ") or die(mysqli_error($paydb));

                 //$data = "";

            	if($insert_merchant_faculty == true)
            	{
            		$data = 'Faculty Created Successfully';
            	}
                else
                {
                	$data =  'Operation Failed. Please try again.';
                }
                
                echo json_encode($data);
            


?>
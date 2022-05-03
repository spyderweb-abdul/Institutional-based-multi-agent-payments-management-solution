<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $feeItem  = $postData->feeItem;
    $amount =   $postData->feeAmount;
    $scholarship = $postData->scholarship;
    $feeId = $postData->feeId;


       //Insert Fee Items
        $edit_bulk_fee_item = $paydb->query("UPDATE ".FEE_ITEMS. " SET feeItem = '$feeItem', amount = '$amount', scholarship_applied = '$scholarship' WHERE feeID = '$feeId' ") or die(mysqli_error($paydb));

                 //$data = "";

            	if($edit_bulk_fee_item)
            	{
            		$data = 'Fee Details Edited Successfully';
            	}
                else
                {
                	$data =  'Operation Failed. Please try again.';
                }
                
                echo json_encode($data);
            


?>
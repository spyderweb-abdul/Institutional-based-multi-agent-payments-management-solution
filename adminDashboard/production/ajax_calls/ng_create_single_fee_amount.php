<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $setupId =  $postData->setupid;
    $fee_amount = $postData->amt;

    function throw_ex($err)
    {
    	throw new Exception($err);
    }

    try
    {

        //Check if record exist before
        $check_single_fee = $paydb->query("SELECT * FROM ".FEES." WHERE setupId = '$setupId' ") or throw_ex (mysqli_num_rows($paydb));

        if(mysqli_num_rows($check_single_fee) > 0)
        {
            $update_single_fee = $paydb->query("UPDATE ".FEES." SET fee_amount = '$fee_amount' WHERE setupId = '$setupId' ") or throw_ex (mysqli_num_rows($paydb));

            if($update_single_fee == true)
            {
               echo 'Single Fee Updated Successfully';
            }
        }
        else
        {
            //Insert Payment Choice
            $insert_single_fee = $paydb->query("INSERT INTO ".FEES. "(setupId, fee_amount) VALUES ('$setupId', '$fee_amount') ") or throw_ex(mysqli_error($paydb));

            	if($insert_single_fee)
            	{
            		echo 'Single Fee Amount Created Successfully';
            	}
                else
                {
                	echo 'Operation Failed. Please try again.';
                }
        }
                
    }
    catch(Exception $e) 
    {
         echo 'Error: '.$e;
    }


?>
<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';


    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $typeId  = $postData->typeid;
    $typename = $postData->type;

                
    //Update the sum amount in the fee_structure_full_table             
    $upd = $paydb->query("UPDATE ".PAYMENT_TYPE." SET payment_type_name = '$typename' WHERE typeId = '$typeId' ");
                                    
        if($upd == TRUE) //If update query was successful, flag success message
        {            
          $data = 'Payment Type Updated Successfully.';
        }
        else  //else, do this:
        {
          $data = 'Error: Update Operation Failed';  
        }

                
   echo json_encode($data);
            
?>
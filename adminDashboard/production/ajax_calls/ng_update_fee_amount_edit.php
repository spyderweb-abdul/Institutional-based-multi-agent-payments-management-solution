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

    $setupId  = $postData->setupid;
    $amount = $postData->amt;

                
    //Update the sum amount in the fee_structure_full_table             
    $upd = $paydb->query("UPDATE ".FEES." SET fee_amount = '$amount' WHERE setupId = '$setupId' ");
                                    
        if($upd == TRUE) //If update query was successful, flag success message
        {            
          $data = 'Amount Updated Successfully.';
        }
        else  //else, do this:
        {
          $data = 'Error: Update Operatin Failed';  
        }

                
   echo json_encode($data);
            
?>
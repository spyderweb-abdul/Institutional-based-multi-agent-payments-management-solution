<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $userId  = $postData->userId;
    $user_name =   $postData->username;
    $user_email = $postData->userEmail;
    $user_phone = $postData->userPhone;
    $roleId = $postData->role;
    $passcode = $postData->secureCode;
    $merchantId = $postData->merchantid;
    
    $progId = $postData->prog;
    $category = $postData->categ;
    $level = $postData->levl;
    $nationality = $postData->national;

    if($passcode != 'secured')
    {
      
      $securecode = hash('sha256', $passcode);

      $edit_admin_user = $paydb->query("UPDATE ".USERS." SET user_name = '$user_name', user_email = '$user_email', user_phone = '$user_phone', roleId = '$roleId', secure_code = '$securecode' WHERE userId = '$userId' AND merchantId = '$merchantId' ") or die (mysqli_error($paydb));

    }
    else
    {
         $edit_admin_user = $paydb->query("UPDATE ".USERS." SET user_name = '$user_name', user_email = '$user_email', user_phone = '$user_phone', roleId = '$roleId' WHERE userId = '$userId' AND merchantId = '$merchantId' ") or die (mysqli_error($paydb));
    }

   
    if((!is_null($progId)) && (!is_null($category)) && (!is_null($level)) && (!is_null($nationality)) )   
    {        
             //Checkk usr details
            $check = $paydb->query("SELECT * FROM ".USER_DETAILS." WHERE userId = '$userId' ") or die (mysqli_error($paydb));

            if(mysqli_num_rows($check) > 0)
            {
                //then update user details
                $upd_details = $paydb->query("UPDATE ".USER_DETAILS." SET progId = '$progId', category = '$category', level = '$level', nationality = '$nationality' WHERE userId = '$userId' ") or die (mysqli_error($paydb));

            }
            else
            {
                //Insert new record
                $insert = $paydb->query("INSERT INTO ".USER_DETAILS." (userId, progId, category, level, nationality, merchantId) VALUES ('$userId', '$progId', '$category', '$level', '$nationality', '$merchantId') ") or die (mysqli_error($paydb));
            }
    
    }

                 //$data = "";

            	if($edit_admin_user)
            	{
            		$data = 'User Details Edited Successfully';
            	}
                else
                {
                	$data =  'Operation Failed. Please try again.';
                }
                
                echo json_encode($data);
            


?>
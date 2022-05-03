<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $merchantId = trim_input($_POST['merchantId']);
    $payment_choice_name = trim_input(ucwords($_POST['payment_choice_name']));
    $req_fee_items = trim_input($_POST['req_fee_items']);

    function throw_ex($err)
    {
    	throw new Exception($err);
    }

    try
    {
        //Check availability first

        $lookup = $paydb->query("SELECT *  FROM ".PAYMENT_CHOICE." WHERE merchantId = '$merchantId' AND payment_choice_name = '$payment_choice_name'") or throw_ex(mysqli_error($paydb));
        
        if(mysqli_num_rows($lookup) > 0)
        {
                echo '<div class="alert alert-warning alert-dismissible fade in" role="alert style="color:#FFF"> 
                 <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                 <i class="fa fa-warning"></i> This Choice Name Already Exist for this Merchant. 
                 </div>';
        }
        else
        {
            	//Insert Payment Choice
            	$insert_payment_choice = $paydb->query("INSERT INTO ".PAYMENT_CHOICE. "(merchantId, payment_choice_name, req_fee_items) VALUES ('$merchantId', '$payment_choice_name', '$req_fee_items')") or throw_ex(mysqli_error($paydb));

            	if($insert_payment_choice)
            	{
            		echo '<div class="alert alert-success alert-dismissible fade in" role="alert style="color:#FFF"> 
                         <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                         <i class="fa fa-ok"></i> New Payment Choice Created 
                         </div>';
            	}
                else
                {
                	echo '<div class="alert alert-danger alert-dismissible fade in" role="alert style="color:#FFF"> 
                         <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                         <i class="fa fa-ban"></i> Operation Failed. Please try again. 
                         </div>';
                }
        }
    }
    catch(Exception $e) 
    {
         echo 'Error: '.$e;
    }


?>
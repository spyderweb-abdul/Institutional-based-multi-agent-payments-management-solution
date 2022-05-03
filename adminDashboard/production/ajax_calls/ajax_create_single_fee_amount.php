<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $setupId =  $_POST['setupId'];
    $fee_amount = $_POST['fee_amount'];

    function throw_ex($err)
    {
    	throw new Exception($err);
    }

    try
    {
                 //Insert Payment Choice
        $insert_single_fee = $paydb->query("INSERT INTO ".FEES. "(setupId, fee_amount) VALUES ('$setupId', '$fee_amount') ") or throw_ex(mysqli_error($paydb));

            	if($insert_single_fee)
            	{
            		echo '<div class="alert alert-success alert-dismissible fade in" role="alert style="color:#FFF"> 
                         <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                         <i class="fa fa-ok"></i> Single Fee Amount Created Successfully
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
    catch(Exception $e) 
    {
         echo 'Error: '.$e;
    }


?>
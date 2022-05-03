<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $merchantId = trim_input($_POST['merchantId_type']);//Trivial though
    $choiceId = trim_input($_POST['choiceId']);
    $payment_type_name = trim_input(ucwords($_POST['payment_type_name']));

    function throw_ex($err)
    {
    	throw new Exception($err);
    }

    try
    {
        //Check availability first

        $lookup = $paydb->query("SELECT *  FROM ".PAYMENT_TYPE." WHERE choiceId = '$choiceId' AND payment_type_name = '$payment_type_name'") or throw_ex(mysqli_error($paydb));
        
        if(mysqli_num_rows($lookup) > 0)
        {
                echo '<div class="alert alert-warning alert-dismissible fade in" role="alert style="color:#FFF"> 
                 <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                 <i class="fa fa-warning"></i> This Payment Type Name Already Exist for this Payment Choice. 
                 </div>';
        }
        else
        {
            	//Insert Payment Choice
            	$insert_payment_type = $paydb->query("INSERT INTO ".PAYMENT_TYPE. "(choiceId, payment_type_name) VALUES ('$choiceId', '$payment_type_name')") or throw_ex(mysqli_error($paydb));

            	if($insert_payment_type)
            	{
            		echo '<div class="alert alert-success alert-dismissible fade in" role="alert style="color:#FFF"> 
                         <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                         <i class="fa fa-ok"></i> New Payment Type Created 
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
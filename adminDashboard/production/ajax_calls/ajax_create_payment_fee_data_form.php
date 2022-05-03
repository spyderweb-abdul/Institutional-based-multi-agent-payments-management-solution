<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

if(isset($_GET['choiceid']))
{

    //$merchantId = trim_input($_GET['merchantId_fee']);//Trivial though
    $choiceId = trim_input($_GET['choiceid']);
    $typeId = trim_input($_GET['typeid']);
    $setup_name = trim_input(strtoupper($_GET['setupname']));
    $service_type_id = trim_input($_GET['serviceid']);
    $payment_code = trim_input($_GET['paymentcode']);
    $gatewayId = trim_input($_GET['activegateway']);
    $reprocessible = trim_input($_GET['reprocessible']);

    function throw_ex($err)
    {
    	throw new Exception($err);
    }

    try
    {
              //lookup if entry exist before
              $lookup = $paydb->query("SELECT * FROM ".SETUP." WHERE choiceId = '$choiceId' AND typeId = '$typeId' AND gatewayId = '$gatewayId' AND merchantId = '$merchantId' ") or throw_ex(mysqli_error($paydb));
              if(mysqli_num_rows($lookup) > 0)
              {
                    //Just update the necessary fields
                    $update_entry = $paydb->query("UPDATE ".SETUP." SET setup_name = '$setup_name', service_type_id = '$service_type_id', reprocessible = '$reprocessible' WHERE choiceId = '$choiceId' AND typeId = '$typeId' AND merchantId = '$merchantId' ") or throw_ex(mysqli_error($paydb)) or throw_ex(mysqli_error($paydb));

                    echo '<div class="alert alert-success alert-dismissible fade in" role="alert style="color:#FFF"> 
                               <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                               <i class="fa fa-ok"></i> Payment Setup Profiled Successfully
                               </div>';
              }
              else
              {
              //Insert Payment Choice
                	$insert_payment_setup_param = $paydb->query("INSERT INTO ".SETUP. "(choiceId, typeId, gatewayId, setup_name, service_type_id, payment_code, reprocessible, merchantId) VALUES ('$choiceId', '$typeId', '$gatewayId', '$setup_name', '$service_type_id', '$payment_code', '$reprocessible', '$merchantId') ") or throw_ex(mysqli_error($paydb));

                  	if($insert_payment_setup_param)
                  	{
                  		echo '<div class="alert alert-success alert-dismissible fade in" role="alert style="color:#FFF"> 
                               <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                               <i class="fa fa-ok"></i> Payment Setup Profiled Successfully
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
}


?>
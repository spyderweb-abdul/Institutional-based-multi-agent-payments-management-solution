<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $gatewayId =  $_POST['gatewayid'];
    $option_name = trim_input($_POST['gateway_option']);

    function throw_ex($err)
    {
    	throw new Exception($err);
    }

    try
    {
                 //Insert Payment Choice
            	$insert_gateway_option = $paydb->query("INSERT INTO ".PAY_OPTIONS. "(gatewayId, option_name) VALUES ('$gatewayId', '$option_name') ") or throw_ex(mysqli_error($paydb));

            	if($insert_gateway_option)
            	{
            		echo '<div class="alert alert-success alert-dismissible fade in" role="alert style="color:#FFF"> 
                         <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                         <i class="fa fa-ok"></i> New Gateway Option Profiled
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
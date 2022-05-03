<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $gateway_name = trim_input($_POST['gateway_name']);//Trivial though
   
    function throw_ex($err)
    {
    	throw new Exception($err);
    }

    try
    {
                 //Insert Payment Choice
            	$insert_gateway = $paydb->query("INSERT INTO ".CHANNEL. "(gateway_name) VALUES ('$gateway_name') ON DUPLICATE KEY UPDATE gateway_name = '$gateway_name'") or throw_ex(mysqli_error($paydb));

            	if($insert_gateway)
            	{
            		echo '<div class="alert alert-success alert-dismissible fade in" role="alert style="color:#FFF"> 
                         <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                         <i class="fa fa-ok"></i> New Gateway Profiled
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
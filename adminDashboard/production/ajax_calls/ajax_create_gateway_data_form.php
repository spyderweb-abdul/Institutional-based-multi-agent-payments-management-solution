<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $merchant_name = trim_input($_POST['merch_name']);
    $gatewayId = $_POST['gatewayId'];
    $merchant_gateway_id = trim_input($_POST['merchant_gateway_id']);
    $merchant_apikey = trim_input($_POST['merchant_apikey']);

    function throw_ex($err)
    {
    	throw new Exception($err);
    }

    try
    {
       //select the merchant Id first
    	$merch_id = $paydb->query("SELECT merchantId FROM ".MERCHANTS. " WHERE merchant_name = '$merchant_name' ") or throw_ex(mysqli_error($paydb));
    	$fetchId = $merch_id->fetch_array();

    	$merchantId = $fetchId['merchantId'];

    	//Insert Gateway profile
    	$insert_profile = $paydb->query("INSERT INTO ".MERCHANT_PROFILE. "(merchantId, gatewayId, merchant_gateway_id, merchant_apikey) VALUES ('$merchantId', '$gatewayId', '$merchant_gateway_id', '$merchant_apikey') ON DUPLICATE KEY UPDATE merchantId = '$merchantId', gatewayId = '$gatewayId', merchant_gateway_id = '$merchant_gateway_id', merchant_apikey = '$merchant_apikey' ") or throw_ex(mysqli_error($paydb));

    	//Insert Active Gateway
    	$insert_active = $paydb->query("INSERT INTO ".ACTIVE_CHANNEL. "(merchantId, gatewayId, status) VALUES ('$merchantId', '$gatewayId', 'ACTIVE') ON DUPLICATE KEY UPDATE merchantId = '$merchantId', gatewayId = '$gatewayId', status = 'ACTIVE' ") or throw_ex(mysqli_error($paydb));

    	if($insert_profile && $insert_active)
    	{
    		echo '<div class="alert alert-success alert-dismissible fade in" role="alert style="color:#FFF"> 
                 <a href="#" class="close" data-dismiss="alert" aria-label="Close">×</a>
                 <i class="fa fa-ok"></i> New Gateway Profile Created for '.$merchant_name.' 
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
<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];
    $merchant_name = $getDetails['merchant_name'];

if(isset($_POST['optionId']))
{
//$merchant_name = trim_input($_POST['merch_name']);
//$gatewayId = $_POST['gatewayId'];
$optionId = $_POST['optionId'];

//print_r($optionId);

//Get Merchant ID first
//$get_merchant_id = $paydb->query("SELECT merchantId FROM ".MERCHANTS." WHERE merchant_name = '$merchant_name' ");
//$fetch_id = $get_merchant_id->fetch_array();

//$merchantId = $fetch_id['merchantId'];

function throw_ex($err)
{
	throw new Exception($err);
}

try
{

		foreach($optionId as $x)
		{
			$insert_sel_options = $paydb->query("INSERT INTO ".OPTION_LIST." (merchantId, optionId) VALUES ('$merchantId', '$x') ON DUPLICATE KEY UPDATE optionId = '$x' ") or throw_ex(mysqli_error($paydb));
		}
		if($insert_sel_options)
		{
			echo '<p style="color:#1ABC9C;"> <i class="fa fa-angle-double-right"> </i> Payment Options Built Successfully for '.$merchant_name.' </p>';
		}
}
catch(Exception $e)
{
  echo 'Error: '.$e;
}

}
else
{
	echo '<p style="color:red"> Error: *Option(s) Not Selected </p>';
}


?>
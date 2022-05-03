<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

$userId = trim_input($_POST['userId']);
$session = trim_input($_POST['session']);
$setupId = $_POST['setupId'];


$sel_payer_gateway = $paydb->query("SELECT DISTINCT c.gatewayId, c.gateway_name FROM ".USERS." a 
								   INNER JOIN ".PAYMENT_RECORDS." b ON b.merchantId = a.merchantId
								   INNER JOIN ".CHANNEL." c ON c.gatewayId = b.gatewayId
								   WHERE b.userId = '$userId' AND b.session = '$session' AND b.setupId = '$setupId' ");
if(mysqli_num_rows($sel_payer_gateway) > 0)
{
 echo '<div class="row">
        <div class="col-md-10">';
		   
		   echo '<h6> <strong>Select Appropriate Channel from which you want to verify:</strong> <br/><br/>';
		   echo '<div class="panel panel-default">
                 <div class="panel-body">';
		   while($row = $sel_payer_gateway->fetch_array())
			{
				echo '<label class="radio-inline">';			
			  	echo  '<input type="radio" name="gateway" id="gateway" value="'.$row[1].'" onclick="get_invoice()" >'.$row[1];
			    echo '</label>'; 
			}
			echo '</h6></div></div>';
echo '</div></div>';
							  
}
else
{
	echo '<button class="btn btn-danger btn-sm"> Invoice Not Found! </button>';
}


 ?>
<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

if(isset($_POST['setupId']))
{

$setupId = $_POST['setupId'];
$userId = trim_input($_POST['userId']);
$session = trim_input($_POST['session']);


$sel_payer_gateway = $paydb->query("SELECT DISTINCT b.gatewayId, b.gateway_name FROM ".PAYMENT_RECORDS." a
								   INNER JOIN ".CHANNEL." b ON b.gatewayId = a.gatewayId
								   WHERE a.userId = '$userId' AND a.session = '$session' AND a.setupId = '$setupId' ");
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
			  	echo  '<input type="radio" name="gateway" id="gateway" value="'.$row[0].'" onclick="get_invoice()" >'.$row[1];
			    echo '</label>'; 
			}
			echo '</h6></div></div>';
echo '</div></div>';
							  
}
else
{
	echo '<button class="btn btn-danger btn-sm">Error: Payment Details Cannot be Fetched</button>';
}

}
else //If setupId is not set
{
	echo '<button class="btn btn-danger btn-sm"> No Payment Type Selection </button>';
}

 ?>
<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

$userId = trim_input($_POST['userId']);
$session = trim_input($_POST['session']);
$setupId = $_POST['setupId'];


$sel_payer_invoice = $paydb->query("SELECT * FROM ".USERS." a 
								   INNER JOIN ".PAYMENT_RECORDS." b ON b.merchantId = a.merchantId
								   INNER JOIN ".CHANNEL." c ON c.gatewayId = b.gatewayId
								   WHERE b.userId = '$userId' AND b.session = '$session' AND b.setupId = '$setupId' ");
if(mysqli_num_rows($sel_payer_invoice) > 0)
{
  $get_invoice = $sel_payer_invoice->fetch_array();
  
    $merchantId = $get_invoice['merchantId'];
    $invoice = $get_invoice['invoice'];
	$gateway_name = $get_invoice['gateway_name'];
	$gatewayId = $get_invoice['gatewayId'];

 echo '<div class="row">
        <div class="col-md-6">
		 <label class="pay-detail-form-label"> Your Transaction Invoice No: </label> 
          <div class="input-group">
           <span class="input-group-addon"><i class="fa fa-file"></i></span>
             <input type="text" class="form-control pay-detail-form" name="invoice" id="invoice" value="'.$invoice.'" readonly />
	       </div></div></div><br/>';
		   
		   echo '<h6> Transaction Gateway: <br/><br/>';
		    echo '<label class="radio-inline">
			<input type="radio" name="gateway" id="gateway" value="'.$gateway_name.'" checked >'.$gateway_name.
			'</label> </h6>';
							  
}
else
{
	echo '<button class="btn btn-danger btn-sm"> Invoice Not Found! </button>';
}


 ?>
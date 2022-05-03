<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

$userId = trim_input($_POST['userId']);
$session = trim_input($_POST['session']);
$setupId = $_POST['setupId'];
$gatewayId = trim_input($_POST['gateway']);


$sel_payer_invoice = $paydb->query("SELECT a.invoice FROM ".PAYMENT_RECORDS." a 
								   INNER JOIN ".CHANNEL." b ON b.gatewayId = a.gatewayId
								   WHERE a.userId = '$userId' AND a.session = '$session' AND a.setupId = '$setupId' AND a.gatewayId = '$gatewayId' ");
if(mysqli_num_rows($sel_payer_invoice) > 0)
{
  $get_invoice = $sel_payer_invoice->fetch_array();

 echo '<div class="row">
        <div class="col-md-6">
		 <label class="pay-detail-form-label"> Your Transaction Invoice No: </label> 
          <div class="input-group">
           <span class="input-group-addon"><i class="fa fa-file"></i></span>
             <input type="text" class="form-control pay-detail-form" name="invoice" id="invoice" value="'.$get_invoice[0].'" readonly />
	     </div></div></div><br/>';

}
else
{
	echo '<button class="btn btn-danger btn-sm">Invoice Not Found!</button>';
}


 ?>
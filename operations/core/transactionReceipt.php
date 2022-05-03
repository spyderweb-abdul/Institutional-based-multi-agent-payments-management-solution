<?php
include_once '../../config/connections/constant_connection.php';
include_once '../../config/constant_define/constants.php';

if(isset($_GET['invoice']))
{
	$invoice = $_GET['invoice'];
//Query the database
$sel_details = $paydb->query("SELECT * FROM ".PAYMENT_RECORDS." a 
							  INNER JOIN ".USERS." b ON b.userId = a.userId 
                              INNER JOIN ".SETUP." c ON c.setupId = a.setupId
							  INNER JOIN ".CHANNEL." d ON d.gatewayId = a.gatewayId
							  INNER JOIN ".PAY_OPTIONS." e ON e.optionId = a.optionId
							  INNER JOIN ".MERCHANTS." f ON f.merchantId = a.merchantId
							  WHERE a.invoice = '$invoice' " );
 
if(mysqli_num_rows($sel_details) > 0)
{		  
$details = $sel_details->fetch_array();

$dir = "../../logos/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="" />
<title>Paytonify</title>

<link href="../../plugins/bootstrap_css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../../plugins/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="../../plugins/custom_css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
 function direct()
 {
	 window.location = "index.php";
 }
</script>
</head>

<body>

<div style="padding:20px;">
<div class="row">
<div class="col-md-3"> </div>
<div class="col-md-6"> 
<div style="display:block; text-align:center" class="payment-receipt-logo-text"> <?php echo '<img src="'.$dir.$details['logo'].'" /> <br/> '.$details['merchant_name']. '</div>'; ?> </div>
</div>
<div class="col-md-3"> </div>
</div>

<br/>

<div class="row">
<div class="col-md-3"></div>
<div class="col-md-6">
<table class="table-bordered table-striped table-condensed table-hover table-responsive payment-receipt" width="100%" align="center">
 <tr> <th colspan="2"> PAYMENT TRANSACTION RECEIPT </th> </tr>
 	<tr><td> <strong>Payer's Name</strong> </td> <td> <?php echo $details['user_name'] ?></td> </tr>
    <tr><td> <strong>Payer's Phone</strong> </td> <td> <?php echo $details['user_phone'] ?></td> </tr>
    <tr><td> <strong>Payer's Email</strong> </td> <td> <?php echo $details['user_email'] ?></td> </tr>
    <tr><td> <strong>Invoice/Trans.ID</strong> </td> <td> <?php echo $details['invoice'] . ' | '. $details['transactionId'] ?></td> </tr>
    <tr><td> <strong>Purpose</strong> </td> <td> <?php echo $details['setup_name'] ?> </td> </tr>
    <tr><td> <strong>Amount</strong> </td> <td> <?php echo number_format($details['amount'], 2) ?> </td> </tr>
    <tr><td> <strong>Status</strong> </td> <td> <?php echo $details['status'] ?> </td> </tr>
    <tr><td> <strong>Date Time</strong> </td> <td> <?php echo $details['dateTime'] ?> </td> </tr>
     <tr><td> <strong>Channel</strong> </td> <td> <?php echo $details['gateway_name'] ?> <i class="fa fa-angle-double-right"></i> <?php echo $details['option_name'] ?> </td> </tr>
    <tr> <td colspan="2"> <div class="pull-right alert alert-link"> <a href="#" onclick="direct()"> <i class="fa fa-home"> </i> Back to Home </a> | <a href="#" onclick="window.print();"> <i class="fa fa-print"> </i> Print Receipt </a>  </td> </tr>

</table>
</div>
<div class="col-md-3"></div>
</div>

<div style="display:block; text-align:center; margin-top: 50px;"> <i class="fa fa-copyright"> </i> 2017 Paytonify <sup> <i class="fa fa-trademark"></i></sup> </div>
<?php }} ?>


</body>
</html>
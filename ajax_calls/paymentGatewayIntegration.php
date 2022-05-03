<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';
include_once '../config/constant_param/constant_param.php';

echo '<button type="button" class="btn btn-sm btn-success" style="text-align:center;"> <i class="fa fa-spinner fa-spin"> </i> Please wait...Processing </button>';

$param = $_POST['param'];

//Break the $param array
$userId = $param[0];
$gatewayId = $param[1];
$setupId = $param[2];
$optionId = $param[3];
$merchantId = $param[4];
$session = $param[5];

//Query the database
$sel_details = $paydb->query("SELECT * FROM ".PAYMENT_RECORDS." a 
							  INNER JOIN ".USERS." b ON b.userId = a.userId 
                              INNER JOIN ".SETUP." c ON c.setupId = a.setupId
							  INNER JOIN ".CHANNEL." d ON d.gatewayId = a.gatewayId
							  INNER JOIN ".PAY_OPTIONS." e ON e.optionId = a.optionId
							  INNER JOIN ".MERCHANTS." f ON f.merchantId = a.merchantId
							  INNER JOIN ".MERCHANT_PROFILE." g ON g.merchantId = a.merchantId
							  WHERE a.userId = '$userId' AND a.setupId = '$setupId' AND a.merchantId = '$merchantId' AND a.gatewayId = '$gatewayId' AND a.optionId = '$optionId' AND a.session = '$session' " );

if(mysqli_num_rows($sel_details) > 0)
{		  
$details = $sel_details->fetch_array();

//assign variables
$user_name = $details['user_name'];
$user_phone = $details['user_phone'];
$amount = $details['amount'];
$invoice = $details['invoice'];
$gateway_name = $details['gateway_name'];
$setup_name = $details['setup_name'];
$session = $details['session'];
$description = $setup_name." - ".$invoice;
$serviceId = $details['service_type_id'];//Sevice type ID
$merchant_gateway_id = $details['merchant_gateway_id'];//Gateway ID provided by Remita
$merchant_apikey = $details['merchant_apikey']; //API key provided by Remita
$status = 'PENDING';
$merchant_name = $details['merchant_name'];

$logo = $details['logo'];
$dir = "logos/";
$logo = $dir.$logo;

$logo_url = $_SERVER['HTTP_HOST'].$logo;

//If the payer has no email, use the merchant's email
if($details['user_email'] == '')
{
	$user_email = $details['merchant_email'];
}
else //otherwise
{
	$user_email = $details['user_email'];
}


 //Call the email function here and send invoice notice
 invoice_notification($user_name, $user_email, $user_phone, $session, $gateway_name, $status, $setup_name, $userId, $invoice, $merchant_name, $amount, $optionId, $setupId, $merchantId);	



//************* Remita API Connection Starts Here ********************************//
if($gateway_name == 'Remita')//If Selection gateway is REMITA
{

	define("MERCHANTID", $merchant_gateway_id);//demo
	define("SERVICETYPEID", $serviceId);//demo
	define("APIKEY", $merchant_apikey);//demo


	$responseurl = PATH ."/remitaOnlinePaymentConfirmationPage.php";
	$concatString = MERCHANTID . SERVICETYPEID . $invoice. $amount . $responseurl . APIKEY;
	$hash = hash('sha512', $concatString);
	$timesammp= DATE("dmyHis");		
		
				echo '<form action="'.GATEWAYURL.'" id="process_pay_remita" name="process_pay_remita" method="POST">
				<input id="merchantId" name="merchantId" value="'.MERCHANTID.'" type="hidden"/>
				<input id="serviceTypeId" name="serviceTypeId" value="'.$serviceId.'" type="hidden"/>
				<input id="amt" name="amt" value="'.$amount.'" type="hidden"/>
				<input id="responseurl" name="responseurl" value="'.$responseurl.'" type="hidden"/>
				<input id="hash" name="hash" value="'.$hash.'" type="hidden"/>
				<input id="payerName" name="payerName" value="'.$user_name.'" type="hidden"/>
				<input id="paymenttype" name="paymenttype" value="'.$setup_name.'" type="hidden"/>
				<input id="payerEmail" name="payerEmail" value="'.$user_email.'" type="hidden"/>
				<input id="payerPhone" name="payerPhone" value="'.$user_phone.'" type="hidden"/>
				<input id="orderId" name="orderId" value="'.$invoice.'" type="hidden"/>
				<input id="description" name="description" value="'.$description.'" type="hidden"/>
				</form>
				<script type="text/javascript">document.getElementById("process_pay_remita").submit();</script>';

}


//************* Etanzact API Connection Starts here ******************
else if($gateway_name == 'Etranzact')//If selection gateway is ETRANZACT
{

$success = "";
define("TERMINALID", $merchant_gateway_id);//demo
define("APIKEY", $merchant_apikey);//demo

		
		 // $terminalId = "0000000001";
         // $secret_key = "DEMO_KEY";
          $responseurl = PATH."/etranzactOnlinePaymentConfirmationPage.php";
          $str = $amount. TERMINALID. $invoice. $responseurl. APIKEY;
          $checksum = hash("sha256", $str);
	
				//echo "Requesting Transaction ID . . .  ";
				if($success == NULL)
				{
					echo "<form id='process_pay_etranzact' name='process_pay_etranzact' method='POST' action='https://demo.etranzact.com/bankIT/'>";
					echo "<input type='hidden' name='TERMINAL_ID' value='".TERMINALID."'>";
					echo "<input type='hidden' name = 'TRANSACTION_ID' value='".$invoice."'>";
					echo "<input type='hidden' name = 'AMOUNT' value='".$amount."'>";
					echo "<input type='hidden' name = 'DESCRIPTION' value='".$setup_name."'>";
					echo "<input type='hidden' name = 'EMAIL' value='".$user_email."'>";
					echo "<input type='hidden' name = 'PHONE' value='".$user_phone."'>";
					echo "<input type='hidden' name = 'RESPONSE_URL' value='".$responseurl."'>";
					echo "<input type='hidden' name = 'CHECKSUM' value='".$checksum."'>"; 
					echo "<input type='hidden' name = 'LOGO_URL' value='".$logo_url."'>";
					echo "</form>";
					echo '<script type="text/javascript">document.getElementById("process_pay_etranzact").submit();</script>';
				}
				else if($success == 0){	echo "Transaction Successfull"; }
				else {	echo "Error while requesting for transaction authorisation, Transaction ID no more valid "; }
				}
				//etranzact API ends here

//************* GTPAY API Connection Starts here ******************
else if($gateway_name == 'GTPay')//If selection gateway is GTPay
{
	define("CUSTOMERID", $merchant_gateway_id);//demo
	define("APIKEY", $merchant_apikey);//demo
	
	$hashkey = hash_hmac('sha1', CUSTOMERID, APIKEY);
	$responseurl = PATH."/etranzactOnlinePaymentConfirmationPage.php";
	$cancelurl = 'https://www.paytonify.com';
		
			echo '<form method="post" name="process_pay_gtpay" id="process_pay_gtpay" action="http://www.gtpayment.com/gtmpayment.do">
					<input type="hidden" name="lang" value="en-US" />
					<input type="hidden" name="member" value="GTPay account" />
					<input type="hidden" name="productid" value="'.$invoice.'" /> 
					<input type="hidden" name="product" value="'.$setup_name.'" /> 
					<input type="hidden" name="price" value="'.$amount.'" />
					<input type="hidden" name="membercurrency" value="NGN" />
					<input type="hidden" name="ucancel" value="'.$cancelurl.'" />
					<input type="hidden" name="ureturn" value="'.$responseurl.'" />
					<input type="hidden" name="unotify" value="Notify URL" />
					<input type="hidden" name="api_exclude" value="alipay,paypal" />
					<input type="hidden" name=" trace_no" value="0123456789" />
					<input type="hidden" name="custom_email" value="'.$user_email.'" />
					<input type="hidden" name="secret_key" value="877e2cf7e71c4fcb04bbad17ae46556f50936ebc" />
					</form>
					<script type="text/javascript">document.getElementById("process_pay_gtpay").submit();</script>';

}//GtPay ends here

//**********Interswitch Webpay Integration Starts here *****************/
else if($gateway_name == 'Interswitch')
{
	$success = "";
	define("CUSTOMERID", $merchant_gateway_id);//demo
	define("APIKEY", $merchant_apikey);//demo
	
	$responseurl = PATH."/interswitchOnlinePaymentConfirmationPage.php?invoice=".$invoice;
	$site_name = 'https://www.paytonify.com';
	$dateTime = date("d-m-Y h:i:sa");
	
	$product_id = '6205';
	$pay_item_id = '101';
	$mackey = '';
	

	$hash = 'D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F';
	//$hash = hash('SHA512', $invoice.$product_id.$pay_item_id.$amount.$responseurl.APIKEY);
			if($success == null)
			{
				echo '<form name="process_pay_interswitch" id="process_pay_interswitch" action="https://stageserv.interswitchng.com/test_paydirect/pay" method="post">
				<input name="product_id" type="hidden" value="'.$product_id.'" />
				<input name="amount" type="hidden" value="'.$amount.'" />
				<input name="currency" type="hidden" value="566" />
				<input name="site_redirect_url" type="hidden" value="'.$responseurl.'" />
				<input name="site_name" type="hidden" value="'.$site_name.'" />
				<input name="cust_id" type="hidden" value="'.$userId.'" />
				<input name="cust_id_desc" type="hidden" value="Payer Unique ID" />
				<input name="cust_name" type="hidden" value="'.$user_name.'" />
				<input name="cust_name_desc" type="hidden" value="Full name" />
				<input name="txn_ref" type="hidden" value="'.$invoice.'" />
				<input name="pay_item_id" type="hidden" value="'.$pay_item_id.'" />
				<input name="pay_item_name" type="hidden" value="'.$setup_name.'" />
				<input name="local_date_time" type="hidden" value="'.$dateTime.'" />
				<input name="hash" type="hidden" value="'.$hash.'" />
				</form>
				<script type="text/javascript">document.getElementById("process_pay_interswitch").submit();</script>';
			}

			else if($success == 0){	echo "Transaction Successfull"; }
			else {	echo "Error while requesting for transaction authorisation, Transaction ID no more valid "; }
			
			
}//Interswitch Integration Ends Here

}//mysql_num_rows ends here
else //If query doesn't execute
{
	echo '<span class="alert alert-danger"> Gateway Connection Error: Please try again. </span>';
}
?>
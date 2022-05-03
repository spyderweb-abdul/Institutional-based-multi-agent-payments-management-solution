<?php
 
 include_once '../config/constant_param/online_constant_verification_param.php';
 include_once '../config/connections/constant_connection.php';
 include_once '../config/constant_define/constants.php';
 include_once '../config/functions/control_functions.php';

echo '<html xmlns="http://www.w3.org/1999/xhtml">
      <head>
      <link rel="stylesheet" href="../plugins/custom_css/style.css" type="text/css" />
	  <link href="../plugins/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	  </head>
	  <body>';

        /* All these are from Interswitch, Do not see the need for these anyway, except the $tnxref */
		$invoice = $_GET['invoice'];
		/*
	    $tnxRef = $_POST['tnxRef'];
		$payRef = $_POST['payRef'];
		$refRef = $_POST['refRef'];
		$cardNum = $_POST['cardNum'];
		$apprAmt = $_POST['apprAmt'];
		*/
		
		$parameters = get_payer_merchant($invoice);

		/*assign variables*/
		$userId = $parameters['userId'];
		$user_name = $parameters['user_name'];
		$user_phone = $parameters['user_phone'];
		$user_email = $parameters['user_email'];
		$amount = $parameters['amount'];
		$gateway_name = $parameters['gateway_name'];
		$setup_name = $parameters['setup_name'];
		$service_id = $parameters['service_type_id'];
		$session = $parameters['session'];
		$merchant_name = $parameters['merchant_name'];
		//$invoice = $parameters['invoice'];
		$amount = $parameters['amount'];
		
		$product_id = '6205'; //To be provided
		$pay_item_id = '101'; //To be provided
		$responseurl = PATH."/interswitchOnlinePaymentConfirmationPage.php";
		$mackey = '';  //To be provided
	    $hash = 'D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F';

		
		$hashtoken = $invoice.$product_id.$pay_item_id.$amount.$responseurl.$hash;
		
		function get_transaction_details($orderId)
		{
			global $product_id;
			global $amount;
			global $hashtoken;
			
			
			$concatstring = $product_id.$orderId.$hashtoken;
			$new_hash = hash('SHA512', $concatstring);
			
			$headers = array("UserAgent: Mozilla/4.0 (compatible; MSIE 6.0; MS Web Services Client Protocol 4.0.30319.238)",
			                 "Hash: $new_hash",
							 "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8");
						
			$fields = array('productid' => $product_id, 'transactionreference' => $orderId, 'amount' => $amount);

			$request_url = 'https://stageserv.interswitchng.com/test_paydirect/api/v1/gettransaction.json';
			
			 $phpCurl = curl_init();
			
			 //We need a return transfer of callback parameters
			 curl_setopt($phpCurl, CURLOPT_RETURNTRANSFER, true);
			 //The request is on a GET Method
			 curl_setopt($phpCurl, CURLOPT_HTTPGET, true);
			 //We have to use http_build_query so that the &seperator will be appended behind all parametersecept the last one
			 curl_setopt($phpCurl, CURLOPT_POSTFIELDS, http_build_query($fields)); 
			 //We pass the Hash and other params as headers
			 curl_setopt($phpCurl, CURLOPT_HTTPHEADER, $headers);
			 //The main URL
			 curl_setopt($phpCurl, CURLOPT_URL, $request_url);
			 
			 $result = curl_exec($phpCurl);
			 curl_close($phpCurl);
			 
			 $response = json_decode($result, true);
			 
			 return $response;
		}
		
		if($invoice != null)
		{
			$response = get_transaction_details($invoice);
			
			$response_code = $response['ResponseCode'];
			$paymentRef = $response['PaymentReference'];
			$dateTime = $response['TransactionDate'];

			echo $response_code."\n";
			echo $paymentRef."\n";
			echo $dateTime."\n";

					 switch ($response_code)
					  {
						case 00:
							$status_desc = "Transaction successful. Payment accepted";
							break;
						case 01:
							$status_desc = "Refer to Financial Institution";
							break;
						case 02:
							$status_desc = "Refer to Financial Institution, Special Condition";
							break;
						case 03:
							$status_desc = "Invalid Merchant";
							break;
						case 04:
							$status_desc = "Pick-up Card";
							break;
						case 05:
							$status_desc = "Do Not Honour";
							break;
						case 06:
							$status_desc = "Error";
							break;
						case 07:
							$status_desc = "Pick-Up Card, Special Condition";
							break;
						case 08:
							$status_desc = "Honour With Identification";
							break;
						case 09:
							$status_desc = "Request in Progress";
							break;
						case 10:
							$status_desc = "Approved by Financial Institution, Partial";
							break;
						case 11:
							$status_desc = "Approved by Financial Institution, VIP";
							break;
						case 12:
							$status_desc = "Invalid Transaction";
							break;
						case 13:
							$status_desc = "Invalid Amount";
							break;
						case 14:
							$status_desc = "The Card number input is invalid, please re-try with a valid card number";
							break;
						case 15:
							$status_desc = "No Such Financial Institution";
							break;
						case 16:
							$status_desc = "Approved by Financial Institution, Update Track 3";
							break;
						case 17:
							$status_desc = "ustomer Cancelation";
							break;
						case 18:
							$status_desc = "Customer Dispute";
							break;
						case 19:
							$status_desc = "Re-enter Transaction";
							break;
						case 20:
							$status_desc = "Invalid Response from Financial Institution";
							break;
						case 21:
							$status_desc = "No Action Taken by Financial Institution";
							break;
						case 22:
							$status_desc = "Suspected Malfunction";
							break;
						case 23:
							$status_desc = "Unacceptable Transaction Fee";
							break;
						case 24:
							$status_desc = "File Update Not Supported";
							break;
						case 26:
							$status_desc = "Duplicate Record";
							break;
						case 27:
							$status_desc = "File Update Field Edit Error";
							break;
						case 28:
							$status_desc = "File Update File Locked";
							break;
						case 29:
							$status_desc = "File Update Failed";
							break;
						case 30:
							$status_desc = "Format Error";
							break;
						case 31:
							$status_desc = "Bank Not Supported";
							break;
						case 32:
							$status_desc = "Completed Partially by Financial Institution";
							break; 
						case 33:
							$status_desc = "Expired Card, Pick-Up";
							break;
						case 34:
							$status_desc = "Suspected Fraud, Pick-Up";
							break;
						case 35:
							$status_desc = "Contact Acquirer, Pick-Up";
							break;
						case 36:
							$status_desc = "Restricted Card, Pick-Up";
							break;
						case 37:
							$status_desc = "Call Acquirer Security, Pick-Up";
							break;
						case 38:
							$status_desc = "PIN Tries Exceeded, Pick-UP";
							break;
						case 39:
							$status_desc = "No Credit Account";
							break;
						case 40:
							$status_desc = "Function Not Supported";
							break;
						case 41:
							$status_desc = "Lost Card, Pick-Up";
							break;           
						case 42:
							$status_desc = "No Universal Account";
							break;
						case 44:
							$status_desc = "No Investment Account";
							break;
						case 51:
							$status_desc = "Insufficient Funds";
							break;
						case 52:
							$status_desc = "No Check Account";
							break;
						case 53:
							$status_desc = "No Savings Account";
							break;
						case 54:
							$status_desc = "Expired Card";
							break;
						case 55:
							$status_desc = "Incorrect PIN";
							break;
						case 56:
							$status_desc = "No Card Record";
							break;
						case 57:
							$status_desc = "Your bank has prevented your card from carrying out this transaction, please contact your bank";
							break;
						case 59:
							$status_desc = "Suspected Fraud";
							break;
						case 60:
							$status_desc = "Contact Acquirer";
							break;
						case 61:
							$status_desc = "Your bank has prevented your card from carrying out this transaction, please contact your bank";
							break;
						case 62:
							$status_desc = "Restricted Card";
							break;
						case 63:
							$status_desc = "Security Violation";
							break;
						case 64:
							$status_desc = "Original Account Incorrect";
							break;
						case 65:
							$status_desc = "Exceeds Withdrawal Frequency";
							break;
						case 66:
							$status_desc = "Call Acquirer Security";
							break;
						case 67:
							$status_desc = "Hard Capture";
							break;
						case 68:
							$status_desc = "Response Received Too Late";
							break;
						case 75:
							$status_desc = "PIN Tries Exceeded";
							break;
						case 77:
							$status_desc = "Intervene, Bank Approval Required";
							break;
						case 78:
							$status_desc = "Intervene, Bank Approval Required for Partial Amount";
							break;
						case 90:
							$status_desc = "Cut-off in Progress";
							break;
						case 91:
							$status_desc = "Issuer or Switch Inoperative";
							break;
						case 92:
							$status_desc = "Routing Error";
							break;
						case 93:
							$status_desc = "Violation of Law";
							break;				
						case 94:
							$status_desc = "Duplicate Transaction";
							break;
						case 95:
							$status_desc = "Reconcile Error";
							break;
						case 98:
							$status_desc = "Exceeds Cash Limit";
							break;
						case 'A0':
							$status_desc = "Unexpected Error";
							break;
						case 'A4':
							$status_desc = "Transaction Not Permitted to Card holder, Via Channel";
							break;
						case 'Z0':
							$status_desc = "Transaction Status Unconfirmed";
							break;
						case 'Z1':
							$status_desc = "Transaction Error";
							break;
						case 'Z2':
							$status_desc = "Bank Account Error";
							break;
						case 'Z3':
							$status_desc = "Bank Collection Account Error";
							break;
						case 'Z4':
							$status_desc = "Interface Integration Error";
							break;
						case 'Z5':
							$status_desc = "Duplicate Reference Error";
							break;
						case 'Z6':
							$status_desc = "Incomplete Transaction";
							break;
						case 'Z7':
							$status_desc = "Transaction Split Pre-processing Error";
							break;
						case 'Z8':
							$status_desc = "Invalid Card Number, Via Channels";
							break;
						case 'Z9':
							$status_desc = "Transaction not Permitted to Card Holder, Via Channel";
							break;
						case 'Z25':
							$status_desc = "This transaction does not exist on WebPay";
							break;
						case 'X00':
							$status_desc = "Account Error, Please Contact your Bank";
							break;
						case 'X03':
							$status_desc = "The amount requested is above the limit permitted by your bank, please contact your bank";
							break;
						case 'X04':
							$status_desc = "The amount requested is too low";
							break;
						case 'X05':
							$status_desc = "The amount requested is above the limit permitted by your bank, please contact your bank";
							break;
						case 'X10':
							$status_desc = "Secure 3D Authentication Failure";
							break;
						case 'XM0':
							$status_desc = "Missing Card Data Error";
							break;
						case 'XS1':
							$status_desc = "Payment Time Out";
							break;
						case 'X62':
							$status_desc = "Customer Cancellation 3D Secure";
							break;
						case 'X61':
							$status_desc = "Customer Cancellation ON OTP Page";
							break;            
						default:
							$status_desc = "Your Transaction was not Successful. No amount was debited from your account.";
							break;
						  }
             }
					
if($response_code == 00)
{			
        $status = 'PAID';	 
		echo '<div class="response-div grad">' .$status_desc. '<br/><br/> <i class="fa fa-spin fa-3x fa-spinner fa-fw"></i>...Please wait </div>';
		
		 //Call to success update function
		 $status = 'PAID';
		 update_successful_payment($paymentRef, $status, $response_code, $invoice);
		
//Call the email function here
payment_notification($user_name, $user_email, $user_phone, $session, $gateway_name, $status, $setup_name, $userId, $invoice, $merchant_name, $amount, $paymentRef);	
		
		//redirect to receipt page
		header("Refresh:5; url=../operations/core/transactionReceipt.php?invoice=".$invoice, true, 303);
}
else
{
		echo '<div class="response-div grad">' .$status_desc. '<br/><br/> OOPS! A problem occured while processing this payment. Please click on \'REPROCESS PAYMENT\' on the MENU to try again.';
		echo '<br/> <i class="fa fa-spin fa-3x fa-spinner fa-fw"></i>...Redirecting back to home page. ';
		header("Refresh:5; url=".$_SERVER['HTTP_HOST'], true, 303);
		echo '</div>';
		
		//Update response code
		 update_response_code($response_code, $invoice);
}



 
 echo '</body></html>';
	 ?>
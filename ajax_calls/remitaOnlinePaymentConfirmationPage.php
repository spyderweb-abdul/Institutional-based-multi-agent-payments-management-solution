<?php
 
 include_once('../config/constant_param/online_constant_verification_param.php');
 include_once('../config/connections/constant_connection.php');
 include_once '../config/constant_define/constants.php'; 
 include_once '../config/functions/control_functions.php';
  
echo '<html xmlns="http://www.w3.org/1999/xhtml">
      <head>
      <link rel="stylesheet" href="../plugins/custom_css/style.css" type="text/css" />
	  <link href="../plugins/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	  </head>
	  <body>';

$invoice= "";
if(isset($_POST['invoice'] )) 
{
$invoice = $_POST["invoice"];
}

//Database query
$details = get_payer_merchant($invoice);

//assign variables
$userId = $details['userId'];
$user_name = $details['user_name'];
$user_phone = $details['user_phone'];
$user_email = $details['user_email'];
$amount = $details['amount'];
$gateway_name = $details['gateway_name'];
$setup_name = $details['setup_name'];
$session = $details['session'];
$merchant_name = $details['merchant_name'];
$merchant_gateway_id = $details['merchant_gateway_id'];//Gateway ID provided by Remita
$merchant_apikey = $details['merchant_apikey']; //API key provided by Remita


$response_code ="";
$rrr = "";
$response_message = "";
//Verify Transaction
function transDetails($orderId)
{
	global $merchant_gateway_id;
	global $merchant_apikey;

		$mert =  $merchant_gateway_id;
		$api_key =  $merchant_apikey;
		$concatString = $orderId . $api_key . $mert;
		$hash = hash('sha512', $concatString);
		$url 	= CHECKSTATUSURL . '/' . $mert  . '/' . $orderId . '/' . $hash . '/' . 'orderstatus.reg';
		//  Initiate curl 
		$phpCurl = curl_init();
		// Disable SSL verification
		curl_setopt($phpCurl, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($phpCurl, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($phpCurl, CURLOPT_URL,$url);
		// Execute
		$result = curl_exec($phpCurl);
		// Closing
		curl_close($phpCurl);
		
		$response = json_decode($result, true);
		return $response;
}
	if($invoice != null)
	{
		$response = transDetails($invoice);
		$response_code = $response['status'];
		 
		if (isset($response['RRR']))
			{
			$rrr = $response['RRR'];
			}
		$response_message = $response['message'];
     }


		if($response_code == '01' || $response_code == '00') 
		{ 
		 echo '<div class="response-div grad"> Transaction was successful. <br/><br/> <i class="fa fa-spin fa-3x fa-spinner fa-fw"></i>...Please wait </div>';
         
		 //Call to success update function
		 $status = 'PAID';
		 update_successful_payment($rrr, $status, $response_code, $invoice);
			
//Call the email function here
payment_notification($user_name, $user_email, $user_phone, $session, $gateway_name, $status, $setup_name, $userId, $invoice, $merchant_name, $amount, $rrr);	

		
		//redirect to receipt page
		header("Refresh:5; url=../operations/core/transactionReceipt.php?invoice=".$invoice, true, 303);
	     }

		else if($response_code == '021') 
		{ 		
			echo '<div class="response-div grad">RRR Generated Successfully <br/>';
			echo 'Remita Retrieval Reference:  '.$rrr. '</div>';
			
			//Update response code
			update_response_code($response_code, $invoice);
			
		}	
		else
		{ 		
			echo '<div class="response-div grad"> Your Transaction was not Successful<br/>';
		
			if ($rrr != null)
			{ 
				echo '<p> Your Remita Retrieval Reference (RRR) is: <span>'.$rrr. '</span> </p>';
			} 
			
			echo 'Reason: '.$response_message;
			
			if($response_code != NULL)
			{
			//Update response code
			update_response_code($response_code, $invoice);
			}
			
			echo '<br/> Click <a href="'.$_SERVER['SERVER_NAME'].'"> HERE </a> to go back to home page. </div>';
        }
//Email function here
 echo '</body></html>';
 
	 ?>
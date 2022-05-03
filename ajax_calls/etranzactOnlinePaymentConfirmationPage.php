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

	    $success = $_POST['SUCCESS'];
        $etztransids = $_POST['TRANSACTION_REF'];//TRANSACTION_ID
		$invoice = $_POST['TRANSACTION_ID'];
		$terminal_id = $_POST['TERMINAL_ID'];
		$response_urls = $_POST['RESPONSE_URL'];
        $final_checksums = $_POST['FINAL_CHECKSUM'];
        $new_checksums = $_POST['CHECKSUM'];
        $trans_nums = $_POST['TRANS_NUM'];
        $references = $_POST['DESCRIPTION'];
        $amount = $_POST['AMOUNT'];		
        $response_code = $_POST['SUCCESS'];	
		
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

			
$status_desc = "";	
$finalcheck = hash("sha256" , $new_checksums);			
if(isset($_POST['FINAL_CHECKSUM']) == $finalcheck){	}
else 
{
			echo '<p class="response-div grad"> Wrong FinalCheckSum <br/>';
			echo $finalcheck. '<br/>';
			echo $final_checksum .'</p>';
}

 		
		switch ($response_code) {
            case 0:
                $status_desc = "Transaction successful. Payment accepted";
                break;
            case -1:
                $status_desc = "Transaction timeout or invalid parameters or unsuccessful transaction in the case of Query History";
                break;
            case 1:
                $status_desc = "Destination Card Not Found";
                break;
            case 2:
                $status_desc = "Card Number Not Found";
                break;
            case 3:
                $status_desc = "Invalid Card PIN";
                break;
            case 4:
                $status_desc = "Card Expiration Incorrect";
                break;
            case 5:
                $status_desc = "Insufficient balance";
                break;
            case 6:
                $status_desc = "Spending Limit Exceeded";
                break;
            case 7:
                $status_desc = "Internal System Error Occurred, please contact the service provider";
                break;
            case 8:
                $status_desc = "Financial Institution cannot authorize transaction, Please try later";
                break;
            case 9:
                $status_desc = "PIN tries Exceeded";
                break;
            case 10:
                $status_desc = "Card has been locked";
                break;
            case 11:
                $status_desc = "Invalid Terminal Id";
                break;
            case 12:
                $status_desc = "Payment Timeout";
                break;
            case 13:
                $status_desc = "Destination card has been locked";
                break;
            case 14:
                $status_desc = "Card has expired";
                break;
            case 15:
                $status_desc = "PIN change required";
                break;
            case 16:
                $status_desc = "Invalid Amount";
                break;
            case 17:
                $status_desc = "Card has been disabled";
                break;
            case 18:
                $status_desc = "Unable to credit this account immediately, credit will be done later";
                break;
            case 19:
                $status_desc = "Transaction not permitted on terminal";
                break;
            case 20:
                $status_desc = "Exceeds withdrawal frequency";
                break;
            case 21:
                $status_desc = "Destination Card has expired";
                break;
            case 22:
                $status_desc = "Destination Card Disabled";
                break;
            case 23:
                $status_desc = "Source Card Disabled";
                break;
            case 24:
                $status_desc = "Invalid Bank Account";
                break;
            case 25:
                $status_desc = "Insufficient Balance";
                break;
            case 26:
                $status_desc = "CHECKSUM/FINAL_CHECKSUM error";
                break;
            case "CA":
                $status_desc = "You Have Cancelled This Transaction";
                break;
            case 100:
                $status_desc = "Duplicate Session Id";
                break;
            case 200:
                $status_desc = "Invalid Client Id";
                break;
            case 300:
                $status_desc = "Invalid Mac";
                break;
            case 400:
                $status_desc = "Expired Session";
                break;
            case 500:
                $status_desc = "You have entered an account number that is not tied with your phone number with the bank. Please contact your bank for assistance";
                break;
            case 600:
                $status_desc = "Invalid Account Id";
                break;
            case 700:
                $status_desc = "Security Violation Please contact support@etranzact.com";
                break;
            case 800:
                $status_desc = "Invalid esa code";
                break;
            case 900:
                $status_desc = "Transaction Limit Exceeded";
                break;
            default:
                $status_desc = "Your Transaction was not Successful. No amount was debited from your account.";
                break;
              }
					
if($success == 0)
{			
        $status = 'PAID';	 
		echo '<div class="response-div grad">' .$status_desc. '<br/><br/> <i class="fa fa-spin fa-3x fa-spinner fa-fw"></i>...Please wait </div>';
		
		 //Call to success update function
		 $status = 'PAID';
		 update_successful_payment($rrr, $status, $response_code, $invoice);
		
//Call the email function here
payment_notification($user_name, $user_email, $user_phone, $session, $gateway_name, $status, $setup_name, $userId, $invoice, $merchant_name, $amount, $etztransids);	
		
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
<?php
 
 include_once('../config/constant_param/online_constant_verification_param.php');
 include_once('../config/connections/constant_connection.php');
 include_once '../config/constant_define/constants.php';


$invoice= "";
if(isset($_POST['invoice'] )) 
{
$invoice = $_POST["invoice"];
}

//Database query
$sel_details = $paydb->query("SELECT * FROM ".PAYMENT_RECORDS." a 
							  INNER JOIN ".USERS." b ON b.userId = a.userId 
							  INNER JOIN ".MERCHANTS." c ON c.merchantId = a.merchantId
							  WHERE a.invoice = '$invoice' ");
							  
$details = $sel_details->fetch_array();

//assign variables
$user_name = $details['user_name'];
$user_phone = $details['user_phone'];
$amount = $details['amount'];
$gateway_name = $details['gateway_name'];
$setup_name = $details['setup_name'];
$session = $details['session'];
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
	if($invoie != null)
	{
		$response = transDetails($invoice);
		$response_code = $response['status'];
		 
		if (isset($response['RRR']))
			{
			$rrr = $response['RRR'];
			}
		$response_message = $response['message'];
     }

echo '<div style="text-align: center;">';
		if($response_code == '01' || $response_code == '00') 
		{ 
		echo '<div class="alert alert-success">Payment Verified OK - <a href="transactionReceipt.php?invoice='.$invoice.'"> Click to print payment receipt 		              </a> </div>';

$update_payment = $paydb->query("UPDATE ".PAYMENT_RECORDS." 
                                 SET transactionId = '$rrr', status = 'PAID', dateTime = NOW(), verified = 'OK' 
								 WHERE invoice = '$invoice'" );
	      }

		else if($response_code == '021') 
		{ 		
	    echo '<div class="alert alert-success">RRR Generated Successfully</div>';
		echo '<p><b>Remita Retrieval Reference: </b> '.$rrr. '<p>';
		}	
		else
		{ 		
		echo '<div class="alert alert-danger">Your Transaction was not Successful</div>';
		
		if ($rrr != null)
		{ 
		echo '<p class="styleTb">Your Remita Retrieval Reference (RRR) is: <span>'.$rrr. '</span><br />';
		} 
		
		echo 'Reason: </b> '.$response_message.' <p>';
	 }
echo '</div>';


function payment_notification($user_name, $user_email, $user_phone, $session, $gateway_name, $status)
{
 //Mailer Script
		
                require_once("../PhpMailer/PHPMailerAutoload.php");

                 $message = file_get_contents('../include/html_notification_pg_payment.php'); 
                 $message = str_replace('%app_no%', $app_no, $message);  //replaces the string in the html page with the correct variable
                 $message = str_replace('%password%', $password, $message);
				 $message = str_replace('%email%', $email, $message);
		         $message = str_replace('%name%', $name, $message);
                 $message = str_replace('%prog%', $prog, $message);
                 $message = str_replace('%session%', $session, $message);
                 $message = str_replace('%channel%', $channel, $message);
				 $message = str_replace('%payment_status%', $payment_status, $message);
				 
				 
                 $mail = new PHPMailer();

                //Enable SMTP debugging. 
               $mail->SMTPDebug = 0; 

               $mail->IsSMTP();    // set mailer to use SMTP
               $mail->Host = "smtp-relay.gmail.com";  // specify main and backup server
               $mail->SMTPAuth = true;     // turn on SMTP authentication
               $mail->Username = "pgs.notification@udusok.edu.ng";  // SMTP username
               $mail->Password = "Admin@udu123"; // SMTP password
                //If SMTP requires TLS encryption then set it
               $mail->SMTPSecure = "tls";                           
               //Set TCP port to connect to 
               $mail->Port = 587;     

               $mail->From = "pgs.notification@udusok.edu.ng";
               $mail->FromName = "UDUS POSTGRADUATE SCHOOL";
               $mail->AddAddress($email, $name);
               $mail->AddReplyTo("no-reply@udusok.edu.ng", "No-Reply");

                //$mail->addCC("user.3@ymail.com","User 3");
                //$mail->addBCC("user.4@in.com","User 4");

                //$mail->WordWrap = 50;                                 // set word wrap to 50 characters
                //$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
               // $mail->AddAttachment("PGMANUAL.pdf", "Application-Form-User-Guide");    // optional name
				
				$mail->IsHTML(true);                                  // set email format to HTML

                $mail->CharSet="utf-8";
                $mail->Subject = "SUCCESSFUL PAYMENT NOTIFICATION";
                $mail->Body = $message;
                 //$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

                if(!$mail->Send())
                  {
                echo "Message could not be sent. <p>";
                echo "Mailer Error: " . $mail->ErrorInfo;
                exit;
                  }

           //echo "Message has been sent";
		   
		   
              //SMS API starts here		   
		   
           $owneremail="mitsafe@yahoo.com";
           $subacct="PGPORTAL";
           $subacctpwd="pgportal";
           $sendto= $phone;     /* destination number */
           $sender="UDUSPG"; /* sender id */
           $msg="Form payment received. APP.NO: ".$app_no." PASSWORD: ".$password." Kindly logon to proceed."; /* message to be sent */

        	 
					 
 $url="http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=".$owneremail."&subacct=".$subacct."&subacctpwd=".$subacctpwd."&message=".urlencode($msg)."&sender=".urlencode($sender)."&sendto=".urlencode($phone)."&msgtype=0";	
 @fopen($url, "r");	 
				
                //SMA API ends here
 }
 
	 ?>
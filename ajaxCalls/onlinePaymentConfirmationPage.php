<?php
 
 include_once('../include/online_constant_verification_param.php');
 include_once('../include/constant_connection.php');

$orderID = "";
if(isset($_POST['orderID'] )) 
{
$orderID = $_POST["orderID"];
}
$response_code ="";
$rrr = "";
$response_message = "";
//Verify Transaction
function transDetails($orderId)
{
		$mert =  MERCHANTID;
		$api_key =  APIKEY;
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
	if($orderID != null)
	{
		$response = transDetails($orderID);
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
		echo '<div class="alert alert-success">Payment Verified OK - <a href="transactionReceipt.php?orderID='.$orderID.'"> Click to print payment receipt </a> </div>';
		//echo '<p><b>Remita Retrieval Reference: </b> '.$rrr. '<p>';
		
		     $mySubstr = substr($orderID, 0, 2);
			 $phone = '';
			 
					    
   if($mySubstr == '00')// For UG Registration fee
   {
	   $sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Online Payment', gateway = 'Remita', dateTime = NOW() WHERE orderID = '$orderID'");

	   $sql = $edudb->query("UPDATE ".TBL_FEES_ORDER." SET rrr = '$rrr', payment_status = 'PAID', channel = 'Online Payment', dateTime = NOW() WHERE trans_id = '$orderID' ");
	   $fetch = $edudb->query(" SELECT * FROM ".TBL_FEES_ORDER." WHERE trans_id = '$orderID'");	 
	                           $mt = $fetch->fetch_array();	
	   
	                           $name = strtoupper($mt['fullName']);
							   $phone = $mt['phone'];
							   $descr = $mt['descr'];
							  // $email = $mt['email'];
	  
    }
 
  elseif($mySubstr == '01')// For Matriculations Tuition Payment
  {
	   	$sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Online Payment', gateway = 'Remita', dateTime = NOW(), verify = 'OK' WHERE orderID = '$orderID'");

	   $sql = $matdb->query("UPDATE ".TBL_PAYMENTS." SET rrr = '$rrr', payment_status = 'PAID' WHERE invoiceno = '$orderID'");
	  
  }
  elseif($mySubstr == '02')// For Matriculations Hostel Fee
  {
	   	$sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Online Payment', gateway = 'Remita', dateTime = NOW(), verify = 'OK' WHERE orderID = '$orderID'");

		$sql = $matdb->query("UPDATE ".TBL_HOSTEL_PAYMENTS." SET rrr = '$rrr', payment_status = 'PAID' WHERE invoiceno = '$orderID'");
	  
  }
  elseif($mySubstr == '29')// For Matriculations Application Form
  {		
		//First, MD5 the orderID because it's going to serve as the USer password 
		
		$myCrypt = md5($orderID);
			
		//INSERT the new value into matric_form_payment
	    $sql = $matdb->query("INSERT INTO ".TBL_MATRIC_FORM_PAYMENTS." (orderID, authorizedBy) VALUES ('$myCrypt', 'Bank Payment')");
		
		//Fetch the Application ID
		$fetch = $matdb->query("SELECT CONCAT(attache, id) AS appno FROM ".TBL_MATRIC_FORM_PAYMENTS." WHERE orderID = '$myCrypt'");
		$ft = $fetch->fetch_array();
		
		$appno = $ft['appno'];		
		
	   	$sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET userId = '$appno', transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Payment', gateway = 'Remita', dateTime = NOW(), verify = 'OK' WHERE orderID = '$orderID'");

    	
	  
  }
    elseif($mySubstr == '03')// For PG Tuition Fee
   {
	   $sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Online Payment', gateway = 'Remita', dateTime = NOW(), verify = 'OK' WHERE orderID = '$orderID'");

$sql = $pgdb->query("UPDATE fees_order SET rrr = '$rrr', payment_status = 'PAID', channel = 'Online Payment', dateTime = NOW() WHERE trans_id = '$orderID'");
	   $sql2 = $pgdb->query("UPDATE fees_summary SET payment_status = 'PAID', esa_code = '$rrr' WHERE trans_id = '$orderID'");
	  
    }
	
	elseif($mySubstr == '30')// For Postgraduate Application Form
    {
		
		//INSERT the new value into pg_form_payment
	    $sql = $pgdb->query("INSERT INTO ".TBL_FORM_PAYMENT." (orderID, authorizedBy) VALUES ($orderID, 'Bank Payment') ");
				
		//Fetch the Application ID
		$fetch = $pgdb->query("SELECT CONCAT(attache, id) AS appno FROM ".TBL_FORM_PAYMENT." WHERE orderID = '$orderID' ");
		$ft = $fetch->fetch_array();
		
		$app_no = $ft['appno'];		
			
		//Update the necessary fields on PG Portal if payment was made successfully
		
$upd = $pgdb->query("UPDATE ".TBL_ACCOUNT." SET app_no = '$app_no', payment_status = 'PAID', channel = 'REMITA', dateTime = NOW() WHERE trans_id = '$orderID' ");
		
		//Extract user details from account_table for sms and email notifications

$extract = $pgdb->query("SELECT sName, fName, oName, prog, app_no, password, email, phone, session, channel, payment_status FROM ".TBL_ACCOUNT." WHERE trans_id = '$orderID'");
$ext = $extract->fetch_array();
		
		if($ext == TRUE)
		{
		
		$name  = $ext['sName'].' '.$ext['fName'].' '.$ext['oName'];
		$prog = $ext['prog'];
		$app_no = $ext['app_no'];
		$password = $ext['password'];
		$email = $ext['email'];
		$phone = $ext['phone'];
		$session = $ext['session'];
		$channel = $ext['channel'];
		$payment_status = $ext['payment_status'];
		
		//Call to a function
		payment_notification($name, $prog, $app_no, $password, $email, $phone, $session, $channel, $payment_status);
		}

		//Equally, update all necessary field on payment portal.
				
$upd2 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET userId = '$app_no', transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Payment', gateway = 'Remita', dateTime = NOW(), verify = 'OK' WHERE orderID = '$orderID'");
  
  }
	elseif($mySubstr == '35')// For Sasakawa Application Form
  {		
		//First, MD5 the orderID because it's going to serve as the USer password 
		
		$myCrypt = md5($orderID);
			
		//INSERT the new value into sasakawa_form_payment
	 $sql = $matdb2->query("INSERT INTO ".TBL_SASAKAWA_FORM." (orderID, authorizedBy) VALUES ('$myCrypt', 'Bank Payment')");
		
	//Fetch the Application ID
	$fetch = $matdb2->query("SELECT CONCAT(attache, id) AS appno FROM ".TBL_SASAKAWA_FORM." WHERE orderID = '$myCrypt'");
    $ft = $fetch->fetch_array();
		
		$appno = $ft['appno'];		
		
$sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET userId = '$appno', transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Payment', gateway = 'Remita', dateTime = NOW(), verify = 'OK' WHERE orderID = '$orderID'");
	  
  }
	 elseif($mySubstr == '06')// For UG and PG Accommodation Fee
   {
	   $sql = $edudb->query("UPDATE ".TBL_HOSTEL_APP." SET appStatus = 'PAID' WHERE trans_id = '$orderID'");
	   
	   $sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Online Payment', gateway = 'Remita', dateTime = NOW() WHERE orderID = '$orderID'" );
 
	   $fetch = $paydb->query(" SELECT * FROM ".TBL_PAYMENTS_RECORD." WHERE transactionID = '$orderID'");	 
	   $mt = $fetch->fetch_array();	

	   
	                           $name = strtoupper($mt['payerName']);
	                           $phone = $mt['payerPhone'];
	                           $descr = $mt['description'];
							  // $email = $mt['email'];
	  
    }
	//If Order ID is for Change of Course Fee, UG Deferment, Transcript, ID card replacement, PG deferment, BSc Accounting (PT)
 	elseif($mySubstr == '04' || $mySubstr == '05' || $mySubstr == '07' || $mySubstr == '08' || $mySubstr == '09' || $mySubstr == '10' 
	       || $mySubstr == '11' || $mySubstr == '12' || $mySubstr == '13' || $mySubstr == '14' || $mySubstr == '15' || $mySubstr == '16' 
		   || $mySubstr == '17' || $mySubstr == '18' || $mySubstr == '19' || $mySubstr == '20' || $mySubstr == '21' || $mySubstr == '22'
		   || $mySubstr == '23' || $mySubstr == '24' || $mySubstr == '25' || $mySubstr == '26' || $mySubstr == '27' || $mySubstr == '28'
		   || $mySubstr == '31' || $mySubstr == '33' || $mySubstr == '34'
		   ) 
	{

$sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Online Payment', gateway = 'Remita', dateTime = NOW(), verify = 'OK' WHERE orderID = '$orderID'" );

	}
	
		 
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


function payment_notification($name, $prog, $app_no, $password, $email, $phone, $session, $channel, $payment_status)
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
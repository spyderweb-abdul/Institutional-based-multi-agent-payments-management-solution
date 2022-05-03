<?php

function trim_input($data)
{
  global $paydb;

	$data = trim($data);
	$data = addslashes($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($paydb, $data);
	return $data;
}

function assign_invoice($value, $gatewayId)
{
    global $paydb; //Declare the db connect variable as global

    //Connect to fetch the payment code
    $get_code = $paydb->query("SELECT payment_code, gatewayId FROM ".SETUP." WHERE setup_name = '$value' AND gatewayId = '$gatewayId' ") or die (mysqli_error($paydb));
    $paycode = $get_code->fetch_array();

    if(mysqli_num_rows($get_code) > 0)
    {
    $currentYear = date('Y');//Get the current year
    $chunkYear = substr($currentYear, 2); //Chunk current year to get the last 2 digits
    $random = rand(300, 20000).rand(20000, 99000); //Intialize a random number
    	
    $invoice = $value.' - '.$paycode[0].$paycode[1].$chunkYear.$random; //Concatenate all variables and assign to invoice. Invoice no. is in the format: payment_code.gatewayId.first two digits of the paying year.random number. 
    }
    else //If no setup, do;
    {
    $invoice = 'SETUP NOT PROVISIONED';
    }

    return $invoice; //return invoice value
}


function get_active_merchant($active)
{
  	global $paydb; //Declare the db connect variable as global
  	
  	//Get the status of the payment gateways for specific merchants
  	$get_list = $paydb->query("SELECT a.merchantId, a.gatewayId, b.gateway_name, a.status FROM ".ACTIVE_CHANNEL." a
  	                           INNER JOIN ".CHANNEL." b ON b.gatewayId = a.gatewayId
  							   WHERE a.merchantId = '$active'");
  	while($active_list = $get_list->fetch_array())
  	{
  		$active_channel[] = $active_list; //Push list of gateways into a array

  	}
  	return $active_channel; //Return the array value
  	
}

//This function gets the fee amount for a particular setup_name
function get_fee_amount($value)
{
  	global $paydb; 
  	$get_fee = $paydb->query("SELECT * FROM ".SETUP." a INNER JOIN ".FEES." b ON b.setupId = a.setupId WHERE setup_name = '$value'");
  	
  	if(mysqli_num_rows($get_fee)> 0)
  	{
  		$fee = $get_fee->fetch_array();
  		
  		$fee_amount = $fee['fee_amount'];
  	}
  	else
  	{
  		$fee_amount = 0;
  	}
  	
  	return $fee_amount;
  }

//Function to strip description to get only the digits in the value
function strip_invoice($desc)
{
	$getInv = str_ireplace("-", "", $desc);
	$numbers = preg_replace('/[^0-9]/', '', $desc);
  $letters = preg_replace('/[^a-zA-Z]/', '', $desc);
	
	return $numbers;
}

//This function should get some very key details about a payer
function get_user_data($user, $merch)
{
	global $paydb; //Declare the db connect variable as global
	
	//Get the status of the payment gateways for specific merchants
	$get_user = $paydb->query("SELECT * FROM ".USERS." a 
	                           INNER JOIN ".PAYMENT_RECORDS." b ON b.userId = a.userId
							   INNER JOIN ".MERCHANTS." c ON c.merchantId = b.merchantId
							   INNER JOIN ".MERCHANT_TYPE." d ON d.merchantTypeId = c.merchantTypeId
							   WHERE a.userId = '$user' AND c.merchantId = '$merch' ");
    $usr = $get_user->fetch_array();
    return $usr; 
	
}

//Function to get some payer details with merchant params
function get_payer_merchant($order)
{
	global $paydb;
	$sel = $paydb->query("SELECT * FROM ".PAYMENT_RECORDS." a 
								   INNER JOIN ".USERS." b ON b.userId = a.userId
								   INNER JOIN ".MERCHANTS." c ON c.merchantId = b.merchantId
								   INNER JOIN ".SETUP." d ON d.setupId = a.setupId
                   INNER JOIN ".CHANNEL." e ON e.gatewayId = a.gatewayId
                   INNER JOIN ".MERCHANT_PROFILE." f ON f.merchantId = a.merchantId
                   INNER JOIN ".PAY_OPTIONS." g ON g.optionId = a.optionId
								   WHERE a.invoice = '$order' ");
    $sel_param = $sel->fetch_array();
	  return $sel_param;
}



//Function to send email on invoice generation notification
function invoice_notification($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n)
{

      function throw_ex($err)
      {
        throw new Exception($err);
        
      }

try
{
         $pdf_url_string = file_get_contents("http://".$_SERVER['HTTP_HOST']."/pay2/invoice_pdf.php?userId=".rawurlencode($h)."&optionId=".rawurlencode($l)."&setupId=".rawurlencode($m)."&merchantId=".rawurlencode($n)."&invoice=".rawurlencode($i)); //PDF Invoice Page extract

            if($pdf_url_string === false)
            {
              throw_ex("Error: Could not fetch content from: ".$pdf_url_string);
              
            }

                $mail_content = file_get_contents('../config/includes/html_notification_paytonify_invoice.php'); 

                 if($mail_content === false){
                    
                    throw_ex("Error: Mail Content cannot be extracted");

                 }

                //Mailer Script
		
                require_once("../../PhpMailer/PHPMailerAutoload.php");

                 $message = $mail_content;
                 $message = str_replace('%userId%', $h, $message);  //replaces the string in the html page with the correct variable
                 $message = str_replace('%payer_name%', $a, $message);
				         $message = str_replace('%payer_email%', $b, $message);
		             $message = str_replace('%payer_phone%', $c, $message);
                 $message = str_replace('%session%', $d, $message);
                 $message = str_replace('%gateway_name%', $e, $message);
                 $message = str_replace('%status%', $f, $message);
        				 $message = str_replace('%setup_name%', $g, $message);
        				 $message = str_replace('%invoice%', $i, $message);
        				 $message = str_replace('%merchant_name%', $j, $message);
        				 $message = str_replace('%amount%', $k, $message);
        				 
				 
                 $mail = new PHPMailer();

                //Enable SMTP debugging. 
               $mail->SMTPDebug = 0; 

               $mail->IsSMTP();    // set mailer to use SMTP
               $mail->Host = "smtp-relay.gmail.com";  // specify main and backup server
               $mail->SMTPAuth = true;     // turn on SMTP authentication

               $mail->Username = "somethin@xyz.com";  // SMTP username
               $mail->Password = "user_password"; // SMTP password

               //$mail->Username = "notification@xyz.com";  // SMTP username
               //$mail->Password = "smtp_password"; // SMTP password
                //If SMTP requires TLS encryption then set it
               $mail->SMTPSecure = "tls";                           
               //Set TCP port to connect to 
               $mail->Port = 587;

               $mail->From = "notification@xyz.com";

               //$mail->From = "notification@xyz.com";
               //$mail->From = "Sender_Name";
               $mail->AddAddress($b, $a);
               $mail->AddReplyTo("no-reply@xyz.com", "No-Reply");

                //$mail->addCC("user.3@ymail.com","User 3");
                //$mail->addBCC("user.4@in.com","User 4");

                //$mail->WordWrap = 50;                                 // set word wrap to 50 characters
                //$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
               // $mail->AddAttachment("MANUAL.pdf", "Application-Form-User-Guide");    // optional name

               $mail->AddStringAttachment($pdf_url_string, 'payment_local_invoice.pdf', $encoding = 'base64', $type = 'application/pdf');
				
				        $mail->IsHTML(true);                                  // set email format to HTML

                $mail->CharSet="utf-8";
                $mail->Subject = $g." - ".$i." - PAYMENT INVOICE NOTIFICATION";
                $mail->Body = $message;
                 //$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

                if(!$mail->Send())
                  {
                    throw_ex("Message could not be sent. <br/>");
                    throw_ex("Mailer Error: " . $mail->ErrorInfo);
               // exit;
                  }

           //echo "Message has been sent";
        }
        
  catch(Exception $e)
    {
       echo $e;
    }
 }
 
//Function for successful payment
 function payment_notification($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l)
{
 //Mailer Script
		
                require_once("../../PhpMailer/PHPMailerAutoload.php");

                 $message = file_get_contents('../config/includes/html_notification_paytonify_payment.php'); 
                 $message = str_replace('%userId%', $h, $message);  //replaces the string in the html page with the correct variable
                 $message = str_replace('%payer_name%', $a, $message);
				         $message = str_replace('%payer_email%', $b, $message);
		             $message = str_replace('%payer_phone%', $c, $message);
                 $message = str_replace('%session%', $d, $message);
                 $message = str_replace('%gateway_name%', $e, $message);
                 $message = str_replace('%status%', $f, $message);
        				 $message = str_replace('%setup_name%', $g, $message);
        				 $message = str_replace('%invoice%', $i, $message);
        				 $message = str_replace('%merchant_name%', $j, $message);
        				 $message = str_replace('%amount%', $k, $message);
        				 $message = str_replace('%transactionId%', $l, $message);
        				 
				 
				 
                 $mail = new PHPMailer();

                //Enable SMTP debugging. 
               $mail->SMTPDebug = 0; 

               $mail->IsSMTP();    // set mailer to use SMTP
               $mail->Host = "smtp-relay.gmail.com";  // specify main and backup server
               $mail->SMTPAuth = true;     // turn on SMTP authentication
               $mail->Username = "notification@xyz.com";  // SMTP username
               $mail->Password = "smtp_password"; // SMTP password
                //If SMTP requires TLS encryption then set it
               $mail->SMTPSecure = "tls";                           
               //Set TCP port to connect to 
               $mail->Port = 587;     

               $mail->From = "notification@xyz.com";
               $mail->FromName = "Sender_Name";
               $mail->AddAddress($b, $a);
               $mail->AddReplyTo("no-reply@paytonify.com", "No-Reply");

                //$mail->addCC("user.3@ymail.com","User 3");
                //$mail->addBCC("user.4@in.com","User 4");

                //$mail->WordWrap = 50;                                 // set word wrap to 50 characters
                //$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
               // $mail->AddAttachment("MANUAL.pdf", "Application-Form-User-Guide");    // optional name
				
				         $mail->IsHTML(true);                                  // set email format to HTML

                $mail->CharSet="utf-8";
                $mail->Subject = $g." - ".$i." - SUCCESSFUL PAYMENT NOTIFICATION";
                $mail->Body = $message;
                 //$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

                if(!$mail->Send())
                  {
                echo "Message could not be sent. <p>";
                echo "Mailer Error: " . $mail->ErrorInfo;
               // exit;
                  }

           //echo "Message has been sent";
 }
 
//Function that updates successful payment
function update_successful_payment($trans_code, $status, $response_code, $invoice)
{
global $paydb;
//Update the payer's record in the database
$update_payment = $paydb->query("UPDATE ".PAYMENT_RECORDS." SET transactionId = '$trans_code', status = '$status', dateTime = NOW(), verified =         				                                 '$response_code' WHERE invoice = '$invoice'" );
}

//function to update response codes from failed transaction
function update_response_code($res, $inv)
{
	global $paydb;
	$upd_response = $paydb->query("UPDATE ".PAYMENT_RECORDS." SET verified = '$res' WHERE invoice = '$inv'" );
	
}
?>

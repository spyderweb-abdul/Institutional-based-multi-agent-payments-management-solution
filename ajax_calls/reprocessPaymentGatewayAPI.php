<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/constant_param/constant_verification_param.php';
include_once '../config/functions/control_functions.php';

include_once '../plugins/phpqrcode/qrlib.php';


$invoice = "";
if(isset($_POST['invoice']))
{
  $invoice = $_POST['invoice'];
}

//$userId = trim_input($_POST['userId']);
//$setupId = trim_input($_POST['setupId']);
//$session = trim_input($_POST['session']);
$gateway_name = trim_input($_POST['gateway']);

//Database query
$details = get_payer_merchant($invoice);

$userId = $details['userId'];
$user_name = $details['user_name'];
$user_email = $details['user_email'];
$user_phone = $details['user_phone'];
$amount = $details['amount'];
$status = $details['status'];
$setup_name = $details['setup_name'];
$merchant_name = $details['merchant_name'];
$session = $details['session'];
$setupId = $details['setupId'];
$merchantId = $details['merchantId'];
$optionId = $details['optionId'];
$option_name = $details['option_name'];
$gatewayId = $details['gatewayId'];


$logo = $details['logo'];
$dir = "logos/";
$logo = $dir.$logo;

$logo_url = $_SERVER['HTTP_REFERER'].$logo;

$merchant_gateway_id = $details['merchant_gateway_id'];//Gateway ID provided by Remita
$merchant_apikey = $details['merchant_apikey']; //API key provided by Remita

if($gateway_name == 'Remita')
{
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
		}//End Function
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


		 if($response_code == '021') 
		   { 		
				echo '<div class="alert alert-success"> <h5> RRR Generated Successfully <br/>';
				echo '<b>Your Remita Retrieval Reference (RRR) is: </b> '.$rrr. '</h5> </div>';
?>
            <p> <u><h6> <strong>STEPS TO RETRIEVE YOUR TRANSACTION INVOICE</strong> </h6> </u> </p>
          
                <h6>
                    <p> <i class="fa fa-angle-double-right"></i> Kindly visit <a href="http://remita.net" target="_blank"> http://remita.net </a> </p>
                    <p> <i class="fa fa-angle-double-right"></i>  Locate and click on the image below </p>
                    <p> <img src="../images/img_remita.png" width="152" height="107" class="img-thumbnail" title="PAY AN INVOICE" alt="PAY AN INVOICE" /></p>
                    <p> <i class="fa fa-angle-double-right"></i>  Insert your RRR in the displayed field </p>
                    <p> <i class="fa fa-angle-double-right"></i>  Click on 'Continue' to re-generate your invoice </p>
               </h6>
            
          
<?php   } else { ?>
            <div class="alert alert-danger"> <h5> <strong><i class="fa 2x fa-warning"> </i> RRR CANNOT BE FOUND </strong> <br/> Reason(s): </h5>
				
				<p> <h6> <i class="fa fa-angle-double-right"></i> either payment has been made successfully for this invoice no or, </h6> </p>
				<p> <h6> <i class="fa fa-angle-double-right"></i> there was no request for this order. Kindly re-process payment. </h6> </p>
								
		    </div>
<?php } ?>


<?php }//end remita condition

//Etranzact Integration
elseif($gateway_name == 'Etranzact')
{
	//Try to get a new invoice number
	$desc = assign_invoice($setup_name, $gatewayId);
	
	//Strip the description to get only numbers
	$new_invoice = strip_invoice($desc);
		
		echo '<div class="alert alert-success"><h5> <strong><i class="fa fa-2x fa-exclamation"> </i> Take Note: </strong><br/><br/>
			   Since your previous transaction process could not be concluded, we have had to change your Transaction Invoice Number. Kindly take note of the new one. 
			   </h5> </div><br/>';	

	 //Display information about the payment	
	 payers_detail_call($logo_url, $merchant_name, $setup_name, $session, $new_invoice, $gateway_name, $option_name, $setupId, $optionId, $merchantId, $userId, $user_name, $user_phone, $user_email, $amount);
	    //Payer Information display ends

       //Now update the new invoice in the database
	    $upd_invoice = $paydb->query("UPDATE ".PAYMENT_RECORDS." SET invoice = '$new_invoice' WHERE invoice = '$invoice'");

           echo '<br/><i class="fa fa-cog fa-3x fa-spin fa-fw"> </i> <h5> You will be redirected in few seconds... </h5>';
		   
		   
  //Call the email function here and send invoice notice
 invoice_notification($user_name, $user_email, $user_phone, $session, $gateway_name, $status, $setup_name, $userId, $new_invoice, $merchant_name, $amount, $optionId, $setupId, $merchantId);	

			//Delay execution for 20s
			//sleep(5);

		$success = "";
		define("TERMINALID", $merchant_gateway_id);//demo
		define("APIKEY", $merchant_apikey);//demo

		 // $terminalId = "0000000001";
         // $secret_key = "DEMO_KEY";
          $responseurl = PATH."/etranzactOnlinePaymentConfirmationPage.php";
          $str = $amount. TERMINALID. $invoice. $responseurl. APIKEY;
		  $checksum = hash("sha256", $str);

				if($success == NULL)
				{
					echo "<form id='process_pay_etranzact' name='process_pay_etranzact' method='POST' action='https://demo.etranzact.com/bankIT/'>";
					echo "<input type='hidden' name='TERMINAL_ID' value='".TERMINALID."'>";
					echo "<input type='hidden' name = 'TRANSACTION_ID' value='".$new_invoice."'>";
					echo "<input type='hidden' name = 'AMOUNT' value='".$amount."'>";
					echo "<input type='hidden' name = 'DESCRIPTION' value='".$setup_name."'>";
					echo "<input type='hidden' name = 'EMAIL' value='".$user_email."'>";
					echo "<input type='hidden' name = 'PHONE' value='".$user_phone."'>";
					echo "<input type='hidden' name = 'RESPONSE_URL' value='".$responseurl."'>";
					echo "<input type='hidden' name = 'CHECKSUM' value='".$checksum."'>"; 
					echo "<input type='hidden' name = 'LOGO_URL' value='".$logo_url."'>";
					echo "</form>";
					echo '<script type="text/javascript">document.getElementById("process_pay_etranzact").submit(); </script>';
				}
					else if($success == 0){	echo "Transaction Successfull"; }
					else {	echo "Error while requesting for transaction authorisation, Transaction ID no more valid "; }
			

}
//etranzact process ends

/*******GT Pay Integration *****************/
elseif($gateway_name == 'GTPay')
{
	//Try to get a new invoice number
	$desc = assign_invoice($setup_name, $gatewayId);
	
	//Strip the description to get only numbers
	$new_invoice = strip_invoice($desc);
		
		echo '<div class="alert alert-success"><h5> <strong><i class="fa fa-2x fa-exclamation"> </i> Take Note: </strong><br/><br/>
			   Since your previous transaction process failed, we have had to change your Transaction Invoice Number. Kindly take note of the new one. 
			   </h5> </div><br/>';	
	
	        //Display information about the payment	
	     payers_detail_call($logo_url, $merchant_name, $setup_name, $session, $new_invoice, $gateway_name, $option_name, $setupId, $optionId, $merchantId, $userId, $user_name, $user_phone, $user_email, $amount);
	       //Payer Information display ends

           //Now update the new invoice in the database
	       $upd_invoice = $paydb->query("UPDATE ".PAYMENT_RECORDS." SET invoice = '$new_invoice' WHERE invoice = '$invoice'");

           echo '<br/><i class="fa fa-cog fa-3x fa-spin fa-fw"> </i> <h5> You will be redirected in few seconds... </h5>';		   
		   
		 
	//Call the email function here and send invoice notice
	invoice_notification($user_name, $user_email, $user_phone, $session, $gateway_name, $status, $setup_name, $userId, $new_invoice, $merchant_name, $amount, $optionId, $setupId, $merchantId);

			//Delay execution for 20s
			//sleep(5);	
	
define("CUSTOMERID", $merchant_gateway_id);//demo
define("APIKEY", $merchant_apikey);//demo

$hashkey = hash_hmac('sha1', CUSTOMERID, APIKEY);
$returnurl = PATH."/etranzactOnlinePaymentConfirmationPage.php";
$cancelurl = 'https://www.paytonify.com';
	
echo '<form method="post" name="process_pay_gtpay" id="process_pay_gtpay" action="http://www.gtpayment.com/gtmpayment.do">
		<input type="hidden" name="lang" value="en-US" />
		<input type="hidden" name="member" value="GTPay account" />
		<input type="hidden" name="productid" value="'.$new_invoice.'" /> 
		<input type="hidden" name="product" value="'.$setup_name.'" /> 
		<input type="hidden" name="price" value="'.$amount.'" />
		<input type="hidden" name="membercurrency" value="NGN" />
		<input type="hidden" name="ucancel" value="'.$cancelurl.'" />
		<input type="hidden" name="ureturn" value="'.$returnurl.'" />
		<input type="hidden" name="unotify" value="Notify URL" />
		<input type="hidden" name="api_exclude" value="alipay,paypal" />
		<input type="hidden" name=" trace_no" value="0123456789" />
		<input type="hidden" name="custom_email" value="'.$user_email.'" />
		<input type="hidden" name="secret_key" value="877e2cf7e71c4fcb04bbad17ae46556f50936ebc" />
		</form>
	    <script type="text/javascript">document.getElementById("process_pay_gtpay").submit();</script>';
	
}
//GTPay integration ends


//Interswitch integration here
if($gateway_name == 'Interswitch')
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


	echo '<div class="alert alert-success"><h5> <strong><i class="fa fa-2x fa-exclamation"> </i> Take Note: </strong><br/><br/>
			   Since your previous transaction process failed, we have had to change your Transaction Invoice Number. Kindly take note of the new one. 
			   </h5> </div><br/>';	
	
	//Display information about the payment	
	payers_detail_call($logo_url, $merchant_name, $setup_name, $session, $new_invoice, $gateway_name, $option_name, $setupId, $optionId, $merchantId, $userId, $user_name, $user_phone, $user_email, $amount);
	    //Payer Information display ends

   //Now update the new invoice in the database
	    $upd_invoice = $paydb->query("UPDATE ".PAYMENT_RECORDS." SET invoice = '$new_invoice' WHERE invoice = '$invoice'");

           echo '<br/><i class="fa fa-cog fa-3x fa-spin fa-fw"> </i> <h5> You will be redirected in few seconds... </h5>';
		   
		   
//Call the email function here and send invoice notice
invoice_notification($user_name, $user_email, $user_phone, $session, $gateway_name, $status, $setup_name, $userId, $new_invoice, $merchant_name, $amount, $optionId, $setupId, $merchantId);

			//Delay execution for 20s
			//sleep(5);
	
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
}
//Interswitch integration ends


function payers_detail_call($logo_url, $merchant_name, $setup_name, $session, $new_invoice, $gateway_name, $option_name, $setupId, $optionId, $merchantId, $userId, $user_name, $user_phone, $user_email, $amount){

	 echo '<div id="users-details">';
		echo '<div class="row">';
          
           echo '<div class="col-md-12 col-sm-12 col-xs-12">';

                        
              $charges = number_format(0, 2);
		      $total = number_format($amount + $charges, 2);

              echo '<span class="merchant-name-logo"> <img src="'.$logo_url.'" />'.$merchant_name.'<h6>'.$setup_name.' (Local Invoice) - '.$session.' </h6><span>';

               echo '<hr /></div>';

                echo '<div class="col-md-8 col-sm-8 col-xs-8"> <h4 style="color: #666; color: #264158;"> Invoice No: '.$new_invoice. '</h4> <br/>
                 <h6 style="color: #666; padding-right: 5px;"> Preferred Channel: '.$gateway_name. ' <i class="fa fa-angle-double-right"> </i> '.$option_name. '<br/>
                 <h6 style="color: #666; padding-right: 5px;">';

	              $uid = "'".$userId."'";

               echo ' <button class="btn btn-sm btn-link" target="_blank" style="text-decoration: none;" onclick="printerFriendly('.$uid.', '.$setupId.', '.$optionId.', '.$merchantId.', '.$new_invoice.')"> <i class="fa fa-print"> </i> [Print]  </button>';
            
               echo '</h6></div>';

               echo '<div class="col-md-4 col-sm-4 col-xs-4"> <p style="color: #999; padding: 7px; float:left;">Date Generated: '.date('Y-m-d').'</p>';

                  // here DB request or some processing 
				    $codeText = $new_invoice.' - '.$merchant_name.'/'.$merchantId.' - '.$setup_name.' - '.$total;    

				     
				    // outputs image directly into browser, as svg
				    QRcode::svg($codeText);

                echo '</div><br/>';
          

                echo '<div class="col-md-12 col-sm-12 col-xs-12"> <hr /> </div>';

				echo '<table width=90%" style="color: #333;" align="center">';
				echo '<tr ><th colspan="3" style="color: #333; padding: 8px;"> PAYER INFO: </th></tr>';
				echo '<tr> <td style="padding: 7px;"> <strong>Payer ID: </strong>  </td> <td> <strong>'.$userId. '</strong> </td> <td rowspan="4"> </td> </tr>'; 
				echo '<tr> <td style="padding: 7px;"> <strong>Name:  </strong> </td> <td> '.$user_name.' </td> </tr>';
				echo '<tr> <td style="padding: 7px;"> <strong>Phone No:  </strong> </td> <td> '.$user_phone.' </td> </tr>';
				echo '<tr> <td style="padding: 7px;"> <strong>Email:  </strong> </td> <td> '.$user_email.' </td> </tr>';


				echo '<tr> <td colspan="3" style="padding:15px; color:#666;">';  

				    echo '<table style="font-size: 12px; background-color: #f1f1f1; border-radius: 5px;" width="90%">';
					echo '<tr> <td style="padding: 5px;"> <strong>Amount Payable: </strong>  </td> <td>'.number_format($amount, 2). '</td> </tr>'; 
					echo '<tr> <td style="padding: 5px;"> <strong>Charges: </strong>  </td> <td>'.$charges. ' </td> </tr>'; 
					echo '<tr> <td style="padding: 5px;"> <strong>TOTAL: </strong>  </td> <td> <strong>'.$total. '</strong> </td> </tr>'; 
					echo '<table>';

			    echo '</td> </tr></table>';
		
}


?>

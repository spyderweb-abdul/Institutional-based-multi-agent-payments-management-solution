<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';

    include_once '../../../config/constant_param/constant_verification_param.php';
    include_once '../../../config/functions/control_functions.php';

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $invoice  = $postData->invoice;


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
$gatewayId = $details['gatewayId'];

$merchant_gateway_id = $details['merchant_gateway_id'];//Gateway ID provided by Remita
$merchant_apikey = $details['merchant_apikey']; //API key provided by Remita

$data = '';

if($gatewayId == 1)
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
                $url    = CHECKSTATUSURL . '/' . $mert  . '/' . $orderId . '/' . $hash . '/' . 'orderstatus.reg';
                //  Initiate curl 
                $phpCurl = curl_init();
                // Disable SSL verification
                curl_setopt($phpCurl, CURLOPT_SSL_VERIFYPEER, false);
                // Will return the response, if false it print the response
                curl_setopt($phpCurl, CURLOPT_RETURNTRANSFER, true);
                // Set the url
                curl_setopt($phpCurl, CURLOPT_URL, $url);
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

        if($response_code == '01' || $response_code == '00') 
        { 
          $data = 'Transaction was successful.';
         
             //Call to success update function
             $status = 'PAID';
             update_successful_payment($rrr, $status, $response_code, $invoice);
                
            //Call the email function here
            payment_notification($user_name, $user_email, $user_phone, $session, $gateway_name, $status, $setup_name, $userId, $invoice, $merchant_name, $amount, $rrr);    
                    
            //redirect to receipt page
            header("Refresh:5; url=".$_SERVER['HTTP_HOST']."/operations/core/transactionReceipt.php?invoice=".$invoice, true, 303);
         }

        else if($response_code == '021') 
        {       
            $data = 'RRR Generated Successfully.  Remita Retrieval Reference:  '.$rrr;
            
            //Update response code
            update_response_code($response_code, $invoice);
            
        }   
        else
        {       
            $data = 'Your Transaction was not Successful. ';
        
            if ($rrr != null)
            { 
                $data .= 'Your Remita Retrieval Reference (RRR) is: '.$rrr;
            } 
            
            $data .= ' Reason: '.$response_message;
            
            if($response_code != NULL)
            {
            //Update response code
            update_response_code($response_code, $invoice);
            }
        }


 }//end remita condition

//Etranzact Integration
elseif($gatewayId == 2)
{
    //https://www.etranzact.net/WebConnectPlus/query.jsp 

            
$status_desc = "";  
$finalcheck = hash("sha256" , $new_checksums);          
if(isset($_POST['FINAL_CHECKSUM']) == $finalcheck){ }
else 
{
            $data = 'Wrong Final CheckSum <br/>';
            $data .= $finalcheck. '<br/>';
            $data .= $final_checksum .'</p>';
}
if($success == 0)
{           
        $status = 'PAID';    
        $data = $status_desc;
        
         //Call to success update function
         $status = 'PAID';
         update_successful_payment($rrr, $status, $response_code, $invoice);
        
//Call the email function here
payment_notification($user_name, $user_email, $user_phone, $session, $gateway_name, $status, $setup_name, $userId, $invoice, $merchant_name, $amount, $etztransids);    
        
        //redirect to receipt page
        header("Refresh:5; url=".$_SERVER['HTTP_HOST']."/operations/core/transactionReceipt.php?invoice=".$invoice, true, 303);
}
else
{
        $data  = $status_desc. 'OOPS! A problem occured while processing this payment. Please click on \'REPROCESS PAYMENT\' on the MENU to try again.';
               
        //Update response code
         update_response_code($response_code, $invoice);
}


    
}
//etranzact process ends

/*******GT Pay Integration *****************/
elseif($gatewayId == 3)
{
    /*//Try to get a new invoice number
    $desc = assign_invoice($setup_name);
    
    //Strip the description to get only numbers
    $new_invoice = strip_invoice($desc);
        
        echo '<div class="alert alert-success"><h5> <strong><i class="fa fa-2x fa-exclamation"> </i> Take Note: </strong><br/><br/>
               Since your previous transaction process failed, we have had to change your Transaction Invoice Number. Kindly take note of the new one. 
               </h5> </div><br/>';  
    //Display information about the payment
    
        echo '<div id="users-details">';
        echo '<div class="row"><div class="col-md-12">';
        echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped payment-summary" width="100%">';
        echo '<tr ><th colspan=2> PAYMENT SUMMARY <i class="fa fa-angle-double-right"> </i> '.$merchant_name.' <i class="fa fa-angle-double-right"></i> '.              $setup_name.' </th></tr>';
        echo '<tr> <td> <strong> Payer ID</strong> </td> <td> <strong>'.$userId. '</strong> </td> </tr>'; 
        echo '<tr> <td> <strong> Payer\'s Details </strong> </td> <td> '.$user_name.' | '.$user_email.' | '.$user_phone.' </td> </tr>';
        echo '<tr> <td> <strong> Invoice No.</strong> </td> <td> <strong>'.$new_invoice. '</strong> </td> </tr>'; 
        echo '<tr> <td> <strong> Channel</strong> </td> <td> <strong>'.$gateway_name. ' </strong> </td> </tr>'; 
        echo '<tr> <td> <strong> Amount </strong> </td> <td> <strong> '. number_format($amount, 2). ' </strong> </td> </tr>';
        echo '<tr> <td> <strong> Status </strong> </td> <td> '.$status. ' </td> </tr>';
        echo '</table></div></div></div>';
    //Payer Information display ends

   //Now update the new invoice in the database
        $upd_invoice = $paydb->query("UPDATE ".PAYMENT_RECORDS." SET invoice = '$new_invoice' WHERE invoice = '$invoice'");

           echo '<br/><i class="fa fa-cog fa-3x fa-spin fa-fw"> </i> <h5> You will be redirected in few seconds... </h5>';
           
           
    //Call the email function here and send invoice notice
    invoice_notification($user_name, $user_email, $user_phone, $session, $gateway_name, $status, $setup_name, $userId, $new_invoice, $merchant_name, $amount);  
    
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

        */
    
}
//GTPay integration ends

elseif($gatewayId == 4)
{
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
        }
                        
        if($response_code == 00)
        {           
                $status = 'PAID';    
                $data = $status_desc;
                
                 //Call to success update function
                 $status = 'PAID';
                 update_successful_payment($paymentRef, $status, $response_code, $invoice);
                
        //Call the email function here
        payment_notification($user_name, $user_email, $user_phone, $session, $gateway_name, $status, $setup_name, $userId, $invoice, $merchant_name, $amount, $paymentRef); 
                
                //redirect to receipt page
                    header("Refresh:5; url=".$_SERVER['HTTP_HOST']."/operations/core/transactionReceipt.php?invoice=".$invoice, true, 303);
        }
        else
        {
               $data = $status_desc. 'OOPS! A problem occured while processing this payment. Please click on \'REPROCESS PAYMENT\' on the MENU to try again.';
                
                //Update response code
                 update_response_code($response_code, $invoice);
        }


}
               
     echo json_encode($data);
            


?>
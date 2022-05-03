 <?php

include_once('../../include/constant_verification_param.php');
require_once('../../include/constant_connection.php');

 
 $pay_type = $_POST['auto-cat'];
 $item_no = $_POST['item_no'];
 $verify = 'OK';
 
 $orderID = "";
  
 $auto_feed = $paydb->query("SELECT orderID FROM ".TBL_PAYMENTS_RECORD." WHERE paymentType = '$pay_type' AND verify != '$verify' AND payment_status = 'PENDING' LIMIT 0, 1000");
 

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
	
while($a = mysqli_fetch_array($auto_feed))
{
  $orderID = $a['orderID'];
	
	if($orderID != null)
	{
		$response = transDetails($orderID);
		$response_code = $response['status'];
		 
		if (isset($response['RRR']))
			{
	          if($response_code == '01' || $response_code == '00') 
		       { 

		    //echo '<p><b>Remita Retrieval Reference: </b> '.$rrr. '<p>';
		
		   $mySubstr = substr($orderID, 0, 2);
           
		   $rrr = $response['RRR'];
		   
           x($mySubstr, $rrr, $orderID);
			
		   echo 'Verified OK -'.$orderID.' - '.$rrr.'<br/>';

		      }
			}
		$response_message = $response['message'];
     }
	 
}

	echo '<div style="text-align: center;">';
		if($response_code == '01' || $response_code == '00') 
		{ 
		
		    
		   // echo 'Verified OK -'.$orderID.' - '.$rrr.'<br/>';
		//echo '<p><b>Remita Retrieval Reference: </b> '.$rrr. '<p>';
		
			//$mySubstr = substr($orderID, 0, 2);

			//x($mySubstr, $rrr, $orderID);
   
		}
		
		else if($response_code == '021') 
		{ 		
	echo '<p><b>Remita Retrieval Reference: </b> '.$rrr. ' - '. $orderID.'<p>';
		}	
		else
		{ 		
		echo '<div class="styleTb">Your Transaction was not Successful</div>';
		
		if ($rrr != null)
		{ 
		echo '<p class="styleTb">Your Remita Retrieval Reference (RRR) is: <span>'.$rrr. ' - '.$orderID. '</span><br />';
		} 
		
		echo 'Reason: </b> '.$response_message.' <p>';
	 }
      echo '</div>';
	  

function x($mySubstr, $rrr, $orderID)
{
	
 if($mySubstr == '01')// For Matriculations Tuition Payment
  {
	 	 $sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', gateway = 'Remita', verify = 'OK', dateTime = NOW() WHERE orderID = '$orderID'");

	  //$sql = mysql_query("UPDATE payment SET rrr = '$rrr', payment_status = 'PAID' WHERE invoiceno = '$orderID'");
	  
  }
  elseif($mySubstr == '02')// For Matriculations Hostel Fee
  {
	   	$sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', gateway = 'Remita', dateTime = NOW(), verify = 'OK' WHERE orderID = '$orderID'");

		$sql = $matdb->query("UPDATE ".TBL_HOSTEL_PAYMENTS." SET rrr = '$rrr', payment_status = 'PAID' WHERE invoiceno = '$orderID'");
	  
  }
    elseif($mySubstr == '03')// For PG Tuition Fee
   {
	   $sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', gateway = 'Remita', dateTime = NOW(), verify = 'OK' WHERE orderID = '$orderID'");

	   $sql = $pgdb->query("UPDATE fees_order SET rrr = '$rrr', payment_status = 'PAID', channel = 'Online Payment', dateTime = NOW() WHERE trans_id = '$orderID'");
	   $sql2 = $pgdb->query("UPDATE fees_summary SET payment_status = 'PAID', esa_code = '$rrr' WHERE trans_id = '$orderID'");

	  
    }
	//If Order ID is for Change of Course Fee, UG Deferment, Transcript, ID card replacement, PG deferment, BSc Accounting (PT)
 	elseif($mySubstr == '04' || $mySubstr == '05' || $mySubstr == '07' || $mySubstr == '08' || $mySubstr == '09' || $mySubstr == '10' 
	       || $mySubstr == '11' || $mySubstr == '12' || $mySubstr == '13' || $mySubstr == '14' || $mySubstr == '15' || $mySubstr == '16' 
		   || $mySubstr == '17' || $mySubstr == '18' || $mySubstr == '19' || $mySubstr == '20' || $mySubstr == '21' || $mySubstr == '22'
		   || $mySubstr == '23' || $mySubstr == '24') 
	{
		
	   $sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', gateway = 'Remita', dateTime = NOW(), verify = 'OK' WHERE orderID = '$orderID'");

	}
	
}

  	 
	 ?>
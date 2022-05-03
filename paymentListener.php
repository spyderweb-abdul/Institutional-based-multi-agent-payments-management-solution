<?php
$json = file_get_contents('php://input');
$arr=json_decode($json,true);
	try {
		if($arr!=null)
			{
				foreach($arr as $key => $value)
					{
						$orderRef = $value['orderRef'];
						//Confirm transaction Status to be sure it is coming from Remita
						$response =  remita_transaction_details($orderRef);
						$response_code = $response['status'];
						$response_reason = $response['message'];
						$rrr = $response['RRR'];
					    $orderId = $response['orderId'];
						
						  if($response_code == '01' || $response_code == '00')
							{
								//If payment is successful,
							 $mySubstr = substr($orderId, 0, 2); //Get the first 2 digits in the order ID just to confirm what the payment was for
							 
							 $phone = '';
    if($mySubstr == '00')// For UG Registration fee
   {
	   include_once('include/constant_connection.php'); 
	   
	   $sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', gateway = 'Remita', dateTime = NOW() WHERE orderID = '$orderID'");
       $count = $paydb->query("UPDATE ".TBL_COUNTER." SET cnt = cnt + 1");

	   $sql = $edudb->query("UPDATE ".TBL_FEES_ORDER." SET rrr = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', dateTime = NOW() WHERE trans_id = '$orderID'");
	   $fetch = $edudb->query(" SELECT * FROM ".TBL_FEES_ORDER." WHERE trans_id = '$orderID'");	 
	                           $mt = $fetch->fetch_array();	
	   
	                           $name = strtoupper($mt['fullName']);
							   $phone = $mt['phone'];
							   $descr = $mt['descr'];
							  // $email = $mt['email'];
	  
    }
  elseif($mySubstr == '01')// For Matriculations Tuition Payment
  {
	   	$sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', gateway = 'Remita', dateTime = NOW() WHERE orderID = '$orderID'");
        $count = $paydb->query("UPDATE ".TBL_COUNTER." counter SET cnt = cnt + 1");


	   $sql = $matdb->query("UPDATE ".TBL_PAYMENTS." SET rrr = '$rrr', payment_status = 'PAID' WHERE invoiceno = '$orderID'");
	   $fetch = $matdb->query(" SELECT * FROM ".TBL_PAYMENTS." AS a INNER JOIN ".TBL_BIODATA." AS b ON b.admNo = a.admNo WHERE a.invoiceno = '$orderID'");	 
	                           $mt = $fetch->fetch_array();	
	   
	                           $name = strtoupper($mt['surname']." ".$mt['firstname']." ".$mt['middlename']);
							   $phone = $mt['phone'];
							   $descr = $mt['descr'];
							  // $email = $mt['email'];
	  
  }
  elseif($mySubstr == '02')// For Matriculations Hostel Fee
  {
	   	$sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', gateway = 'Remita', dateTime = NOW() WHERE orderID = '$orderID'");
	    $count = $paydb->query("UPDATE ".TBL_COUNTER." SET cnt = cnt + 1");

    
		$sql = $matdb->query("UPDATE ".TBL_HOSTEL_PAYMENTS." SET rrr = '$rrr', payment_status = 'PAID' WHERE invoiceno = '$orderID'");
	    $fetch = $matdb->query(" SELECT * FROM ".TBL_HOSTEL_PAYMENTS." AS a INNER JOIN ".TBL_BIODATA." AS b ON b.admNo = a.admNo WHERE a.invoiceno = '$orderID'");	 
	                           $mt = $fetch->fetch_array();	
	   
	                           $name = strtoupper($mt['surname']." ".$mt['firstname']." ".$mt['middlename']);
							   $phone = $mt['phone'];
							   $descr = $mt['descr'];
							  // $email = $mt['email'];
	  
   }
    elseif($mySubstr == '03')// For POstgraduate Registration Fee
   {
	   $sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', gateway = 'Remita', dateTime = NOW() WHERE orderID = '$orderID'");
       $count = $paydb->query("UPDATE ".TBL_COUNTER." SET cnt = cnt + 1");

	   $sql = $pgdb->query("UPDATE fees_order SET rrr = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', dateTime = NOW() WHERE trans_id = '$orderID'");
	   $sql2 = $pgdb->query("UPDATE fees_summary SET payment_status = 'PAID', esa_code = '$rrr' WHERE trans_id = '$orderID'");
	   $fetch = $pgdb->query(" SELECT * FROM fees_order WHERE trans_id = '$orderID'");	 
	    $mt = $fetch->fetch_array();	
	   
	                           $name = strtoupper($mt['fullName']);
							   $phone = $mt['phone'];
							   $descr = $mt['descr'];
							  // $email = $mt['email'];
	  
    }
	
	 elseif($mySubstr == '06')// For UG and PG Accommodation Fee
   {
	   $sql1 = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', gateway = 'Remita', dateTime = NOW() WHERE orderID = '$orderID'");
       $count = $paydb->query("UPDATE ".TBL_COUNTER." SET cnt = cnt + 1");


	   $sql = $edudb->query("UPDATE ".TBL_HOSTEL_APP." SET appStatus = 'PAID' WHERE trans_id = '$orderID'");
	  
	   $fetch = $paydb->query(" SELECT * FROM ".TBL_PAYMENTS_RECORD." WHERE transactionID = '$orderID'");	 
	   $mt = $fetch->fetch_array();	
	   
	                           $name = strtoupper($mt['payerName']);
	                           $phone = $mt['payerPhone'];
	                           $descr = $mt['description'];
							  // $email = $mt['email'];
	  
    }
      
  elseif ($mySubstr == '04' || $mySubstr == '05' || $mySubstr == '07' || $mySubstr == '08' || $mySubstr == '09' || $mySubstr == '10' || $mySubstr == '11' || $mySubstr == '12'
     || $mySubstr == '13' || $mySubstr == '14' || $mySubstr == '15' || $mySubstr == '16' || $mySubstr == '17' || $mySubstr == '18' || $mySubstr == '19' || $mySubstr == '20' 
	 || $mySubstr == '21' || $mySubstr == '22' || $mySubstr == '23' || $mySubstr == '24' || $mySubstr == '25' || $mySubstr == '26' || $mySubstr == '27' || $mySubstr == '28'
	 || $mySubstr == '29' || $mySubstr == '32' || $mySubstr == '33' || $mySubstr == '34') //If payment is for Matriculations Tuition
    {

	 $sql = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', gateway = 'Remita', dateTime = NOW() WHERE orderID = '$orderID'");
	 $count = $paydb->query("UPDATE ".TBL_COUNTER." SET cnt = cnt + 1");
							   
	 $fetch = $paydb->query(" SELECT * FROM ".TBL_PAYMENTS_RECORD." WHERE transactionID = '$orderID'");	 
	 $mt = $fetch->fetch_array();	
	   
	                           $name = strtoupper($mt['payerName']);
	                           $phone = $mt['payerPhone'];
	                           $descr = $mt['description'];
							  // $email = $mt['email'];
	}
								   
								   
		//SMS Start Here							
       
	   $msg = 'Notification on the receipt of your payment for '.$descr. '. Your Invoice No. is: '.$orderId. ' Kindly print your UDUS Payment Receipt by verifying on our portal.' ;

		$url = "http://www.udusok.alertng.com/components/com_smsreseller/smsapi.php"; // Our API
        $url .= "?username=mitsafe"; //your username on our account
        $url .= "&password=mitsafe"; // your password
        $url .= "&sender=UDUPAY"; //Sender Name
        $url .= "&recipient=".urlencode($phone); // variable that contain gsms number $gsm
        $url .= "&message=".urlencode($msg); // the message above.
        @fopen($url, "r",255);	
							   
	  //SMS ends here
							  }
					  }
				exit('OK');
			}
		
		}
		catch (Exception $e) {
			exit('Not OK');
		}
function remita_transaction_details($orderId){
	//$mert =  "2547916";
	$mert =  "573566089";
	//$api_key = "1946";
	$api_key = "695470";
	$mode = "Live";
	$hash_string = $orderId . $api_key . $mert;
	$hash = hash('sha512', $hash_string);
	if( $mode == 'Test' ){
		$query_url = 'http://www.remitademo.net/remita/ecomm';
		}
	elseif($mode == 'Live' ){
		$query_url = 'https://login.remita.net/remita/ecomm';
		}
	$url 	= $query_url . '/' . $mert  . '/' . $orderId . '/' . $hash . '/' . 'orderstatus.reg';
	$result = file_get_contents($url);
    $response = json_decode($result, true);
    return $response;
}
?>
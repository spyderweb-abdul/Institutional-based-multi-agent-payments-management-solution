 <?php
 
 include_once('../include/constant_verification_param.php');
 include_once('../include/constant_connection.php');
 

$orderID1 = $_POST['orderID1'];
$orderID2 = $_POST['orderID2'];

$myArray = array($orderID1, $orderID2);

$count = 0;

foreach($myArray as $x)
{
$response_code ="";
$rrr = "";
$response_message = "";
//Verify Transaction
	if($x != null)
	{
		$response = transDetails($x);
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
		     
		   $sql = $paydb->query("UPDATE ".TBL_PAYMENTS_RECORD." SET transactionID = '$rrr', payment_status = 'PAID', channel = 'Bank Branch', gateway = 'Remita', dateTime = NOW(), verify = 'OK' WHERE orderID = '$x'");
		   $count += 1;
		}
		
		else if($response_code == '021') 
		{ 		
	    echo '<div class="alert alert-success"> RRR Generated Successfully </div>';
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
}
       if($count == 2)
	   {
		   $sel = $paydb->query("SELECT userId, payerPhone FROM ".TBL_PAYMENTS_RECORD." WHERE orderID = '$orderID1'");
		   $ft = $sel->fetch_array();
		   
		   $jambno = $ft[0];
		
		   echo '<div class="alert alert-success">Payment Verified OK - <a href="http://admissions.udusok.edu.ng/evidenceOfAdmission.php?id2='.strtoupper($jambno).'"> Click to print evidence of admission </a> </div>';
	   }
		//echo '<p><b>Remita Retrieval Reference: </b> '.$rrr. '<p>';
		
//Payment verification function from remita
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
	 ?>
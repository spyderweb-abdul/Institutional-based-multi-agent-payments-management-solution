 <?php
 include_once('../include/constant_verification_param.php');

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
		 if($response_code == '021') 
		{ 		
	    echo '<div class="alert alert-success">RRR Generated Successfully</div>';
		echo '<p><b>Your Remita Retrieval Reference (RRR) is: </b> '.$rrr. '<p>';
	
  ?>
<html>
  <body>
  <div style="text-align:left">
      <p><u>STEPS TO RETRIEVE YOUR PAYMENT INVOICE</u></p>
      <ul>
        <li>Kindly visit <a href="http://remita.net" target="_blank">http://remita.net</a></li>
        <li>Locate and click on the image below</li>
        <img src="../images/img_remita.png" width="152" height="107" class="img-thumbnail" title="PAY AN ELECTRONIC INVOICE" alt="PAY AN ELECTRONIC INVOICE" />
        <li>Insert your RRR in the displayed field</li>
        <li>Click on 'Continue' to re-generate your invoice</li>
      </ul>
      </div>
</body>
  
</html>
<?php
	}	
	else
	{
			    echo '<div class="alert alert-success">RRR Cannot be found. <br/> Reason:
				<ul>
				<li> either payment has been made successfully for this invoice no or, </li><br/>
				<li> there was no request for this order. Kindly re-process payment. </li>
				</ul>				
				</div>';

	}
	
echo '</div>';

?>
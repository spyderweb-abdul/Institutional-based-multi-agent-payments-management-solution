<?php
//success+trans_amount + merchant_no + merchant_trans_id + response_url + secret_key
		
		$success = $_POST['SUCCESS'];
        $etztransid = $_POST['TRANSACTION_REF'];//TRANSACTION_ID
		$transid = $_POST['TRANSACTION_ID'];
		$terminal_id = $_POST['TERMINAL_ID'];
		$response_url = $_POST['RESPONSE_URL'];
        $final_checksum = $_POST['FINAL_CHECKSUM'];
        $new_checksum = $_POST['CHECKSUM'];
        $trans_num = $_POST['TRANS_NUM'];
        $reference = $_POST['DESCRIPTION'];
		$secret_key = $_POST['SECRET_KEY'];
        $amount = $_POST['AMOUNT'];		
        $response_code = $_POST['SUCCESS'];	
		
		$successs = $_GET['SUCCESS'];
        $etztransids = $_GET['TRANSACTION_REF'];//TRANSACTION_ID
		$transids = $_GET['TRANSACTION_ID'];
		$terminal_ids = $_GET['TERMINAL_ID'];
		$response_urls = $_GET['RESPONSE_URL'];
        $final_checksums = $_GET['FINAL_CHECKSUM'];
        $new_checksums = $_GET['CHECKSUM'];
        $trans_nums = $_GET['TRANS_NUM'];
        $references = $_GET['DESCRIPTION'];
		$secret_keys = $_GET['SECRET_KEY'];
        $amounts = $_GET['AMOUNT'];		
        $response_codes = $_GET['SUCCESS'];	
			
        $msg = $_POST['msg'];
        $status_desc = "";	
        $finalcheck=hash("sha256" ,$success.$amount.$terminal_id.$transid.$secret_key);			
		if(isset($_POST['FINAL_CHECKSUM']) == $finalcheck){
			
		}
		else {
			echo '<p class="error">Wrong FinalCheckSum.</p>';
			echo '<p class="error">$finalcheck</p>';
			echo '<p class="error">$final_checksum</p>';

		}
        switch ($response_code) {
            case "0":
                $status_desc = "Transaction successful. Payment accepted";
                break;
            case "-1":
                $status_desc = "Transaction timeout or invalid parameters or unsuccessful transaction in the case of Query History";
                break;
            case "1":
                $status_desc = "Destination Card Not Found";
                break;
            case "2":
                $status_desc = "Card Number Not Found";
                break;
            case "3":
                $status_desc = "Invalid Card PIN";
                break;
            case "4":
                $status_desc = "Card Expiration Incorrect";
                break;
            case "5":
                $status_desc = "Insufficient balance";
                break;
            case "6":
                $status_desc = "Spending Limit Exceeded";
                break;
            case "7":
                $status_desc = "Internal System Error Occurred, please contact the service provider";
                break;
            case "8":
                $status_desc = "Financial Institution cannot authorize transaction, Please try later";
                break;
            case "9":
                $status_desc = "PIN tries Exceeded";
                break;
            case "10":
                $status_desc = "Card has been locked";
                break;
            case "11":
                $status_desc = "Invalid Terminal Id";
                break;
            case "12":
                $status_desc = "Payment Timeout";
                break;
            case "13":
                $status_desc = "Destination card has been locked";
                break;
            case "14":
                $status_desc = "Card has expired";
                break;
            case "15":
                $status_desc = "PIN change required";
                break;
            case "16":
                $status_desc = "Invalid Amount";
                break;
            case "17":
                $status_desc = "Card has been disabled";
                break;
            case "18":
                $status_desc = "Unable to credit this account immediately, credit will be done later";
                break;
            case "19":
                $status_desc = "Transaction not permitted on terminal";
                break;
            case "20":
                $status_desc = "Exceeds withdrawal frequency";
                break;
            case "21":
                $status_desc = "Destination Card has expired";
                break;
            case "22":
                $status_desc = "Destination Card Disabled";
                break;
            case "23":
                $status_desc = "Source Card Disabled";
                break;
            case "24":
                $status_desc = "Invalid Bank Account";
                break;
            case "25":
                $status_desc = "Insufficient Balance";
                break;
            case "26":
                $status_desc = "CHECKSUM/FINAL_CHECKSUM error";
                break;
            default:
                $status_desc = "Your Transaction was not Successful. No amount was debited from your account.";
                break;
        }
        if ($msg == "") {
            $msg = $status_desc;
        }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Response page</title>
</head>
<body>
<strong><h1>Response Page</h1></strong>
    <form id="form1">
    <div>
    <table class="table">
                        <tr class="active">
                            <td >
                               POST  Transaction ID:</td>
                            <td><?php echo $transid;?></td>
                        </tr>
						                        <tr class="active">
                            <td >
                               GET  Transaction ID:</td>
                            <td><?php echo $transids;?></td>
                        </tr>
                        <tr class="info">
                            <td >
                                POST Transaction Status:</td>
                            <td><?php echo $status_desc; ?></td>
                        </tr>
						 <tr class="info">
                            <td >
                                GET Transaction Status:</td>
                            <td><?php echo $status_descs; ?></td>
                        </tr>
                        <tr class="active">
                            <td >
                                POST Payment Description:</td>
                            <td><?php echo $reference; ?></td>
                        </tr>
						                       <tr class="active">
                            <td >
                                GET Payment Description:</td>
                            <td><?php echo $references; ?></td>
                        </tr>
                        <tr class="info">
                            <td >
                                POST Amount:</td>
                            <td><?php echo $amount; ?></td>
                        </tr>
						 <tr class="info">
                            <td >
                                GET Amount:</td>
                            <td><?php echo $amount; ?></td>
                        </tr>
                    </table>
    </div>
    </form>
</body>
</html>


<?php
//Interswitch respnse API alternative
$parameters['setup_name'] = $setup_name; //PRODUCT_ID should represent your product id as given by Interswitch
		$parameters['invoice'] = $invoice; //Your transaction reference 
		$parameters['amount'] = $amount; //Retrieve the amount you sent to the server for comparison with the one sent from WebPay
		$macaddress = "*******************************************************"; //as received from WebPay
		
		
		$request_param = "";
		foreach($parameters as $key=>$val) //traverse through each member of the param array
		{
			$request_param.= $key."=".urlencode($val); //we have to urlencode the values
			$request_param.= "&"; //append the ampersand (&) sign after each paramter/value pair
		}

			$request_param = substr($request_param, 0, strlen($request_param)-1); //remove the final ampersand sign from the request

			$hashtoken = hash('SHA512', $setup_name.$invoice.$macaddress); //hash your request variable combinations.
			$url = "https://sandbox.interswitchng.com/webpay/api/v1/gettransaction.json?".$request_param; //prepare the url

			//parsing the hash as header
			 $opts = array(
				 'http' => array(
				 'method' => "GET",
				 'header' => "Hash: ".$hashtoken
			 )
			);
			
			$context = stream_context_create($opts);
			
			// Open the file using the HTTP headers set above
			$response = file_get_contents($url, false, $context); //done
			print_r($response); //print out the response to see what it is.
				
?>
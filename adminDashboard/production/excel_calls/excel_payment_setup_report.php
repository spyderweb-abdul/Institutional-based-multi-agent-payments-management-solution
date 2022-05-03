<?php

session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

if(isset($_GET['setup_id']))
{
   
   $setupId = $_GET['setup_id'];
   $setup_name = $_GET['setup_name'];


		// Original PHP code by Chirp Internet: www.chirp.com.au

		  function sanitizeStr(&$data)
		  {
		  	// escape tab characters
		    $data = preg_replace("/\t/", "\\t", $data);

		    // escape new lines
		    $data = preg_replace("/\r?\n/", "\\n", $data);

		    // convert 't' and 'f' to boolean values
		    if($data == 't') $data = 'TRUE';
		    if($data == 'f') $data = 'FALSE';

		    // force certain number/date formats to be imported as strings
		    if(preg_match("/^0/", $data) || preg_match("/^\+?\d{8,}$/", $data) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $data)) {
		      $data = "$data";
		    }

		    // escape fields that include double quotes
		    if(strstr($data, '"')) $data = '"' . str_replace('"', '""', $data) . '"';
			
			
		  }

		  // file name for download
		  $filename = strtoupper($setup_name).'_PAYMENT_REPORT-'.$current_session.'-'. time() . '.xls';

		  header("Content-Disposition: attachment; filename=\"$filename\"");
		  header("Content-Type: application/vnd.ms-excel");
		  //header("Content-Type: text/plain");
		  
		  $report = false;
		   
		 $sel_setup_details = $paydb->query("SELECT e.userId AS USER_ID, e.user_name AS USERNAME, b.amount AS AMOUNT, b.invoice AS INVOICE_NO, b.transactionId AS TRANSACTION_ID, f.option_name AS GATEWAY_OPTION, b.session AS SESSION, b.dateTime AS DATE_TIME FROM 
		 	".SETUP." a INNER JOIN ".PAYMENT_RECORDS." b ON b.setupId = a.setupId 
		     INNER JOIN ".PAYMENT_CHOICE." c ON c.choiceId = a.choiceId INNER JOIN ".PAYMENT_TYPE." d ON d.typeId = a.typeId 
		     INNER JOIN ".USERS." e ON e.userId = b.userId INNER JOIN ".PAY_OPTIONS." f ON f.optionId = b.optionId 
		     INNER JOIN ".CHANNEL." g ON g.gatewayId = b.gatewayId 
		     WHERE a.setupId = '$setupId' AND a.merchantId = '$merchantId' AND b.session = '$current_session' AND b.status = 'PAID' ") or die (mysqli_error($paydb));
 
			 while($row = $sel_setup_details->fetch_assoc())
			 {
			     if(!$report) 
				{
			      // display field/column names as first row
			      echo implode("\t", array_keys($row)) . "\n";
			      $report = true;
			    }
			    array_walk($row, 'sanitizeStr');
			    echo implode("\t", array_values($row)) . "\n";
			}
  
 }
else
{
	echo 'Parameter not weel defined';
}

?>
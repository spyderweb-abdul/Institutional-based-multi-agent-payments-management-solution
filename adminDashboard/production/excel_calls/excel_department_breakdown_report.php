<?php

session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

if(isset($_GET['deptId']))
{
   
   $deptId = $_GET['deptId'];
   $department = $_GET['department'];


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
		  $filename = strtoupper($department).'_PAYMENT_REPORT-'.$current_session.'-'. time() . '.xls';

		  header("Content-Disposition: attachment; filename=\"$filename\"");
		  header("Content-Type: application/vnd.ms-excel");
		  //header("Content-Type: text/plain");
		  
		  $report = false;
	
		 $sel_dept_details = $paydb->query("SELECT b.userId AS USER_ID, e.user_name AS USERNAME, h.level AS LEVEL, c.amount AS AMOUNT, c.invoice AS INVOICE, c.transactionId AS TRANSACTION_ID, f.option_name AS GATEWAY_OPTION, d.setup_name AS SETUP_NAME, c.session AS SESSION, c.dateTime AS DATE_TIME 
		 	 FROM ".DEPARTMENT." a 
		 	 INNER JOIN ".FEES_ORDER." b ON b.deptId = a.deptId
             INNER JOIN ".PAYMENT_RECORDS." c ON c.invoice = b.invoice
             INNER JOIN ".SETUP." d ON d.setupId = b.setupId
             INNER JOIN ".USERS." e ON e.userId = b.userId
             INNER JOIN ".PAY_OPTIONS." f ON f.optionId = c.optionId 
             INNER JOIN ".CHANNEL." g ON g.gatewayId = c.gatewayId 
             INNER JOIN ".USER_DETAILS." h ON h.userId = e.userId
             WHERE a.deptId = '$deptId' AND b.merchantId = '$merchantId' AND b.session = '$current_session' AND b.status = 'PAID' GROUP BY b.userId ORDER BY h.level ") or die (mysqli_error($paydb));

 
			 while($row = $sel_dept_details->fetch_assoc())
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
	echo 'Parameter not well defined';
}

?>
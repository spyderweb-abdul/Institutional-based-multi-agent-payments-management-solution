<?php
  include_once('../../include/constant_connection.php');
  
  $paymentType = $_GET['type'];
  $payment_status = $_GET['status'];
  $session = $_GET['sess'];
  

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
  $filename = "paymentReport-" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");
  //header("Content-Type: text/plain");
  
  $report = false;
  
 $fetch = $paydb->query("SELECT userId AS PAYER_ID, payerName AS PAYER_NAME, orderID AS ORDER_ID, payerPhone AS PHONE, transactionID AS TRANS_ID, amount AS AMOUNT, channel AS CHANNEL, payment_status AS STATUS, session AS SESSION FROM ".TBL_PAYMENTS_RECORD." WHERE paymentType = '$paymentType' AND payment_status = '$payment_status' AND session = '$session'");
 while($row = $fetch->fetch_assoc())
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
  

  exit;
?>
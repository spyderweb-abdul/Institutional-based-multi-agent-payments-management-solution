<?php
  include_once('../../include/constant_connection.php');
  
  $item = $_GET['title'];
  $status = $_GET['status'];
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
  $filename = 'PG_EDUERP_'.strtoupper($item).'_REPORT-' . date('Ymd') . '.xls';

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");
  //header("Content-Type: text/plain");
  
  $report = false;
  
  
 $fetch = $edudb->query("SELECT jambno AS ADMISSION_NO, order_id AS INVOICE_NO, email AS RRR, fullnames AS DEPOSITOR, price AS AMOUNT_PAID, course AS DEPT, level_name AS LEVEL, status AS STATUS FROM ".TBL_FEES_ORDER." WHERE title = '$item' AND status = '$status' AND session = '$session' AND level_name < 100 
AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' AND programme NOT LIKE '%Bachelor%' GROUP BY jambno ORDER BY course, level_name ASC");
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
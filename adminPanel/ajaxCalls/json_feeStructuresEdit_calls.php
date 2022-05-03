<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

  include_once('../../include/constant_connection.php');


 $fetch = $paydb->query("SELECT feeID FROM ".TBL_FEE_STRUCTURE." WHERE prog ='$_SESSION[prog]' AND level = '$_SESSION[lev]' AND nationality = '$_SESSION[nat]' ");
 $num = mysqli_num_rows($fetch);
			   
	 if($num > 0)
	 {
        $output = "";
	    $amt = 0;
	   while($r = mysqli_fetch_array($fetch))
	   {
		   $feeID = $r['feeID'];
		   
		   $trace = $paydb->query("SELECT feeID, feeItem, amount FROM ".TBL_FEE_ITEMS." WHERE feeID = '$feeID'");
		   $f = mysqli_fetch_array($trace);
		 
		        if($output != "") {$output .= ","; }
	     
		        $feeID = $f['feeID'];
				$feeItem = $f['feeItem'];
		        $amount = $f['amount'];
		 
	             $output .= '{"feeItem":"'.$feeItem.'",';
				 $output .= '"feeID":"'.$feeID.'",';
	             $output .= '"amount":"'.number_format($amount, 2).'"}';
	   
	             $amt += $amount;
	   }
	   
	   $output = '{ "records":['.$output.'] , "total":[{"totalSum":"'.number_format($amt, 2).'"}] } ';
	   
	  echo ($output);
	 }

?>
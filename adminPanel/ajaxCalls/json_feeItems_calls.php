<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

  include_once('../../include/constant_connection.php');


$sel = $paydb->query("SELECT feeID, feeItem, amount FROM ".TBL_FEE_ITEMS." ORDER BY feeItem ASC");
$num = mysqli_num_rows($sel);
			   
	 if($num > 0)
	 {
       $output = "";
	   
	   while($r = mysqli_fetch_array($sel))
	   {
		   if($output != "") {$output .= ","; }
	   
	   $output .= '{"feeID":"'.$r['feeID'].'",';
	   $output .= '"feeItem":"'.$r['feeItem'].'",';
	   $output .= '"amount":"'.$r['amount'].'"}';
	   
	   }
	   $output = '{ "records":['.$output.']}';

	  echo ($output);
	 }

?>
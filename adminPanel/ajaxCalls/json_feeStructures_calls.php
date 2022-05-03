<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

  include_once('../../include/constant_connection.php');


$allFee = $paydb->query("SELECT * FROM ".TBL_FULL_FEE_STRUCTURE);
$num = mysqli_num_rows($allFee);
			   
	 if($num > 0)
	 {
       $output = "";
	   
	   while($r = mysqli_fetch_array($allFee))
	   {
		   if($output != "") {$output .= ","; }
	     
		 $prog = $r['prog'];
		 $level = $r['level'];
		 $nationality = $r['nationality'];
		 $amount = $r['amount'];
		 
				 		 
	   $output .= '{"prog":"'.$prog.'",';
	   $output .= '"level":"'.$level.'",';  
	   $output .= '"amount":"'.number_format($amount, 2).'",';
	   $output .= '"nationality":"'.$nationality.'"}';
	   
	   }
	   $output = '{ "records":['.$output.']}';

	  echo ($output);
	 }

?>
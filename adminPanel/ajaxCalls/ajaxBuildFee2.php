<?php
 include_once('../../include/constant_connection.php');
   
					 
					 $facName = mysql_real_escape_string(trim($_REQUEST['facName']));
					 $deptName = mysql_real_escape_string(trim($_REQUEST['deptName']));
					 $prog = mysql_real_escape_string(trim($_REQUEST['prog']));
					 $level = mysql_real_escape_string(trim($_REQUEST['level']));
					 $nationality = mysql_real_escape_string(trim($_REQUEST['nationality']));
					
					 $feeID = $_REQUEST['feeID'];
					 
					 $amount = 0;
					 foreach($feeID as $f)
					 {
						  $selFee = $paydb->query("SELECT amount FROM ".TBL_FEE_ITEMS." WHERE feeID = '$f'"); // select the corresponding amount
						  $yes = mysqli_fetch_array($selFee);
						 
						     $amt = $yes['amount'];   // pass value to a variable
						  	     
						     $amount += $amt;	        //add amount, and iterate
						
						 
					 //Insert items and amounts in db table
					 $postItems = $paydb->query("INSERT INTO ".TBL_FEE_STRUCTURE." (facName, deptName, prog, level, feeID, nationality) values ('$facName','$deptName', '$prog', '$level', '$f', '$nationality')");
					 }
					 
					 if($postItems == TRUE)
					 { 
					     //Post summary and full amount into fee_structure_full_table
			            $postFullFee = $paydb->query("INSERT INTO ".TBL_FULL_FEE_STRUCTURE." (prog, level, nationality, amount) values ('$prog', '$level', '$nationality', '$amount')");
					 					 
					    $msg =  'Fees built successfully';
					 }
					 else
					 {
						 'Error: Operation Failed';
					 }
					 
			
					 echo json_encode($msg);

?>

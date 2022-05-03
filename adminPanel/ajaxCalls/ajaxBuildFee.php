<?php
 include_once('../../include/constant_connection.php');
   
					 
					 $facName = mysql_real_escape_string(trim($_REQUEST['facName']));
					 $deptName = mysql_real_escape_string(trim($_REQUEST['deptName']));
					 $prog = mysql_real_escape_string(trim($_REQUEST['prog']));
					 $level = mysql_real_escape_string(trim($_REQUEST['level']));
					 $nationality = mysql_real_escape_string(trim($_REQUEST['nationality']));
					
					 $feeID = $_REQUEST['feeID'];
					
					//Check if fees have been built for the programme before
					 $ver = $paydb->query("SELECT * FROM ".TBL_FEE_STRUCTURE." WHERE prog = '$prog' AND nationality = '$nationality' AND level = '$level' ");
					 $ver_num = mysqli_num_rows($ver);
					 
					 if($ver_num > 0)//If fees have been built, do this
					 {
						 $msg['args1'] =  'Fees have already been built for this programme. Kindly edit instead.';
					 }
					 else //else
					 {					 
					  
					    $amount = 0; // Initialise amount to get, the total amount of fees built
						
						$item_arr = array();  //Initialize an empty array for fee items
						$amt_arr = array();   //Initialize an empty array for amount of each of the fee items
						//$feeid = array();     //Initialize an empty array for each of the fee IDs
											 
					 foreach ($feeID as $i) //For each of the fee IDs, do
                        {
						 $selFee = $paydb->query("SELECT  feeItem, amount FROM ".TBL_FEE_ITEMS." WHERE feeID = '$i'"); // select the corresponding feeItem and amount
						 $yes = mysqli_fetch_array($selFee);
						 
						     $amt = $yes['amount'];   // pass value to a variable
						     $feeItem = $yes['feeItem'];  //pass value to a variable
				       
						     $amount += $amt;	        //add amount, and iterate
						     $item_arr[] = $feeItem;	//Key values into the empty feeItems array
						     $amt_arr[] = $amt;        //Key values into the empty amount array
						     //$feeid[] = $i;
					      
					    }
						//******* This is for the confirmation box (javascript) to confirm the items before they are entered ****//
						
						 $arraylength = count($item_arr);   //Count the number of array values		 
						 $msg['args1'] = 'NO. OF ITEMS: '.$arraylength."\n\n";   //prepare values to be sent to ajax callback through json which is passed into JS confirm();
						   for ($i = 0; $i < $arraylength; $i++)
						    {
							 $msg['args1'] .= $item_arr[$i]. " - " .number_format($amt_arr[$i])."\n";
						    }
						 $msg['args1'] .= "\n TOTAL SUM: ". number_format($amount, 2);
						 
					   //*** confirmation box alert ends here *****//
					
					 }
					 
					 echo json_encode($msg);

?>
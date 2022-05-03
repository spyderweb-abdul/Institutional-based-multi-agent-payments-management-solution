<?php

session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';


    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];


    $facId  = $postData->fId;
    $deptId  = $postData->deptId;
    $progId  = $postData->pId;
    $category  = $postData->catId;
    $level  = $postData->levId;
    $nationality  = $postData->natId;
    $feeID = $postData->feeID;
    //$merchantId = $postData->merchId;

                    //Check if fees have been built for the programme before
					 $verify = $paydb->query("SELECT * FROM ".TBL_FEE_STRUCTURE." WHERE progId = '$progId' AND nationality = '$nationality' AND level = '$level' AND merchantId = '$merchantId' ") or die (mysqli_error($paydb));
					 $ver_num = mysqli_num_rows($verify);
					 
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
						 $selFee = $paydb->query("SELECT  feeItem, amount FROM ".TBL_FEE_ITEMS." WHERE feeID = '$i'") or die(mysqli_error($paydb)); // select the corresponding feeItem and amount
						 $yes = $selFee->mysqli_fetch_array();
						 
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
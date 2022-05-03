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
    $deptId  = $postData->dId;
    $progId  = $postData->pId;
    $category  = $postData->catId;
    $level  = $postData->levId;
    $nationality  = $postData->natId;
    $feeID = $postData->feeId;

    //Check if Fees have been created for these parameters already
    $check = $paydb->query("SELECT * FROM ".TBL_FEE_STRUCTURE." WHERE progId = '$progId' AND category = '$category' AND level = '$level' AND nationality = '$nationality' ");

         if(mysqli_num_rows($check) > 0)//If record exist, do:
         {
         	$data = 'Fees have already been built for these selections. You may edit the Fee Items instead.';
         }
         else //Otherwise, do:
         {
                    $amount = 0;
					 foreach($feeID as $f)
					 {
						  $selFee = $paydb->query("SELECT amount FROM ".FEE_ITEMS." WHERE feeID = '$f'"); // select the corresponding amount
						  $yes = $selFee->fetch_array();
						 
						     $amt = $yes['amount'];   // pass value to a variable
						  	     
						     $amount += $amt;	        //add amount, and iterate						
						 
					 //Insert items and amounts in db table
					 $postItems = $paydb->query("INSERT INTO ".TBL_FEE_STRUCTURE." (feeID, facId, deptId, progId, category, level, nationality, merchantId) values ('$f', '$facId','$deptId', '$progId', '$category', '$level', '$nationality', '$merchantId')") or die (mysqli_error($paydb));
					 }
					 
					 if($postItems == TRUE)
					 { 
					 	
					 	//Post summary and full amount into fee_structure_full_table
			            $postFullFee = $paydb->query("INSERT INTO ".TBL_FULL_FEE_STRUCTURE." (progId, level, nationality, amount, merchantId) values ('$progId', '$level', '$nationality', '$amount', '$merchantId')") or die(mysqli_error($paydb));
					 					 
					    
					 }
					 if($postFullFee == true)
					 {
					 	$data =  'Fees built successfully';
					 }
					 else
					 {
						 $data = 'Error: Operation Failed';
					 }
		  }	 
			
					 echo json_encode($data);

	

?>
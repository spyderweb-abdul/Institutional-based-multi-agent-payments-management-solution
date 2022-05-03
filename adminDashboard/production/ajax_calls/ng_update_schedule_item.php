<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';


    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

    $data = file_get_contents("php://input");
    $postData = json_decode($data);

    $feeID  = $postData->feeID;

//First, insert newly added Item into fee_structure_table       
$insert = $paydb->query("INSERT INTO ".TBL_FEE_STRUCTURE."(feeID, facId, deptId, progId, category, level, nationality, merchantId) VALUES ('$feeID','$_SESSION[facid]', '$_SESSION[deptid]', '$_SESSION[progid]', '$_SESSION[catid]', '$_SESSION[levid]', '$_SESSION[natid]', '$merchantId')") or die(mysqli_error($paydb));

if($insert == TRUE)//If insertion was successful, do:
 {
         $amount = 0;  //Initialize amount - to sum up the total amount extracted in each of the iterations
         
         //Select the particular feeID based on condition
         $s = $paydb->query("SELECT feeID FROM ".TBL_FEE_STRUCTURE." WHERE progId = '$_SESSION[progid]' AND level = '$_SESSION[levid]' AND nationality = '$_SESSION[natid]'");
         while ($r = $s->fetch_array()) //Iteration starts here
         {
             $feeid = $r['feeID'];  //Get the feeID
             
             $amtID = $paydb->query("SELECT amount FROM ".FEE_ITEMS." WHERE feeID = '$feeid'"); //Select the specific amount allocated to the feeID
             $a = $amtID->fetch_array();
             
             $amt = $a['amount']; //Get the amount
             
             $amount += $amt;  //Sum amount and re-iterate
         }
                
        //Update the sum amount in the fee_structure_full_table             
        $upd = $paydb->query("UPDATE ".TBL_FULL_FEE_STRUCTURE." SET amount = '$amount' WHERE progId = '$_SESSION[progid]' AND level = '$_SESSION[levid]' AND nationality = '$_SESSION[natid]' AND merchantId = '$merchantId' ");
                                    
        if($upd == TRUE) //If update query was successful, flag success message
        {            
          $data = 'Fee Item added successfully and new fee amount updated.';
        }
        else  //else, do this:
        {
          $data = 'New total amount caanot be updated. Please check and try again.';  
        }
}
 else   //Else if Insertion was unsuccessful
{
                
         $data = 'Operation Failed.';
}
                
   echo json_encode($data);
            
?>
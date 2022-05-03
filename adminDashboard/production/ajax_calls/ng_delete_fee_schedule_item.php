<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];
 
			 if(isset($_GET['feeId']))
			 {
			   $feeId = $_GET['feeId'];	 


			 //Delete from Fee structure table
			$del = $paydb->query("DELETE FROM ".TBL_FEE_STRUCTURE." WHERE feeID = '$feeId' AND progId = '$_SESSION[progid]' AND level = '$_SESSION[levid]' AND nationality = '$_SESSION[natid]' AND merchantId = '$merchantId' ") or die (mysqli_error($paydb));
                     
            if($del == TRUE)
			 {
				     //Try to rebuild the fee amount in the structure_full_table
					$amount = 0;
					$s = $paydb->query("SELECT feeID FROM ".TBL_FEE_STRUCTURE." WHERE progId = '$_SESSION[progid]' AND level = '$_SESSION[levid]' AND nationality = '$_SESSION[natid]' AND merchantId = '$merchantId'") or die (mysqli_error($paydb));
							 
					 while ($r = $s->fetch_array())
					   {
								 $feeid = $r['feeID'];
								 
								 $amtID = $paydb->query("SELECT amount FROM ".FEE_ITEMS." WHERE feeID = '$feeid'") or die (mysqli_error($paydb));
								 $a = $amtID->fetch_array();
								 
								 $amt = $a['amount'];
								 
								 $amount += $amt;
						}
					
					//Update the new fee_structure				
					$upd = $paydb->query("UPDATE ".TBL_FULL_FEE_STRUCTURE." SET amount = '$amount' WHERE progId = '$_SESSION[progid]' AND level = '$_SESSION[levid]' AND nationality = '$_SESSION[natid]' AND merchantId = '$merchantId'") or die (mysqli_error($paydb));
														
							if($upd == TRUE)
							{ 			 
							  $data = 'Fee Schedule Item Deleted Successfully. Update has been done.';
							}
							else
							{
							  $data = 'Fee Update Failed. Please try again.';	
							}
                }
				else
				{
					$data = 'Operation Failed. Please try again.';	
				}
									 
				
               
				echo json_encode($data);
			}
				
			 
		

?>
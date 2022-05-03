<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

//include_once '../plugins/php-barcode/src/BarcodeGenerator.php';
//include_once '../plugins/php-barcode/src/BarcodeGeneratorPNG.php';

include_once '../plugins/phpqrcode/qrlib.php';





$userId = trim_input($_REQUEST['userId']);
$amount = $_REQUEST['amount'];
$gatewayId = trim_input($_REQUEST['gateway']);
$optionId = trim_input($_REQUEST['optionId']);
$setupId = trim_input($_REQUEST['setupId']);
$merchantId = trim_input($_REQUEST['merchantId']);
$status = 'PENDING';
$session = trim_input($_REQUEST['session']);
$description = trim_input($_REQUEST['description']);


	$invoice = strip_invoice($description);

			//Extract users Faculty and Department ID and then push into fees order table
			if(isset($_REQUEST['id']))
			{
				$level = $_REQUEST['level'];
				$progId = $_REQUEST['progId'];
				$feeID = $_REQUEST['id'];

				$get_fac_dept = $paydb->query("SELECT a.facId, b.deptId, c.progId FROM ".FACULTY." a INNER JOIN ".DEPARTMENT." b ON b.facId = a.facId INNER JOIN ".PROGRAMME. " c ON c.deptId = b.deptId WHERE c.progId = '$progId' ") or die (mysqli_error($paydb));

				  $ids = $get_fac_dept->fetch_array();
				  $facId = $ids['facId']; //Faculty ID
				  $deptId = $ids['deptId']; //Departmental ID

			    //NOW check if there exist fees record for the user in fees_order
			    $check_fees_order = $paydb->query("SELECT * FROM ".FEES_ORDER." WHERE userId = '$userId' AND session = '$session' AND setupId = '$setupId' AND merchantId = '$merchantId'") or die (mysqli_error($paydb));

			    if(mysqli_num_rows($check_fees_order) == 0)
			    {
			          foreach ($feeID as $i)
					    {
							$selFee = $paydb->query("SELECT feeItem, amount FROM ".FEE_ITEMS." WHERE feeID = '$i'");	
							$yes =   $selFee->fetch_array();
									 						 
							$amt = $yes['amount'];						 
							$feeItem = $yes['feeItem'];
								
								
							 $post_fees = $paydb->query("INSERT INTO ".FEES_ORDER." (userId, invoice, facId, deptId, progId, level, feeItem, fee_amount, session, status, dateTime, merchantId, setupId) VALUES ('$userId', '$invoice', '$facId', '$deptId', '$progId', '$level', '$feeItem', '$amt', '$session', '$status', NOW(), '$merchantId', '$setupId')") or die (mysqli_error($paydb));
						}
							 
							        //$totSum += $amt;

			    }
			    else
			    {
			    	//just update the invoice No.
			    	$update_invoice = $paydb->query("UPDATE ".FEES_ORDER." SET invoice = '$invoice' WHERE userId = '$userId' AND session = '$session' AND setupId = '$setupId' AND merchantId = '$merchantId' ");
			    }
			}

	$sel_details = $paydb->query("SELECT * FROM ".PAYMENT_RECORDS." a 
								  INNER JOIN ".USERS." b ON b.userId = a.userId 
	                              INNER JOIN ".SETUP." c ON c.setupId = a.setupId
								  INNER JOIN ".CHANNEL." d ON d.gatewayId = a.gatewayId
								  INNER JOIN ".PAY_OPTIONS." e ON e.optionId = a.optionId
								  INNER JOIN ".MERCHANTS." f ON f.merchantId = a.merchantId
								  WHERE a.userId = '$userId' AND a.setupId = '$setupId' AND a.merchantId = '$merchantId' AND a.optionId = '$optionId' AND a.session = '$session' ");

	$details = $sel_details->fetch_array();

	$setup_name = $details['setup_name'];
	$reprocessible = $details['reprocessible'];
	$old_invoice = $details['invoice'];
	
if(mysqli_num_rows($sel_details) > 0)
{
	//pass setup_name as param
	//$new = assign_invoice($setup_name, $gatewayId);

	//$invoice = strip_invoice($new);
	
	//Insert into invoice diary
	$insert_invoice_diary = $paydb->query("INSERT INTO ".INVOICE_DIARY." (userId, invoice, setupId, gatewayId, dateTime) VALUES ('$userId', '$invoice', '$setupId', '$gatewayId', NOW())");

	 if($reprocessible == 'YES')//If multiple invoices can be generated for such payment
		{
          //Insert first into payment records
 		   $insert_details = $paydb->query("INSERT INTO ".PAYMENT_RECORDS." (userId, merchantId, setupId, invoice, amount, status, optionId, gatewayId, session) VALUES ('$userId', '$merchantId', '$setupId', '$invoice', '$amount', '$status', '$optionId', '$gatewayId', '$session')");
		}
		
	 //Update the database with the new invoice no.
	 $upd_details = $paydb->query("UPDATE ".PAYMENT_RECORDS." SET invoice = '$invoice' WHERE invoice = '$old_invoice' ");		

}
else
{
	  //Insert first into payment records
 		$insert_details = $paydb->query("INSERT INTO ".PAYMENT_RECORDS." (userId, merchantId, setupId, invoice, amount, status, optionId, gatewayId, session) VALUES ('$userId', '$merchantId', '$setupId', '$invoice', '$amount', '$status', '$optionId', '$gatewayId', '$session')");

 		//Insert into invoice diary
 		$insert_invoice_diary = $paydb->query("INSERT INTO ".INVOICE_DIARY." (userId, invoice, setupId, gatewayId, dateTime) VALUES ('$userId', '$invoice', '$setupId', '$gatewayId', NOW())");
 
 		$sel_details = $paydb->query("SELECT * FROM ".PAYMENT_RECORDS." a 
							  INNER JOIN ".USERS." b ON b.userId = a.userId 
                              INNER JOIN ".SETUP." c ON c.setupId = a.setupId
							  INNER JOIN ".CHANNEL." d ON d.gatewayId = a.gatewayId
							  INNER JOIN ".PAY_OPTIONS." e ON e.optionId = a.optionId
							  INNER JOIN ".MERCHANTS." f ON f.merchantId = a.merchantId
							  WHERE a.userId = '$userId' AND a.setupId = '$setupId' AND a.merchantId = '$merchantId' AND a.optionId = '$optionId' AND a.session = '$session' ");
  		$details = $sel_details->fetch_array();
}

		
		echo '<div id="users-details">';
		echo '<div class="row">';
          
           echo '<div class="col-md-12 col-sm-12 col-xs-12">';

              $logo = 'logos/'.$details['logo'];

          
              $charges = number_format(0, 2);
		      $total = number_format($amount + $charges, 2);

              echo '<span class="merchant-name-logo"> <img src="'.$logo.'" />'.$details['merchant_name'].'<h6>'.$details['setup_name'].' (Local Invoice) - '.$details['current_session'].' </h6><span>';

           echo '<hr /></div>';

           echo '<div class="col-md-8 col-sm-8 col-xs-8"> <h4 style="color: #666; color: #264158;"> Invoice No: '. $invoice. '</h4> <br/>
                 <h6 style="color: #666; padding-right: 5px;"> Preferred Channel: '.$details['gateway_name']. ' <i class="fa fa-angle-double-right"> </i> '.$details['option_name']. '<br/>
                 <h6 style="color: #666; padding-right: 5px;">';

	       $uid = "'".$userId."'";

            echo ' <button class="btn btn-sm btn-link" target="_blank" style="text-decoration: none;" onclick="printerFriendly('.$uid.', '.$setupId.', '.$optionId.', '.$merchantId.', '.$invoice.')"> <i class="fa fa-print"> </i> [Print]  </button>';
            
            echo '</h6></div>';

               echo '<div class="col-md-4 col-sm-4 col-xs-4"> <p style="color: #999; padding: 7px; float:left;">Date Generated: '.date('Y-m-d').'</p>';

                  // here DB request or some processing 
				    $codeText = $invoice.' - '.$userId.' - '.$details['merchant_name'].'/'.$merchantId.' - '.$details['setup_name'].' - '.$total;    

				     
				    // outputs image directly into browser, as svg
				    QRcode::svg($codeText);

             echo '</div><br/>';
          

          echo '<div class="col-md-12 col-sm-12 col-xs-12"> <hr /> </div>';

		echo '<table width=90%" style="color: #333;" align="center">';
		echo '<tr ><th colspan="3" style="color: #333; padding: 8px;"> PAYER INFO: </th></tr>';
		echo '<tr> <td style="padding: 7px;"> <strong>Payer ID: </strong>  </td> <td> <strong>'.$details['userId']. '</strong> </td> <td rowspan="4"> </td> </tr>'; 
		echo '<tr> <td style="padding: 7px;"> <strong>Name:  </strong> </td> <td> '.$details['user_name'].' </td> </tr>';
		echo '<tr> <td style="padding: 7px;"> <strong>Phone No:  </strong> </td> <td> '.$details['user_phone'].' </td> </tr>';
		echo '<tr> <td style="padding: 7px;"> <strong>Email:  </strong> </td> <td> '.$details['user_email'].' </td> </tr>';


		echo '<tr> <td colspan="3" style="padding:15px; color:#666;">';  

		    echo '<table style="font-size: 12px; background-color: #f1f1f1; border-radius: 5px;" width="90%">';
			echo '<tr> <td style="padding: 5px;"> <strong>Amount Payable: </strong>  </td> <td>'.number_format($amount, 2). '</td> </tr>'; 
			echo '<tr> <td style="padding: 5px;"> <strong>Charges: </strong>  </td> <td>'.$charges. ' </td> </tr>'; 
			echo '<tr> <td style="padding: 5px;"> <strong>TOTAL: </strong>  </td> <td> <strong>'.$total. '</strong> </td> </tr>'; 
			echo '<table>';

	    echo '</td> </tr></table>';
		
	    //Pass these variables into an array to be sent to the paymentGatewayIntegration.php page
	    $paramArray = array("$userId", "$gatewayId", "$setupId", "$optionId", "$merchantId", "$session");
		       
		echo'<form name="process-payment" id="process-payment" method="" action="" >';
			 foreach($paramArray as $arr)
			 {
			  echo '<input type="hidden" name="param[]" value="'.$arr.'" >';
			 }
			 
	   echo '</form>';
		  echo  '<div style="padding-top: 20px; text-align: center;" id="div-submit-details">		          
					<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"> <i class="fa fa-close"> </i> Discard </button>
					<button type="button" class="btn btn-sm btn-warning" id="btn-submit-payment-details"> <i class="fa fa-check"> </i> Continue </button>   
		         </div>

		          <p id="process-pay" style="padding: 10px; display: inline-block; text-align: center;"> </p>

         </div></div>';

?>
      

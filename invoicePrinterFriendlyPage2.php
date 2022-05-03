<?php
include_once 'config/connections/constant_connection.php';
include_once 'config/constant_define/constants.php';
include_once 'config/functions/control_functions.php';

include_once 'plugins/php-barcode/src/BarcodeGenerator.php';
include_once 'plugins/php-barcode/src/BarcodeGeneratorPNG.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/paytonify-logo-mini.png" />
<title>Paytonify</title>

<link href="plugins/bootstrap_css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/animate/animate.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/custom_css/style.css" rel="stylesheet" type="text/css" />



</head>

<body onload="window.print();">


<?php
if(isset($_REQUEST['userId']))
{

$userId = trim_input($_REQUEST['userId']);
$optionId = trim_input($_REQUEST['optionId']);
$setupId = trim_input($_REQUEST['setupId']);
$merchantId = trim_input($_REQUEST['merchantId']);
$invoice = trim_input($_REQUEST['invoice']);

 
$sel_details = $paydb->query("SELECT * FROM ".PAYMENT_RECORDS." a 
							  INNER JOIN ".USERS." b ON b.userId = a.userId 
                              INNER JOIN ".SETUP." c ON c.setupId = a.setupId
							  INNER JOIN ".CHANNEL." d ON d.gatewayId = a.gatewayId
							  INNER JOIN ".PAY_OPTIONS." e ON e.optionId = a.optionId
							  INNER JOIN ".MERCHANTS." f ON f.merchantId = a.merchantId
							  WHERE a.userId = '$userId' AND a.setupId = '$setupId' AND a.merchantId = '$merchantId' AND a.optionId = '$optionId' AND a.invoice = '$invoice' ") or die (mysqli_error($paydb));

  $details = $sel_details->fetch_array();

  echo '<div style="margin-left: 30px; margin-top: 10px;">';

		echo '<div class="row">';
          
         echo '<div class="col-md-12 col-sm-12 col-xs-12">';

              $logo = 'logos/'.$details['logo'];

              $amount = $details['amount'];

              $charges = number_format(0, 2);
		      $total = number_format($amount + $charges, 2);

          echo '<span class="merchant-name-logo"> <img src="'.$logo.'" />'.$details['merchant_name'].'<h6>'.$details['setup_name'].' (Local Invoice) - '.$details['session'].' </h6><span>';

         echo '</div>';


         echo '<div class="col-md-12 col-sm-12 col-xs-12" style="width: 55%; float: left;"> <hr /> </div>';

         echo '<div class="col-md-6 col-sm-6 col-xs-12"> <h5 style="color: #666; color: #264158;"> <b>Invoice No: '. $invoice. '</b></h5> <br/>
               <h6 style="color: #666;"> Preferred Channel: '.$details['gateway_name']. ' <i class="fa fa-angle-double-right"> </i> '.$details['option_name']. '<br/>
                 <h6 style="color: #000;">';

                  $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

                  $barcodeString = $invoice;

                  echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcodeString, $generator::TYPE_CODABAR)) . '">';

         echo '</h6></div>';

         echo '<div class="col-md-4 col-sm-4 col-xs-12"> <p style="color: #999;">Date Printed: '.date('Y-m-d').'</p><br/>
           <p><button class="btn btn-sm btn-link" style="text-decoration: none;" onclick="window.print()"> <i class="fa fa-print"> </i> [Print] </button></p></div><br/>';

        echo '<div class="col-md-12 col-sm-12 col-xs-12" style="width: 55%; float: left;"> <hr /> </div>';

		echo '<table width="70%" style="color: #333; font-size: 12px;">';
		echo '<tr ><th colspan="3" style="color: #333; padding: 8px;"> PAYER INFO: </th></tr>';
		echo '<tr> <td style="padding: 4px;"> <strong>Payer ID: </strong>  </td> <td> <strong>'.$details['userId']. '</strong> </td> <td rowspan="4"> </td> </tr>'; 
		echo '<tr> <td style="padding: 4px;"> <strong>Name:  </strong> </td> <td> '.$details['user_name'].' </td> </tr>';
		echo '<tr> <td style="padding: 4px;"> <strong>Phone No:  </strong> </td> <td> '.$details['user_phone'].' </td> </tr>';
		echo '<tr> <td style="padding: 4px;"> <strong>Email:  </strong> </td> <td> '.$details['user_email'].' </td> </tr>';


		echo '<tr> <td colspan="3" style="padding:15px; color:#666;">';

		$choiceId = $details['choiceId'];
		$setup = $details['setup_name'];


		       //Check if payment choice is tuition and display the fees item
               $check_payment_choice = $paydb->query("SELECT * FROM ".PAYMENT_CHOICE." WHERE choiceId = '$choiceId' AND merchantId = '$merchantId'") or die (mysqli_error($paydb));
               $choice = $check_payment_choice->fetch_array();

               if($choice['req_fee_items'] == 'YES')
               {

						           $get_users_details = $paydb->query("SELECT * FROM ".USER_DETAILS." WHERE userId = '$userId'") or die (mysqli_error($paydb));
				                   $details = $get_users_details->fetch_array();

				                     $level = $details['level']; //Level of User
				                     $category = $details['category']; //Category of User
				                     $nationality = $details['nationality']; //Nationality of user
				                     $progId = $details['progId']; //User's Programme
				                  
				                  //Extract Fee Items for user's programme
				                    $get_fee_details = $paydb->query("SELECT * FROM ".PROGRAMME." a INNER JOIN ".TBL_FEE_STRUCTURE." b ON a.progId = b.progId INNER JOIN ".TBL_FULL_FEE_STRUCTURE." c ON c.progId = a.progId WHERE b.progId = '$progId' AND b.level = '$level' AND b.category = '$category' AND b.nationality = '$nationality' AND b.merchantId = '$merchantId' ") or die (mysqli_error($paydb));

				                    if(mysqli_num_rows($get_fee_details) > 0)
				                    {

				                        $row = $get_fee_details->fetch_array();

				                         echo '<strong><u>'.$setup.' <i class="fa fa-angle-double-right"></i> '.$level.'LEVEL <i class="fa fa-angle-double-right"></i> '.strtoupper($row['programme']).'</u></strong><br/><br/>';

				                         echo '<table width="60%"><tr>';
				                         echo '<th> </th>';
				                         echo '<th> Fee Item </th>';
				                         echo '<th> Amount </th></tr>';

				                         $get_fee_details->data_seek(0);

				                         $amt = 0;  //Initialise sum amount

				                         while ($item = $get_fee_details->fetch_array()){
				                          
				                            $feeID = $item['feeID'];

				                            //Now get details of fee ID
				                            $get_items_details = $paydb->query("SELECT * FROM ".FEE_ITEMS." WHERE feeID = '$feeID' AND merchantId = '$merchantId'") or die (mysqli_error($paydb));
				                            $fee = $get_items_details->fetch_array();

				                               $feeItem = $fee['feeItem'];//Fee Item
				                               $feeamount = $fee['amount']; //Amount
				                            
				                               echo '<tr>';
				                               echo '<td> <i class="fa fa-angle-double-right"></i> </td>';
				                               echo '<td>'.$feeItem.'</td>';
				                               echo '<td>'.number_format($feeamount, 0).'</td>';
				                               echo '</tr>';

				                               $amt += $feeamount; //Increment sum amount

				                           }

				                              $chrg = number_format(0, 2);
				                              $tot = number_format($amt + $chrg, 2);

				                        echo '<tr> <td colspan="3" style="padding: 20px; margin: 20px;">';

				                              		echo '<table style="font-size: 12px; background-color: #f1f1f1; border-radius: 5px;" width="100%">';
													echo '<tr> <td style="padding: 5px;"> <strong>Amount Payable: </strong>  </td> <td>'.number_format($amt, 2). '</td> </tr>'; 
													echo '<tr> <td style="padding: 5px;"> <strong>Charges: </strong>  </td> <td>'.$chrg. ' </td> </tr>'; 
													echo '<tr> <td style="padding: 5px;"> <strong>TOTAL: </strong>  </td> <td> <strong>'.$tot. '</strong> </td> </tr>'; 
													echo '<table>';


				                        echo '</td> </tr>';
				                      
				                        echo '</table>';
				                    }
				       }
				        else
				       {
				       	    echo '<table style="font-size: 12px; background-color: #f1f1f1; border-radius: 5px;" width="70%">';
							echo '<tr> <td style="padding: 5px;"> <strong>Amount Payable: </strong>  </td> <td>'.number_format($amount, 2). '</td> </tr>'; 
							echo '<tr> <td style="padding: 5px;"> <strong>Charges: </strong>  </td> <td>'.$charges. ' </td> </tr>'; 
							echo '<tr> <td style="padding: 5px;"> <strong>TOTAL: </strong>  </td> <td> <strong>'.$total. '</strong> </td> </tr>'; 
							echo '<table>';
				
				       } 


	    echo '</td> </tr></table>';

		  echo  '</div>

      </div>';

     }

?>
      
<script src="plugins/bootstrap_js/jquery-1.8.2.js" type="text/javascript"> </script>
<script src="plugins/bootstrap_js/bootstrap.min.js" type="text/javascript"></script>
<script src="plugins/custom_js/scriptsJs.js"></script>

</body>
</html>
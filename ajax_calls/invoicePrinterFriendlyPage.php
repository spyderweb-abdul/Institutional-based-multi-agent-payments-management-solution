<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

include_once '../plugins/php-barcode/src/BarcodeGenerator.php';
include_once '../plugins/php-barcode/src/BarcodeGeneratorHTML.php';


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

<body>

<?php

if(isset($_REQUEST['userId']))
{

$userId = trim_input($_REQUEST['userId']);
$optionId = trim_input($_REQUEST['optionId']);
$setupId = trim_input($_REQUEST['setupId']);
$merchantId = trim_input($_REQUEST['merchantId']);
$invoice = $_REQUEST['invoice'];

 
 		$sel_details = $paydb->query("SELECT * FROM ".PAYMENT_RECORDS." a 
							  INNER JOIN ".USERS." b ON b.userId = a.userId 
                              INNER JOIN ".SETUP." c ON c.setupId = a.setupId
							  INNER JOIN ".CHANNEL." d ON d.gatewayId = a.gatewayId
							  INNER JOIN ".PAY_OPTIONS." e ON e.optionId = a.optionId
							  INNER JOIN ".MERCHANTS." f ON f.merchantId = a.merchantId
							  WHERE a.userId = '$userId' AND a.setupId = '$setupId' AND a.merchantId = '$merchantId' AND a.optionId = '$optionId' AND invoice = '$invoice' ");
  		$details = $sel_details->fetch_array();


		echo '<div class="row">';
          
           echo '<div class="col-md-12 col-sm-12 col-xs-12">';

              $logo = '../logos/'.$details['logo'];

              $amount = $details['amount'];


              $charges = number_format(0, 2);
		      $total = number_format($amount + $charges, 2);

              echo '<span class="merchant-name-logo"> <img src="'.$logo.'" />'.$details['merchant_name'].'<h6>'.$details['setup_name'].' (Local Invoice) - '.$details['current_session'].' </h6><span>';

           echo '<hr /></div>';

           echo '<div class="col-md-8 col-sm-8 col-xs-8"> <h4 style="color: #666; color: #264158;"> Invoice No: '. $invoice. '</h4> <br/>
                 <h6 style="color: #666; padding-right: 5px;"> Preferred Channel: '.$details['gateway_name']. ' <i class="fa fa-angle-double-right"> </i> '.$details['option_name']. '<br/>
                 <h6 style="color: #666; padding-right: 5px;">';


                    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();

                   $barcodeString = $invoice;


                  echo $generator->getBarcode($barcodeString, $generator::TYPE_CODABAR);

            echo '</h6></div>';

            echo '<div class="col-md-4 col-sm-4 col-xs-4"> <p style="color: #999; padding: 7px; float:left;">Date Generated: '.date('Y-m-d').'</p>
                <p class="pull-right"> <a href="#" onclick="window.print()"> <i class="fa fa-2x fa-print"> </i> [Printer Friendly Page] </a> </p></div><br/>';
          

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
		
	
		       
		echo'<form name="process-payment" id="process-payment" method="" action="" >';
			 foreach($paramArray as $arr)
			 {
			  echo '<input type="hidden" name="param[]" value="'.$arr.'" >';
			 }
			 
	   echo '</form>';

		  echo  '<div style="padding-top: 20px; text-align: center;" id="div-submit-details">
					<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"> <i class="fa fa-close"> </i> Discard </button>
					<button type="button" class="btn btn-sm btn-warning" id="btn-submit-payment-details"> <i class="fa fa-check"> </i> Continue </button> 
			    			   
		            <p id="process-pay"> </p>
		         </div>

         </div>';

     }

?>
      
<script src="plugins/bootstrap_js/jquery-1.8.2.js" type="text/javascript"> </script>
<script src="plugins/bootstrap_js/bootstrap.min.js" type="text/javascript"></script>
<script src="plugins/custom_js/scriptsJs.js"></script>

</body>
</html>
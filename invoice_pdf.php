<?php
include_once 'config/connections/constant_connection.php';
include_once 'config/constant_define/constants.php';
include_once 'config/functions/control_functions.php';

include_once 'plugins/php-barcode/src/BarcodeGenerator.php';
include_once 'plugins/php-barcode/src/BarcodeGeneratorPNG.php';

//include_once 'plugins/phpqrcode/qrlib.php';



if(isset($_REQUEST['userId']))
{

$html = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/paytonify-logo-mini.png" />
<title>Paytonify</title>

<link href="plugins/bootstrap_css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<style type="text/css">

 .merchant-name-logo
{
    font-family: Lucida;
    font-size: 22px;
    color: #FC0;
    padding: 10px;
    width: auto;
    display: inline-block;
    text-align: center;
    margin-right: 0 auto;
    font-weight: 900;
    text-shadow: 1px 1px #000;
}
.merchant-name-logo img
{
	float: left;
	padding-right: 20px;
}
.merchant-name-logo h6
{
	color: #333;
	text-shadow: none;
	margin-right: 300px;
}

th,td,tr {
  border:0px;
  padding: 5px;
}

table {
  border:0px;
  bpadding: 5px;
}

td {
  font-family: Lucida;
  font-size:12px;
}

</style>

</head>

<body onload="window.print();">';



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

$html = $html.'<div class="row">
          
                <div class="col-md-12 col-sm-12 col-xs-12">';

              $logo = 'logos/'.$details['logo'];

              $amount = $details['amount'];

              $charges = number_format(0, 2);
		      $total = number_format($amount + $charges, 2);

		      $username = $details['user_name'];
		      $email = $details['user_email'];
		      $phone = $details['user_phone'];

     $html = $html. '<span class="merchant-name-logo"> <img src="'.$logo.'" />'.$details['merchant_name'].'<h6>'.$details['setup_name'].' (Local Invoice) - '.$details['session'].' </h6><span>

         </div>


         <hr /> 

              <h5 style="color: #666; color: #264158;"> <b>Invoice No: '. $invoice. '</b></h5>
               
             <h6 style="color: #666;"> Preferred Channel: '.$details['gateway_name']. ' &raquo; '.$details['option_name']. '
             <h6 style="color: #000;">';

                  $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

                 $barcodeString = $invoice;

               $html = $html.'<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcodeString, $generator::TYPE_CODABAR)) . '"></h6>

             <p style="color: #999;">Date Printed: '.date('Y-m-d').'</p>

             <hr /> 


		    <table width="350" style="color: #000;">
		    <tr ><th colspan="3" > PAYER INFO: </th></tr>
		    <tr> <td > <strong>Payer ID: </strong>  </td> <td> <strong>'.$userId. '</strong> </td> <td rowspan="4"> </td> </tr> 
		    <tr> <td > <strong>Name:  </strong> </td> <td> '.$username.' </td> </tr>
		    <tr> <td > <strong>Phone No:  </strong> </td> <td> '.$phone.' </td> </tr>
		    <tr> <td > <strong>Email:  </strong> </td> <td> '.$email.' </td> </tr>

		    </table><br/><br/>';


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

				                    $html = $html.'<br/><p style="font-family: Helvetica; font-size: 11px; color: #000;"><u>'.$setup.' &raquo; '.$level.'LEVEL &raquo; '.strtoupper($row['programme']).'</u></p><br/>
				                         
				                           <table width="250" style="padding: 3px; color: #000;"><tr>
				                             <th> </th>
				                             <th> Fee Item </th>
				                             <th> Amount </th></tr>';

				                         $get_fee_details->data_seek(0);

				                         $amt = 0;  //Initialise sum amount

				                         while ($item = $get_fee_details->fetch_array()){
				                          
				                            $feeID = $item['feeID'];

				                            //Now get details of fee ID
				                            $get_items_details = $paydb->query("SELECT * FROM ".FEE_ITEMS." WHERE feeID = '$feeID' AND merchantId = '$merchantId'") or die (mysqli_error($paydb));
				                            $fee = $get_items_details->fetch_array();

				                               $feeItem = $fee['feeItem'];//Fee Item
				                               $feeamount = $fee['amount']; //Amount
				                            
				                               $html = $html.'<tr>
				                               <td> &raquo; </td>
				                               <td>'.$feeItem.'</td>
				                               <td>'.number_format($feeamount, 0).'</td>
				                               </tr>';

				                               $amt += $feeamount; //Increment sum amount

				                           }

				                              $chrg = number_format(0, 2);
				                              $tot = number_format($amt + $chrg, 2);

				               $html = $html.'</table><br/><br>
				                     <table width="400" style="margin-left: 50px; padding: 10px; font-size: 12px; font-weight:bold; background-color: #f1f1f1; border-radius: 5px; color:#000;">
										<tr> <td > Amount Payable:   </td> <td>'.number_format($amt, 2). '</td> </tr>
									    <tr> <td > Charges:   </td> <td>'.$chrg. '</td> </tr> 
										<tr> <td > TOTAL:   </td> <td>'.$tot. '</td> </tr>
									</table>';

								}
				       }
				        else
				       {
				           $html = $html.'<table width="400" style="margin-left: 50px; padding: 10px; font-size: 12px; font-weight:bold; background-color: #f1f1f1; border-radius: 5px; color: #000;">
									 <tr> <td > Amount Payable:   </td> <td>'.number_format($amount, 2). '</td> </tr>
									 <tr> <td > Charges:   </td> <td>'.$charges. '</td> </tr> 
									 <tr> <td > TOTAL:   </td> <td>'.$total. '</td> </tr>
							  </table>';
				
				       } 


	    $html = $html.'</td> </tr></table>

		 </div>';

      
$html = $html.'<script src="plugins/bootstrap_js/jquery-1.8.2.js" type="text/javascript"> </script>
               <script src="plugins/bootstrap_js/bootstrap.min.js" type="text/javascript"></script>
               <script src="plugins/custom_js/scriptsJs.js"></script>

</body>
</html>';
}

include("plugins/mpdf60/mpdf.php");
$mpdf = new mPDF(); 

$mpdf->WriteHTML($html);
$mpdf->Output(); //Save PDF to attach to email

//exit;
?>
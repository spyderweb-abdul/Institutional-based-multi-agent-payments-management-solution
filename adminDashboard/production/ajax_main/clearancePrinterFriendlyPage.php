<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    include_once '../../../plugins/php-barcode/src/BarcodeGenerator.php';
    include_once '../../../plugins/php-barcode/src/BarcodeGeneratorPNG.php';


    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/paytonify-logo-mini.png" />
<title>Paytonify</title>

<link href="../../build/css/custom.css" rel="stylesheet" type="text/css" />
<link href="../../../plugins/bootstrap_css/bootstrap.min.css" rel="stylesheet" type="text/css">

<style type="text/css">
	
.page-content
{
   margin: 15px; 
   font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace;
   color: #000;
}

</style>



</head>

<body onload="window.print();">


<?php               

      if(isset($_GET['userId']))
                          {

                              $userId = $_GET['userId'];

                              $sel_pay_details = $paydb->query(" SELECT * FROM ".PAYMENT_RECORDS." a INNER JOIN ".USERS." b ON b.userId = a.userId INNER JOIN ".USER_DETAILS." c ON c.userId = a.userId INNER JOIN ".SETUP." d ON d.setupId = a.setupId INNER JOIN ".CHANNEL." e ON e.gatewayId = a.gatewayId INNER JOIN ".PAY_OPTIONS." f ON f.optionId = a.optionId INNER JOIN ".MERCHANTS." g ON g.merchantId = a.merchantId WHERE a.userId = '$userId' and a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));

                              $num = mysqli_num_rows($sel_pay_details);

                              if($num > 0)
                              {

                                  $res = $sel_pay_details->fetch_array();

                            echo '<div class="page-content">';                                        

                            echo '<div style="color: #333; text-align:center; font-size:15px; font-weight: 500"><h3>'.strtoupper($res['merchant_name']).'</h3></div>'; 

                            echo '<div style="color: #333; text-align:center; font-size:11px; font-weight: 500"><h4> PAYMENT CLEARANCE RECEIPT </h4></div><br/>';

                            echo '<p style="padding-left: 20px;"> <h4>'.$res['userId'].'</h4></p>';
                            echo '<p style="padding-left: 20px;"> <h6>'.$res['user_name'].' &raquo; '.$res['user_email'].' &raquo; '.$res['user_phone'].'</h6></p><br/>';  

                            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

                  			$barcodeString = $userId;

                            echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcodeString, $generator::TYPE_CODABAR)) . '">';                         

                        ?>

                              <p> <table width="100%" style="font-size: 11px;" class="table-bordered table-condensed table-hover table-responsive table-striped">
                               
                               <tr>
                                 <th> </th>
                                 <th>  Invoice No. </th>
                                 <th>  Transaction ID </th>
                                 <th>  Amount </th>
                                 <th>  Level </th>
                                 <th>  Setup Name </th>
                                 <th>  Gateway Option </th>
                                 <th>  Session </th>
                                 <th>  Status </th>
                                 <th>  Date/Time </th>
                               </tr>
                             
                             <?php 

                                  $sel_pay_details->data_seek(0);

                                  $i = 1;

                                  while($r = $sel_pay_details->fetch_array()){
                                   
                                     echo '<tr>';
                                      echo '<td>'.$i.'.</td>';
                                      echo '<td>'.$r['invoice'].'</td>';
                                      echo '<td>'.$r['transactionId'].'</td>';
                                      echo '<td>'.number_format($r['amount'], 0).'</td>';
                                      echo '<td>'.$r['level'].'</td>';
                                      echo '<td>'.$r['setup_name'].'</td>';
                                      echo '<td>'.$r['gateway_name'].'&raquo;'.$r['option_name'].'</td>';
                                      echo '<td>'.$r['session'].'</td>';
                                      echo '<td>'.$r['status'].'</td>';
                                      echo '<td>'.$r['dateTime'].'</td>';                                        
                                    echo '</tr>';

                                    $i++;
                                }

                              echo '</table></p> </div>';

                            } else { echo 'No Record Found'; }
                         
                          
                          } else {echo 'Parameters Not Properly Defined'; } 


         

?>
      
<script src="../../../plugins/bootstrap_js/jquery-1.8.2.js" type="text/javascript"> </script>
<script src="../../../plugins/bootstrap_js/bootstrap.min.js" type="text/javascript"></script>

</body>
</html>
<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';


    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];


?>

<html> 
 <body>
                 <!-- Modal Header -->
                 <div class="modal-header">
                    <h5 class="modal-title pull-left" id="modalLabel">Payer's Clearance:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div ng-app="paymentRecordCtrl">

                    <div class="modal-body"> 
                  
                      <?php 

                          if(isset($_GET['userid']))
                          {

                              $userId = $_GET['userid'];

                              $sel_pay_details = $paydb->query(" SELECT * FROM ".PAYMENT_RECORDS." a INNER JOIN ".USERS." b ON b.userId = a.userId INNER JOIN ".USER_DETAILS." c ON c.userId = a.userId INNER JOIN ".SETUP." d ON d.setupId = a.setupId INNER JOIN ".CHANNEL." e ON e.gatewayId = a.gatewayId INNER JOIN ".PAY_OPTIONS." f ON f.optionId = a.optionId INNER JOIN ".MERCHANTS." g ON g.merchantId = a.merchantId WHERE a.userId = '$userId' and a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));

                              $num = mysqli_num_rows($sel_pay_details);

                              if($num > 0)
                              {

                                  $res = $sel_pay_details->fetch_array();

                                                                    

                            echo '<div style="color: #333; text-align:center; font-size:15px; font-weight: 500"><h3>'.strtoupper($res['merchant_name']).'</h3></div>'; 

                            echo '<div style="color: #333; text-align:center; font-size:11px; font-weight: 500"><h4> PAYMENT CLEARANCE RECEIPT </h4></div><br/>';

                            echo '<p style="padding-left: 20px;"> <h4>'.$res['userId'].'</h4></p>';
                            echo '<p style="padding-left: 20px;"> <h6>'.$res['user_name'].' &raquo; '.$res['user_email'].' &raquo; '.$res['user_phone'].'</h6></p><br/>';      


                        echo ' <button class="btn btn-sm btn-link" target="_blank" style="text-decoration: none;" onclick="printerFriendly('.$userId.')"> <i class="fa fa-print"> </i> [Print]  </button>';
                     

                        ?>

                              <p> <table width="95%" style="font-size: 11px;" class="table-bordered table-condensed table-hover table-responsive table-striped">
                               
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

                              echo '</table></p>';


                            } else { echo 'No Record Found'; }
                         
                          
                          } else {echo 'Process Not Properly Defined'; } 


                           ?>

                        </div>

                       <!-- Modal Footer -->
                      <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" ng-click="close()"> Close </button>
                      <!--<button type="button" class="btn btn-warning" ng-click="saveDeptEdit(editDeptForm.$valid)" > Save Edit </button>-->
                    </div>
                   <!-- -->

        </div>

<script type="text/javascript">
//To open the hidden 'ADD NEW' div
function printerFriendly(a)
{
  var URLink = 'ajax_main/clearancePrinterFriendlyPage.php?userId='+a;

  var win = window.open(URLink, "_blank", "location=no, height=570, width=650, scrollbars=yes, status=no")
}

</script>

</body></html>
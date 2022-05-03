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
                    <h5 class="modal-title pull-left" id="modalLabel">Payment Breakdown:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div ng-app="filterReportCtrl">

                    <div class="modal-body"> 
                  
                          <?php 

                          if(isset($_GET['setupid']))
                          {

                              $setupId = $_GET['setupid'];
                              $status = $_GET['stat'];
                              $session = $_GET['sess'];

                              $sel_setup_details = $paydb->query("SELECT * FROM ".SETUP." a INNER JOIN ".PAYMENT_RECORDS." b ON b.setupId = a.setupId 
                                                                  INNER JOIN ".PAYMENT_CHOICE." c ON c.choiceId = a.choiceId INNER JOIN ".PAYMENT_TYPE." d ON d.typeId = a.typeId INNER JOIN ".USERS." e ON e.userId = b.userId INNER JOIN ".PAY_OPTIONS." f ON f.optionId = b.optionId INNER JOIN ".CHANNEL." g ON g.gatewayId = b.gatewayId WHERE a.setupId = '$setupId' AND a.merchantId = '$merchantId' AND b.session = '$session' AND b.status = '$status' ") or die (mysqli_error($paydb));

                              $num = mysqli_num_rows($sel_setup_details);

                              if($num > 0)
                              {

                              $res = $sel_setup_details->fetch_array();

                              $choice = $res['payment_choice_name'];
                              $type = $res['payment_type_name'];
                              $setup_name = $res['setup_name'];

                                

                                echo '<div style="color: #333; text-align:center; font-size:11px; font-weight: 500">'.strtoupper($choice).' <i class="fa fa-angle-double-right"></i> '.strtoupper($type).' <i class="fa fa-angle-double-right"></i> '.$setup_name. '</div><br/>'; 

                                echo '<div class="pull-right" style="padding: 10px;"> <a class="btn btn-sm btn-success" href="excel_calls/excel_payment_filter_report.php?setup_id='.$setupId.'&setup_name='.urlencode($setup_name).'&status='.urlencode($status).'&session='.urlencode($session).'"> <i class="fa fa-file-excel-o"></i> Export to Excel </a> </div>';


                           ?>

                              <table width="100%" align="center" style="font-size: 11px;" class="table-bordered table-condensed table-hover table-responsive table-striped">
                               
                               <tr>
                                 <th> </th>
                                 <th>  User ID </th>
                                 <th>  Name </th>
                                 <th>  Amount </th>
                                 <th>  Invoice No. </th>
                                 <th>  Transaction ID </th>
                                 <th>  Gateway Option </th>
                                 <th>  Session </th>
                                 <th>  Date/Time </th>
                               </tr>
                             
                             <?php 

                                   $sel_setup_details->data_seek(0);


                                  $i = 1;

                                  while($r = $sel_setup_details->fetch_array()){
                                   
                                     echo '<tr>';
                                      echo '<td>'.$i.'.</td>';
                                      echo '<td>'.$r['userId'].'</td>';
                                      echo '<td>'.$r['user_name'].'</td>';
                                      echo '<td>'.$r['amount'].'</td>';
                                      echo '<td>'.$r['invoice'].'</td>';
                                      echo '<td>'.$r['transactionId'].'</td>';
                                      echo '<td>'.$r['option_name'].'</td>';
                                      echo '<td>'.$r['session'].'</td>';
                                      echo '<td>'.$r['dateTime'].'</td>';                                        
                                    echo '</tr>';

                                    $i++;
                                }

                              echo '</table>';

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
function openMe()
{
  document.getElementById('openDiv').style.display = 'inline';
}

</script>

</body></html>
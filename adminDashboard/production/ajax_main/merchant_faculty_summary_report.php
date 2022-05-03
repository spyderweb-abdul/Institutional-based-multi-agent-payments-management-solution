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

                <div ng-app="facultyReportCtrl">

                    <div class="modal-body"> 
                  
                      <?php 

                          if(isset($_GET['facid']))
                          {

                              $facId = $_GET['facid'];

                              $sel_fac_details = $paydb->query("SELECT * FROM ".FACULTY." a INNER JOIN ".FEES_ORDER." b ON b.facId = a.facId
                                                                INNER JOIN ".PAYMENT_RECORDS." c ON c.invoice = b.invoice
                                                                INNER JOIN ".SETUP." d ON d.setupId = b.setupId
                                                                INNER JOIN ".USERS." e ON e.userId = b.userId
                                                                INNER JOIN ".PAY_OPTIONS." f ON f.optionId = c.optionId 
                                                                INNER JOIN ".CHANNEL." g ON g.gatewayId = c.gatewayId 
                                                                INNER JOIN ".USER_DETAILS." h ON h.userId = e.userId
                                                                WHERE a.facId = '$facId' AND b.merchantId = '$merchantId' AND b.session = '$current_session' AND b.status = 'PAID' GROUP BY b.userId ORDER BY h.level ") or die (mysqli_error($paydb));

                              $num = mysqli_num_rows($sel_fac_details);

                              if($num > 0)
                              {

                                  $res = $sel_fac_details->fetch_array();

                                   $faculty = $res['faculty'];
                                    

                                    echo '<div style="color: #333; text-align:center; font-size:11px; font-weight: 500">'.strtoupper($faculty).' <i class="fa fa-angle-double-right"></i> '.$current_session.' <i class="fa fa-angle-double-right"></i> BREAKDOWN </div><br/>'; 

                                    echo '<div class="pull-right" style="padding: 10px;"> <a class="btn btn-sm btn-success" href="excel_calls/excel_faculty_breakdown_report.php?facId='.$facId.'&faculty='.urlencode($faculty).'"> <i class="fa fa-file-excel-o"></i> Export to Excel </a> </div>';

                                    echo 'Total Records Extracted: '.$num.'<br/><br/>';

                                   /* $sel_fac_details->data_seek(0);


                                    while($c = $sel_fac_details->fetch_array())
                                    { 
                                              $setupId = $res['setupId'];
                                              $setupname = $res['setup_name'];                           

                                         $count_occurrence = $paydb->query("SELECT * FROM ".FEES_ORDER." WHERE setupId = '$setupId' AND merchantId = '$merchantId' AND session = '$current_session' AND status = 'PENDING' and facId = '$facId' GROUP BY userId ") or die (mysqli_error($paydb));

                                          //$occur = $count_occurrence->fetch_array();
                                          $occur_num = mysqli_num_rows($count_occurrence);
                                     
                                    }

                                echo $setupname .': '. $occur_num.'<br/>';
                                */

                        ?>

                              <p> <table width="100%" style="font-size: 11px;" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped">
                               
                               <tr>
                                 <th> </th>
                                 <th>  User ID </th>
                                 <th>  Name </th>
                                 <th>  Level </th>
                                 <th>  Amount </th>
                                 <th>  Invoice No. </th>
                                 <th>  Transaction ID </th>
                                 <th>  Gateway Option </th>
                                 <th>  Setup Name </th>
                                 <th>  Session </th>
                                 <th>  Date/Time </th>
                               </tr>
                             
                             <?php 

                                   $sel_fac_details->data_seek(0);


                                  $i = 1;

                                  while($r = $sel_fac_details->fetch_array()){

                           
                                          if($r['level'] == 1){ $r['level'] = 'Fresh'; } elseif ($r['level'] == 2){ $r['level'] = 'Returning'; } else { $r['level'] = $r['level']; }
                                   
                                     echo '<tr>';
                                      echo '<td>'.$i.'.</td>';
                                      echo '<td>'.$r['userId'].'</td>';
                                      echo '<td>'.$r['user_name'].'</td>';
                                      echo '<td>'.$r['level'].'</td>';
                                      echo '<td>'.$r['amount'].'</td>';
                                      echo '<td>'.$r['invoice'].'</td>';
                                      echo '<td>'.$r['transactionId'].'</td>';
                                      echo '<td>'.$r['gateway_name'].'&raquo;'.$r['option_name'].'</td>';
                                      echo '<td>'.$r['setup_name'].'</td>';
                                      echo '<td>'.$r['session'].'</td>';
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
function openMe()
{
  document.getElementById('openDiv').style.display = 'inline';
}

</script>

</body></html>
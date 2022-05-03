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
                    <h5 class="modal-title pull-left" id="modalLabel">Edit Setup Amount:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div ng-app="editSetupAmountCtrl">

                    <div class="modal-body"> 
                  
                          <?php 

                          if(isset($_GET['id']))
                          {

                          $setupId = $_GET['id'];

                          //$feeItemId = "{{editFeeId}}";

                          
                $sel_amount = $paydb->query("SELECT * FROM ".FEES." a INNER JOIN ".SETUP." b ON b.setupId = a.setupId WHERE b.setupId = '$setupId' AND b.merchantId = '$merchantId' ") or die (mysqli_error($paydb));
                              
                              $amt = $sel_amount->fetch_array();
                              $amount = $amt['fee_amount'];
                              $setupname = $amt['setup_name'];                          

                          ?>
                       

                              <div style="color:red; font-weight: bolder;"> {{ editSetupAmountResult }} </div><br/>


                             <form class="form-horizontal form-label-left input_mask" name="editAmountForm" novalidate>

                               <div class="row">
                                    <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left"  name="setupname" required ng-required="true" ng-model="setupname" ng-init="setupname='<?php echo $setupname; ?>'" readonly >
                                        <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editAmountForm.$submitted || editAmountForm.setupname.$touched">
                                          <div style="color: red;" ng-show="editAmountForm.setupname.$error.required"> *Amount is Required </div>
                                        </div>
                                    </div>
                                 </div>
                                                                
                                 <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" placeholder="Edit Amount (e.g 10000)" name="amount" required ng-required="true" ng-model="amount" ng-init="amount='<?php echo $amount; ?>'"  >
                                        <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editAmountForm.$submitted || editAmountForm.amount.$touched">
                                          <div style="color: red;" ng-show="editAmountForm.amount.$error.required"> *Amount is Required </div>
                                        </div>
                                    </div>
                                 </div>
                                   
                                
                            <input type="hidden" class="form-control has-feedback-left" name="setupId" ng-model="setupId" ng-init="setupId='<?php echo $setupId; ?>'">
                                                                 

                               </form>
                          
                        
                            
                              <?php } else {echo 'Setup ID Not Defined'; } ?>

                       </div>

                           <!-- Modal Footer -->
                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="close()"> Close </button>
                    <button type="button" class="btn btn-warning" ng-click="saveAmountEdit(editAmountForm.$valid)" > Save Edit </button>
                  </div>
                <!-- -->

        </div>

</body></html>
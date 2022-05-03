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
                    <h5 class="modal-title pull-left" id="modalLabel">Edit Fee Item:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div ng-app="editFeeCtrl">

                    <div class="modal-body"> 
                  
                          <?php 

                          if(isset($_GET['feeid']))
                          {

                          $feeItemId = $_GET['feeid'];

                          //$feeItemId = "{{editFeeId}}";

                          //echo $feeItemId;


                          
                              $sel_fee_details = $paydb->query("SELECT * FROM ".FEE_ITEMS." WHERE feeID = '$feeItemId' AND merchantId = '$merchantId' ") or die (mysqli_error($paydb));
                              $fetch_details = $sel_fee_details->fetch_array();

                              $feeItem = $fetch_details['feeItem'];
                              $amount = $fetch_details['amount'];
                              $scholar = $fetch_details['scholarship_applied'];

                          

                          ?>
                       

                              <div style="color:red; font-weight: bolder;"> {{ editFeeResult }} </div><br/>


                             <form class="form-horizontal form-label-left input_mask" name="editItemForm" novalidate>
                                                                
                                 <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" placeholder="Insert Fee Item Name" name="item" required ng-required="true" ng-model="item" ng-init="item='<?php echo $feeItem; ?>'"  >
                                        <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editItemForm.$submitted || editItemForm.item.$touched">
                                          <div style="color: red;" ng-show="editItemForm.item.$error.required"> *Fee Item is Required </div>
                                        </div>
                                    </div>
                                 </div>
                                   
                                
                                 <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                       <input type="text" class="form-control has-feedback-left"  placeholder="Amount (e.g 10000)" name="amount" required ng-required="true" ng-model="amount" ng-init="amount='<?php echo $amount; ?>'" >
                                        <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editItemForm.$submitted || editItemForm.amount.$touched">
                                           <div style="color: red;" ng-show="editItemForm.amount.$error.integer"> *Amount Must be Integer </div> 
                                           <div style="color: red;" ng-show="editItemForm.amount.$error.required"> *Fee Amount is Required </div>
                                        </div>
                                    </div>
                                 </div>
                                   

                                 <div class="row">
                                   <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                      <select name="scholarship" class="form-control has-feedback-left" required ng-required="true" ng-model="scholarship">
                                          <option selected ng-init="scholarship='<?php echo $scholar; ?>'" > <?php echo $scholar ?> </option>
                                           <option value=""> - </option>
                                           <option value="YES"> YES </option>
                                           <option value="NO"> NO </option>
                                       </select>
                                            <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                            <div ng-show="editItemForm.$submitted || editItemForm.scholarship.$touched">
                                              <div style="color: red;" ng-show="editItemForm.scholarship.$error.required"> *Select an Option </div>
                                            </div>
                                   </div>
                                 </div>

                                     <input type="hidden" class="form-control has-feedback-left" name="feeID" ng-model="feeID" ng-init="feeID='<?php echo $feeItemId; ?>'">
                                                                 

                               </form>
                          
                        
                            
                              <?php } else {echo 'Fee ID Not Defined'; } ?>

                       </div>

                           <!-- Modal Footer -->
                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="close()"> Close </button>
                    <button type="button" class="btn btn-warning" ng-click="saveEdit(editItemForm.$valid)" > Save Edit </button>
                  </div>
                <!-- -->

        </div>

</body></html>
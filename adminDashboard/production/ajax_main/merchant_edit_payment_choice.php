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
                    <h5 class="modal-title pull-left" id="modalLabel">Edit Payment Choice:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div ng-app="editChoiceCtrl">

                    <div class="modal-body"> 
                  
                          <?php 

                          if(isset($_GET['id']))
                          {

                          $choiceId = $_GET['id'];

                          //$feeItemId = "{{editFeeId}}";

                          
                $sel_choice = $paydb->query("SELECT * FROM ".PAYMENT_CHOICE." WHERE choiceId = '$choiceId' AND merchantId = '$merchantId' ") or die (mysqli_error($paydb));
                              
                              $choice = $sel_choice->fetch_array();
                              $choiceName = $choice['payment_choice_name'];
                          ?>
                             
                              <div ng-if="choice_proc" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>

                              <div style="color:red; font-weight: bolder;" ng-if="choice_edit_result"> {{ editChoiceResult }} </div><br/>


                             <form class="form-horizontal form-label-left input_mask" name="editChoiceForm" novalidate>

                               <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left"  name="choicename" required ng-required="true" ng-model="choicename" ng-init="choicename='<?php echo $choiceName; ?>'" >
                                        <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editChoiceForm.$submitted || editChoiceForm.choicename.$touched">
                                          <div style="color: red;" ng-show="editChoiceForm.choicename.$error.required"> *Amount is Required </div>
                                        </div>
                                    </div>
                                 </div>
                                                                
                               
                                
                            <input type="hidden" class="form-control has-feedback-left" name="choiceId" ng-model="choiceId" ng-init="choiceId='<?php echo $choiceId; ?>'">
                                                                 

                               </form>
                          
                        
                            
                              <?php } else {echo 'Choice ID Not Defined'; } ?>

                       </div>

                           <!-- Modal Footer -->
                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="close()"> Close </button>
                    <button type="button" class="btn btn-warning" ng-click="saveChoiceEdit(editChoiceForm.$valid)" > Save Edit </button>
                  </div>
                <!-- -->

        </div>

</body></html>
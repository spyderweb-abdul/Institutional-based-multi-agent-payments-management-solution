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
                    <h5 class="modal-title pull-left" id="modalLabel">Edit Payment Type:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div ng-app="editChoiceCtrl">

                    <div class="modal-body"> 
                  
                          <?php 

                          if(isset($_GET['id']))
                          {

                          $typeId = $_GET['id'];

                          //$feeItemId = "{{editFeeId}}";

                          
                $sel_type = $paydb->query("SELECT * FROM ".PAYMENT_TYPE." WHERE typeId = '$typeId' ") or die (mysqli_error($paydb));
                              
                              $type = $sel_type->fetch_array();
                              $typename = $type['payment_type_name'];
                          ?>
                             
                              <div ng-if="type_proc" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>

                              <div style="color:red; font-weight: bolder;" ng-if="type_edit_result"> {{ editTypeResult }} </div><br/>


                             <form class="form-horizontal form-label-left input_mask" name="editTypeForm" novalidate>

                               <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left"  name="typename" required ng-required="true" ng-model="typename" ng-init="typename='<?php echo $typename; ?>'" >
                                        <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editTypeForm.$submitted || editTypeForm.typename.$touched">
                                          <div style="color: red;" ng-show="editTypeForm.typename.$error.required"> *Amount is Required </div>
                                        </div>
                                    </div>
                                 </div>
                                                                
                               
                                
                            <input type="hidden" class="form-control has-feedback-left" name="typeId" ng-model="typeId" ng-init="typeId='<?php echo $typeId; ?>'">
                                                                 

                               </form>
                          
                        
                            
                              <?php } else {echo 'Type ID Not Defined'; } ?>

                       </div>

                           <!-- Modal Footer -->
                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="close()"> Close </button>
                    <button type="button" class="btn btn-warning" ng-click="saveTypeEdit(editTypeForm.$valid)" > Save Edit </button>
                  </div>
                <!-- -->

        </div>

</body></html>
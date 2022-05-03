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
                    <h5 class="modal-title pull-left" id="modalLabel">Edit Programme Name:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div ng-app="editprogrammeCtrl">

                    <div class="modal-body"> 
                  
                          <?php 

                          if(isset($_GET['progid']))
                          {

                          $progId = $_GET['progid'];

                          //$feeItemId = "{{editFeeId}}";

                          
                       $sel_prog_details = $paydb->query("SELECT * FROM ".PROGRAMME." WHERE progId = '$progId' AND merchantId = '$merchantId' ") or die (mysqli_error($paydb));
                              
                              $fetch_details = $sel_prog_details->fetch_array();
                              $programme = $fetch_details['programme'];
                          

                          ?>                      

                              <div style="color:red; font-weight: bolder;"> {{ editProgrammeResult }} </div><br/>


                             <form class="form-horizontal form-label-left input_mask" name="editProgForm" novalidate>
                                                                
                                 <div class="row">
                                    <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" placeholder="Insert Programme Name" name="programme" required ng-required="true" ng-model="programme" ng-init="programme='<?php echo $programme; ?>'"  >
                                        <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editProgForm.$submitted || editProgForm.programme.$touched">
                                          <div style="color: red;" ng-show="editProgForm.programme.$error.required"> *Programme Name is Required </div>
                                        </div>
                                    </div>
                                 </div>                                   
                                
                            <input type="hidden" class="form-control has-feedback-left" name="progId" ng-model="progId" ng-init="progId='<?php echo $progId; ?>'">
                                                                 
                          </form>
                          
                        
                      <?php } else {echo 'Programme ID Not Defined'; } ?>

                     </div>

                           <!-- Modal Footer -->
                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="close()"> Close </button>
                    <button type="button" class="btn btn-warning" ng-click="saveProgEdit(editProgForm.$valid)" > Save Edit </button>
                  </div>
                <!-- -->

        </div>

</body></html>
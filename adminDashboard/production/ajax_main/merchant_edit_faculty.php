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
                    <h5 class="modal-title pull-left" id="modalLabel">Edit Faculty Name:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div ng-app="editFacultyCtrl">

                    <div class="modal-body"> 
                  
                          <?php 

                          if(isset($_GET['facid']))
                          {

                          $facId = $_GET['facid'];

                          //$feeItemId = "{{editFeeId}}";

                          
                $sel_fac_details = $paydb->query("SELECT * FROM ".FACULTY." WHERE facId = '$facId' AND merchantId = '$merchantId' ") or die (mysqli_error($paydb));
                              
                              $fetch_details = $sel_fac_details->fetch_array();
                              $faculty = $fetch_details['faculty'];
                          

                          ?>
                       

                              <div style="color:red; font-weight: bolder;"> {{ editFacultyResult }} </div><br/>


                             <form class="form-horizontal form-label-left input_mask" name="editFacForm" novalidate>
                                                                
                                 <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" placeholder="Insert Faculty Name" name="faculty" required ng-required="true" ng-model="faculty" ng-init="faculty='<?php echo $faculty; ?>'"  >
                                        <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editFacForm.$submitted || editFacForm.faculty.$touched">
                                          <div style="color: red;" ng-show="editFacForm.faculty.$error.required"> *Faculty Name is Required </div>
                                        </div>
                                    </div>
                                 </div>
                                   
                                
                            <input type="hidden" class="form-control has-feedback-left" name="facId" ng-model="facId" ng-init="facId='<?php echo $facId; ?>'">
                                                                 

                               </form>
                          
                        
                            
                              <?php } else {echo 'Faculty ID Not Defined'; } ?>

                       </div>

                           <!-- Modal Footer -->
                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="close()"> Close </button>
                    <button type="button" class="btn btn-warning" ng-click="saveFacEdit(editFacForm.$valid)" > Save Edit </button>
                  </div>
                <!-- -->

        </div>

</body></html>
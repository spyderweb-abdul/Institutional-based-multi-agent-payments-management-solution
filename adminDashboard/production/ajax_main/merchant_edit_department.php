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
                    <h5 class="modal-title pull-left" id="modalLabel">Edit Department Name:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div ng-app="editDepartmentCtrl">

                    <div class="modal-body"> 
                  
                          <?php 

                          if(isset($_GET['deptid']))
                          {

                          $deptId = $_GET['deptid'];

                          //$feeItemId = "{{editFeeId}}";

                          
                $sel_dept_details = $paydb->query("SELECT * FROM ".DEPARTMENT." WHERE deptId = '$deptId' AND merchantId = '$merchantId' ") or die (mysqli_error($paydb));
                              
                              $fetch_details = $sel_dept_details->fetch_array();
                              $department = $fetch_details['department'];
                          

                          ?>
                       

                              <div style="color:red; font-weight: bolder;"> {{ editDepartmentResult }} </div><br/>


                             <form class="form-horizontal form-label-left input_mask" name="editDeptForm" novalidate>
                                                                
                                 <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" placeholder="Insert Department Name" name="department" required ng-required="true" ng-model="department" ng-init="department='<?php echo $department; ?>'"  >
                                        <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editDeptForm.$submitted || editDeptForm.department.$touched">
                                          <div style="color: red;" ng-show="editDeptForm.department.$error.required"> *Department Name is Required </div>
                                        </div>
                                    </div>
                                 </div>
                                   
                                
                            <input type="hidden" class="form-control has-feedback-left" name="deptId" ng-model="deptId" ng-init="deptId='<?php echo $deptId; ?>'">
                                                                 

                               </form>
                          
                        
                            
                              <?php } else {echo 'Department ID Not Defined'; } ?>

                       </div>

                           <!-- Modal Footer -->
                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="close()"> Close </button>
                    <button type="button" class="btn btn-warning" ng-click="saveDeptEdit(editDeptForm.$valid)" > Save Edit </button>
                  </div>
                <!-- -->

        </div>

</body></html>
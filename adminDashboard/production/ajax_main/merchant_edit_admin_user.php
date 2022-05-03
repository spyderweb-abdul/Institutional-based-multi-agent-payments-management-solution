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
                    <h5 class="modal-title pull-left" id="modalLabel">Edit Admin User Profile:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div ng-app="merchDetailsCtrl">

                    <div class="modal-body"> 
                  
                          <?php 

                          if(isset($_GET['userid']))
                          {

                          $userId = $_GET['userid'];

                          
                             $sel_user = $paydb->query("SELECT * FROM ".USERS." a INNER JOIN ".USERS_ROLES." b ON a.roleId = b.roleId WHERE a.userId = '$userId' AND a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));
                              $fetch_details = $sel_user->fetch_array();

                              $userId = $fetch_details['userId'];
                              $name = $fetch_details['user_name'];
                              $email = $fetch_details['user_email'];
                              $phone= $fetch_details['user_phone'];
                              $secure_code = $fetch_details['secure_code'];
                              $roleId = $fetch_details['roleId'];
                              $roles = $fetch_details['roles'];

                          

                          ?>
                       

                              <div style="color:red; font-weight: bolder;"> {{ editUserResult }} </div><br/>


                             <form class="form-horizontal form-label-left input_mask" name="editUserForm" novalidate>
                                                                
                                 <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" placeholder="Insert User ID" name="userId" required ng-required="true" ng-model="userId" ng-init="userId='<?php echo $userId; ?>'" readonly  >
                                        <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editUserForm.$submitted || editUserForm.userId.$touched">
                                          <div style="color: red;" ng-show="editUserForm.userId.$error.required"> *User ID is Required </div>
                                        </div>
                                    </div>
                                 </div>
                                   
                                
                                 <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                       <input type="text" class="form-control has-feedback-left"  placeholder="User Full Name" required ng-required="true" ng-model="name" name="name" ng-init="name='<?php echo $name; ?>'" >
                                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editUserForm.$submitted || editUserForm.name.$touched">
                                        <div style="color: red;" ng-show="editUserForm.name.$error.required"> *User Full Name is Required </div>
                                        </div>
                                    </div>
                                 </div>

                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                       <input type="text" class="form-control has-feedback-left"  placeholder="User Email" required ng-required="true" ng-model="email" name="email" ng-init="email='<?php echo $email; ?>'" >
                                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editUserForm.$submitted || editUserForm.email.$touched">
                                        <div style="color: red;" ng-show="editUserForm.email.$error.required"> *User Email is Required </div>
                                        </div>
                                    </div>
                                 </div>


                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                       <input type="text" class="form-control has-feedback-left"  placeholder="User Phone No." required ng-required="true" ng-model="phone" name="phone" ng-init="phone='<?php echo $phone; ?>'" >
                                        <span class="fa fa-mobile form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editUserForm.$submitted || editUserForm.phone.$touched">
                                        <div style="color: red;" ng-show="editUserForm.phone.$error.required"> *User Phone No. is Required </div>
                                        </div>
                                    </div>
                                 </div>

                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                       <input type="password" class="form-control has-feedback-left"  placeholder="Reset Password (Only if necessary)" ng-model="secure" name="secure" ng-init="secure='<?php echo 'secured'; ?>'" >
                                        <span class="fa fa-asterisk form-control-feedback left" aria-hidden="true"></span>
                                    </div>
                                 </div>
                                   

                                 <div class="row">
                                   <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                      <select name="roleId" class="form-control has-feedback-left" required ng-required="true" ng-model="roleId">
                                          <option selected ng-init="roleId='<?php echo $roleId; ?>'" > <?php echo $roles ?> </option>
                                           <option value=""> - </option>
                                                <?php
                                                 
                                                 //call to get roles function
                                                 $roles = get_users_roles();
                                                 while ($usr = $roles->fetch_array())

                                                 {
                                                    echo '<option value="'.$usr['roleId'].'">'.$usr['roles'].'</option>';
                                                 }


                                              ?>
                                       </select>
                                            <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                            <div ng-show="editUserForm.$submitted || editUserForm.roleId.$touched">
                                              <div style="color: red;" ng-show="editUserForm.roleId.$error.required"> *Select an Option </div>
                                            </div>
                                   </div>
                                 </div>                                                                
                                         <input type="hidden" class="form-control has-feedback-left"  ng-model="merchId" name="merchId" ng-init="merchId='<?php echo $merchantId; ?>'" >
                               </form>
                          
                        
                            
                              <?php } else {echo 'User ID Not Defined'; } ?>

                       </div>

                           <!-- Modal Footer -->
                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="close()"> Close </button>
                    <button type="button" class="btn btn-warning" ng-click="saveEdit(editUserForm.$valid)" > Save Edit </button>
                  </div>
                <!-- -->

        </div>

</body></html>
<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';


    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];
    $merchant_type = $getDetails['merchant_type_name'];


?>

<html> 
 <body>
                 <!-- Modal Header -->
                 <div class="modal-header">
                    <h5 class="modal-title pull-left" id="modalLabel">Edit User Profile:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div ng-app="editOtherUserCtrl">

                    <div class="modal-body"> 
                  
                          <?php 

                          if(isset($_GET['userid']))
                          {

                          $userId = $_GET['userid'];

                          
                             $sel_user = $paydb->query("SELECT * FROM ".USERS." a INNER JOIN ".USERS_ROLES." b ON a.roleId = b.roleId  WHERE a.userId = '$userId' AND a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));
                              $fetch_details = $sel_user->fetch_array();

                              $userId = $fetch_details['userId'];
                              $name = $fetch_details['user_name'];
                              $email = $fetch_details['user_email'];
                              $phone= $fetch_details['user_phone'];
                              $secure_code = $fetch_details['secure_code'];
                              $roleId = $fetch_details['roleId'];
                              $roles = $fetch_details['roles'];



                              //Fetch users other details if they exist already
                               $sel_others = $paydb->query("SELECT * FROM ".USERS." a INNER JOIN ".USER_DETAILS." b ON b.userId = a.userId INNER JOIN ".PROGRAMME." c ON c.progId = b.progId WHERE a.userId = '$userId' AND a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));
                              $fetch_other_details = $sel_others->fetch_array();

                              $progId = $fetch_other_details['progId'];
                              $programme = $fetch_other_details['programme'];
                              $category = $fetch_other_details['category'];
                              $level = $fetch_other_details['level'];
                              $nationality = $fetch_other_details['nationality'];

                              switch ($category) {
                                case 1:
                                  $value = 'Undergraduate';
                                  break;
                                case 2:
                                  $value = 'Postgraduate';
                                  break;
                                case 3:
                                  $value = 'Pupil';
                                  break;  
                                case 4:
                                  $value = 'Student';
                                  break;

                                default:
                                  $value = null;
                                  break;
                              }

                              switch ($nationality) {
                                case 1:
                                  $val = 'Local';
                                break;
                                case 2:
                                  $val = 'Foreign';
                                break;
                                
                                default:
                                  $val = null;
                                  break;
                              }

                              switch ($level) {
                                case 1:
                                  $level_val = 'Fresh';
                                  break;

                                case 2:
                                  $level_val = 'Returning';
                                  break;

                                default:
                                  $level_val = $level;
                                 break;
                              }

                          

                          ?>
                       
                              <div ng-if="edit_loading" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>

                              <div style="color:red; font-weight: bolder;" ng-cloak ng-if="edit_result"> {{ editUserResult }} </div><br/>

                             <form class="form-horizontal form-label-left input_mask" name="editUserForm" novalidate>
                                                                
                                 <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" placeholder="Insert User ID" name="userId" required ng-required="true" ng-model="userId" ng-init="userId='<?php echo $userId; ?>'" readonly  >
                                        <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editUserForm.$submitted">
                                          <div style="color: red;" ng-show="editUserForm.userId.$error.required"> *User ID is Required </div>
                                        </div>
                                    </div>
                                 </div>
                                   
                                
                                 <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                       <input type="text" class="form-control has-feedback-left"  placeholder="User Full Name" required ng-required="true" ng-model="name" name="name" ng-init="name='<?php echo $name; ?>'" >
                                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editUserForm.$submitted">
                                        <div style="color: red;" ng-show="editUserForm.name.$error.required"> *User Full Name is Required </div>
                                        </div>
                                    </div>
                                 </div>

                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                       <input type="text" class="form-control has-feedback-left"  placeholder="User Email" required ng-required="true" ng-model="email" name="email" ng-init="email='<?php echo $email; ?>'" >
                                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editUserForm.$submitted">
                                        <div style="color: red;" ng-show="editUserForm.email.$error.required"> *User Email is Required </div>
                                        </div>
                                    </div>
                                 </div>


                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                       <input type="text" class="form-control has-feedback-left"  placeholder="User Phone No." required ng-required="true" ng-model="phone" name="phone" ng-init="phone='<?php echo $phone; ?>'" >
                                        <span class="fa fa-mobile form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="editUserForm.$submitted">
                                        <div style="color: red;" ng-show="editUserForm.phone.$error.required"> *User Phone No. is Required </div>
                                        </div>
                                    </div>
                                 </div>

                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                       <input type="password" class="form-control has-feedback-left"  placeholder="Reset Password (Only if necessary)" ng-model="secure" name="secure" ng-init="secure='<?php echo 'secured'; ?>'" >
                                        <span class="fa fa-asterisk form-control-feedback left" aria-hidden="true"></span>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12" style="font-size: 10px; color: red;"> *You can reset password if you choose. </div>
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
                                            <div ng-show="editUserForm.$submitted">
                                              <div style="color: red;" ng-show="editUserForm.roleId.$error.required"> *Select an Option </div>
                                            </div>
                                   </div>
                                 </div>  

                                <hr />
                                  <b style="color: #666;"> Append User's Other Details: </b>
                                <hr />

                                 <div class="row">
                                   <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                      <select name="progId" class="form-control has-feedback-left" ng-model="progId">
                                          <option selected ng-init="progId='<?php echo $progId; ?>'" > <?php echo $programme ?> </option>
                                           <option value=""> - Select Programme - </option>
                                                <?php
                                                 
                                                 //call to get programmes function
                                                $prog = get_user_prog($merchantId);
                                                 while ($usr_prog = $prog->fetch_array())

                                                 {
                                                    echo '<option value="'.$usr_prog['progId'].'">'.$usr_prog['programme'].'</option>';
                                                 }


                                              ?>
                                       </select>
                                            <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                           <!-- <div ng-show="editUserForm.$submitted || editUserForm.progId.$touched">
                                              <div style="color: red;" ng-show="editUserForm.progId.$error.required"> *Select an Option </div>
                                            </div>-->
                                   </div>
                                 </div>                               


                                  <div class="row">
                                   <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                      <select name="category" class="form-control has-feedback-left" ng-model="category">

                                        <option selected ng-init="category='<?php echo $category; ?>'" > <?php echo $value; ?> </option>

                                        <option value=""> - Select Student Category - </option>
                                          <?php
                                           
                                           if($merchant_type == 'High School')
                                          { ?>
                                                      
                                              <option value="3"> Pupil </option>
                                              <option value="4"> Student </option>

                                          <?php } else { ?>

                                              <option value="1"> Undergraduate </option>
                                              <option value="2"> Postgraduate </option>

                                          <?php } ?>                                              
                                       </select>
                                            <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                           <!-- <div ng-show="editUserForm.$submitted || editUserForm.category.$touched">
                                              <div style="color: red;" ng-show="editUserForm.category.$error.required"> *Select an Option </div>
                                            </div>-->
                                   </div>
                                 </div>  

                                  <div class="row">
                                   <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                      <select name="level" class="form-control has-feedback-left" ng-model="level">
                                         <option selected ng-init="level='<?php echo $level; ?>'"> <?php echo $level_val; ?> </option>
                                        <option value=""> - Select Level - </option>
                                          
                                          <?php if($merchant_type == 'High School')
                                                    { ?>

                                                       <option value="Creche"> Creche </option>
                                                       <option value="Nursery 1"> Nursery 1 </option>
                                                       <option value="Nursery 2"> Nursery 2 </option>
                                                       <option value="Nursery 3"> Nursery 3 </option>
                                                       <option value="Primary 1"> Primary 1 </option>
                                                       <option value="Primary 2"> Primary 2 </option>
                                                       <option value="Primary 3"> Primary 3 </option>
                                                       <option value="Primary 4"> Primary 4 </option>
                                                       <option value="Primary 5"> Primary 5 </option>
                                                       <option value="Primary 6"> Primary 6 </option>
                                                       <option value="JSS 1"> JSS 1 </option>
                                                       <option value="JSS 2"> JSS 2 </option>
                                                       <option value="JSS 3"> JSS 3 </option>
                                                       <option value="SSS 1"> SSS 1 </option>
                                                       <option value="SSS 2"> SSS 2 </option>
                                                       <option value="SSS 3"> SSS 3 </option>
                                                    

                                                    <?php
                                                     } else { ?>
                                                       
                                                       <option value="100"> 100 </option>
                                                       <option value="200"> 200 </option>
                                                       <option value="300"> 300 </option>
                                                       <option value="400"> 400 </option>
                                                       <option value="500"> 500 </option>
                                                       <option value="600"> 600 </option>
                                                       <option value="700"> 700 </option>
                                                       <option value="800"> 800 </option>
                                                       <option value="900"> 900 </option>
                                                       <option value="1"> Fresh </option>
                                                       <option value="2"> Returning </option>

                                                    <?php } ?>                                              
                                       </select>
                                            <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                           <!-- <div ng-show="editUserForm.$submitted || editUserForm.level.$touched">
                                              <div style="color: red;" ng-show="editUserForm.level.$error.required"> *Select an Option </div>
                                            </div>-->
                                   </div>
                                 </div>        


                                 <div class="row">
                                   <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                      <select name="nationality" class="form-control has-feedback-left" ng-model="nationality">

                                      <option selected ng-init="nationality='<?php echo $nationality; ?>'"> <?php echo $val; ?></option>

                                      <option value=""> - Select Nationality - </option>
                                            <option value="1"> Local </option>
                                            <option value="2"> Foreign </option>
                                                                                  
                                       </select>
                                            <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                           <!-- <div ng-show="editUserForm.$submitted || editUserForm.nationality.$touched">
                                              <div style="color: red;" ng-show="editUserForm.nationality.$error.required"> *Select an Option </div>
                                            </div>-->
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
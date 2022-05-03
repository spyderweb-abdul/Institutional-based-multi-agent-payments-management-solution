<?php


$admin_details = get_admin_users_details($_SESSION['userId']);

$userId = $admin_details['userId'];
$user_name = $admin_details['user_name'];
$user_email = $admin_details['user_email'];
$user_phone = $admin_details['user_phone'];
$merchantId = $admin_details['merchantId'];


?>

 <html><body>
          
 <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true" style="color:#333;">&times;</span>
  </button>
          <div class="row" id="profile">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h4><i class="fa fa-wrench"> </i> Users Setup - <small> Administrative User's Profile Reset </small></h4>
                  
                    <div class="clearfix"></div>
                  </div>
                
                <div class="x_content" >

                 <div ng-controller="profileCtrl">

                  <?php

                  //Get User Profile Pics

                   $sel_pics = $paydb->query("SELECT pics FROM ".USERS." WHERE userId = '$userId' AND merchantId = '$merchantId' ") or die(mysqli_error($paydb));

                   $folder = 'user_pics/';

                   $fetch_pics = $sel_pics->fetch_array();

                   $pics = $fetch_pics[0];

                   $path = $folder.$pics;

                   if($pics != NULL)
                   {
                     echo '<img src="'.$path.'" class="img-circle" width="200px" height="210px" />';
                   }
                   else
                   {
                     echo '<img src="../../images/avatar.png" class="img-circle" width="200px" height="210px" />';
                   }

                  ?>
                  <br/>

                  <p> </p>
                
                    <form class="form-horizontal form-label-left input_mask" name="admin_user_form" id="admin_user_form">
                                     
                     <div class="row">
                      <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" placeholder="User Name (8 xters only)" name="userId" ng-model="userId" ng-init="userId='<?php echo $userId; ?>'" readonly >
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
                    </div>
                     
                    <div class="row">
                      <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left"  placeholder="Full Name" name="user_name" ng-model="user_name" ng-init="user_name='<?php echo $user_name; ?>'">
                        <span class="fa fa-list form-control-feedback left" aria-hidden="true"></span>
                      </div>
                     </div>
                             

                     <div class="row">
                      <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" placeholder="Email" name="user_email" ng-model="user_email" ng-init="user_email='<?php echo $user_email; ?>'">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                      </div>
                    </div>
                    
                     <div class="row">
                      <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left"  placeholder="Phone" name="user_phone" ng-model="user_phone" ng-init="user_phone='<?php echo $user_phone; ?>'">
                        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                      </div>
                     </div>

                     <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="button" class="btn btn-success" ng-click="saveProfileEdit()"><i class="fa fa-save"></i> Update Profile </button>
                        </div>
                      </div>

                  </form>

                      <br/>

                      <div ng-if="loading" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>

                    <div style="color:red; font-weight: bolder;" ng-cloak ng-if="update"> {{ profileResponse }} </div>

           <!-- change Password Panel -->

                 <div class="x_panel">
                       <strong> Change Password: </strong> <br/><br/>
                    <form class="form-horizontal form-label-left input_mask" name="change_password_form" id="change_password_form">
                        <div class="row">
                          <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                            <input type="password" class="form-control has-feedback-left" placeholder="Insert New Password" name="npasscode" ng-model="npasscode" >
                            <span class="fa fa-asterisk form-control-feedback left" aria-hidden="true"></span>
                          </div>
                        </div>

                          <div class="row">
                            <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                              <input type="password" class="form-control has-feedback-left" placeholder="Confirm New Password" name="cpasscode" ng-model="cpasscode" >
                              <span class="fa fa-asterisk form-control-feedback left" aria-hidden="true"></span>
                            </div>
                         </div> 

                         <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="button" class="btn btn-success" ng-click="changePassword()"><i class="fa fa-save"></i> Change Password </button>
                            </div>
                         </div>  

                     </form>   

                      <div ng-if="pass_loading" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>

                    <div style="color:red; font-weight: bolder;" ng-cloak ng-if="update_pass"> {{ passwordChangeResponse }} </div>             

                </div>
     <!--  -->

                  <div class="ln_solid"> </div>

                      <strong> Upload Profile Pix: </strong> <br/><br/>
                     
                  <form name="pix_upload_form" class="form-horizontal form-label-left input_mask" enctype="multipart/form-data">
                     
                      <div class="row">
                        <div class="input-group col-md-12 col-sm-12 col-xs-12">
                                  <span class="input-group-addon"> <i class="fa fa-file-o"></i> </span>
                                  <input type="file" class="form-control" name="pix_upload"  style="min-height: 50px;" id="pix_upload" />
                                  <span class="input-group-btn">
                                  <input type="button" class="btn btn-primary" name="btn_batch_upload" ng-click="upload()" value="Upload Profile Picture" style="min-height: 50px;"  /></span>   
                        </div>
                     </div>

                </form>

                 <div ng-if="pix_loading" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait while picture is saving </div>

                    <div style="color:red; font-weight: bolder;" ng-cloak ng-if="load_pix"> {{ uploadResponse }} </div>   

             </div>
           </div>
            

            </div>
          </div>
        </div>

          
<script src="../vendors/angularJs/angular.min.js"></script>
<!--<script src="../vendors/angularJs/angular-route.min.js"></script>-->
<script type="text/javascript" src="../vendors/angularJs/ui-bootstrap-tpls-2.5.0.min.js"></script>

<script type="text/javascript">

  var app = angular.module('profileApp', []);

  app.controller('profileCtrl', ['$http', '$scope', function($http, $scope){

      //Create New Faculty
  $scope.saveProfileEdit = function(){ 

    $scope.loading = true //While execution is taking palce;
    $scope.update = false //While execution is taking place

             var uid = $scope.userId;
             var name = $scope.user_name;
             var email = $scope.user_email;
             var phone = $scope.user_phone;
              
               var sendData = {'userid': uid, 'username': name, 'useremail': email, 'userphone': phone };

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_update_user_profile',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response)

                          { 
                            $scope.profileResponse = response.data;                       
                            
                          },

                          function errorCallback(response){ $scope.profileResponse = response.statusText; }).catch(function(err){ $scope.profileResponse = err; }).finally(function(){ $scope.loading = false; $scope.update = true;

                        });
      };
      
      $scope.changePassword = function(){

        var newpass = $scope.npasscode;
        var confpass = $scope.cpasscode;

        if(newpass != confpass ){ alert('Password Doesn Not Match!'); }
        else if((newpass == null) || (confpass == null)){ alert('Fields cannot be empty!'); }
        else
        {

          $scope.pass_loading = true;
          $scope.update_pass = false; 

          var sendData = {'new_pass': newpass };

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_update_user_profile_password',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response)

                          { 
                            $scope.passwordChangeResponse = response.data;                       
                            
                          },

                          function errorCallback(response){ $scope.passwordChangeResponse = response.statusText; }).catch(function(err){ $scope.passwordChangeResponse = err; }).finally(function(){ $scope.pass_loading = false; $scope.update_pass = true;

                        });
        }


      };

      $scope.upload = function()
      {
    
       //Check if file is selected
      if(document.getElementById('pix_upload').files.length == 0){ alert('No file selected!'); }
        else
        {

            $scope.pix_loading = true;
            $scope.load_pix = false;

            var fd = new FormData();
            var files = document.getElementById('pix_upload').files[0];
            fd.append('pix_upload', files);

            $http({                         
                              method: 'POST',
                              url: '../production/ajax_calls/ng_upload_user_pix',
                              data: fd,
                              withCredentials: true,
                              headers : { 'Content-Type': undefined } ,
                              transformRequest: angular.identity

                              }).then(function successCallback(response)

                              { 
                                $scope.uploadResponse = response.data; 
                                
                                window.location.reload(true);                       
                             
                              },

                              function errorCallback(response){ $scope.uploadResponse = response.statusText; }).catch(function(err){ $scope.uploadResponse = err; }).finally(function(){ $scope.pix_loading = false; $scope.load_pix = true;

                            });

        }
      }

  }]);
  

  angular.bootstrap(document.getElementById('profile'), ['profileApp']);


</script>

</body></html>
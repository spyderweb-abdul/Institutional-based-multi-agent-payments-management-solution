<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';


    //$getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    //$merchantId = $getDetails['merchantId'];
    //$current_session = $getDetails['current_session'];

?>

<div class="row" id="edit_user">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
                  
                <div class="x_title">
                    <h4><i class="fa fa-wrench"> </i> Users Setup - <small> Edit Users Profile </small></h4>
                    <!--<ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>-->
                    <div class="clearfix"></div>
                 </div>
                  
              <div class="x_content">
                                       
                        <ul class="nav nav-pills" id="myTab">
                          <li class="active"><a data-toggle="pill" href="#menu" role="tab"> <i class="fa fa-edit"></i> EDIT ADMIN USERS </a></li>
                          <li><a data-toggle="pill" href="#sec_menu" role="tab"> <i class="fa fa-edit"></i> EDIT OTHER USERS PROFILE </a></li>
                        </ul>
                     
              
                  <div class="tab-content">
                          
                          <!-- 1st TAB PILLS -->
                          <div id="menu" class="tab-pane fade in active" role="tabpanel">

                            <br/>

                            <div ng-controller="adminUsersCtrl">

                               <div style="color:red; font-weight: bolder;" ng-cloak> {{ adminUserDeleteResponse }} </div><br/>

                                  <table align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                                    <tr>
                                       <th> </th>
                                       <th> USER ID </th>
                                       <th> NAME </th>
                                       <th> EMAIL  </th>
                                       <th> PHONE </th>
                                       <th> ROLE </th>
                                       <th> EDIT </th>
                                       <th> DELETE  </th>
                                    </tr>

                                    <tr ng-repeat="x in users">
                                      <td > <i class="fa fa-angle-double-right pull-right"> </i></td>
                                      <td> {{ x.userId }} </td>
                                      <td> {{ x.userName }} </td>
                                      <td> {{ x.email }} </td>
                                      <td> {{ x.phone }} </td>
                                      <td> {{ x.roles }} </td>

                                      <td align="center"> <a href ='#' ng-click="editUser(x.userId)" > <i class="fa fa-edit"> </i> </a>   </td>
                                      <td align="center"> <a href ='#' ng-click="delUser(x.userId)" ><i class="fa fa-trash"> </i> </a> </td>


                                    </tr>
                                 </table>

                            </div>



                         </div>

                    

                          <!-- 2nd TAB PILLS -->
                          <div id="sec_menu" class="tab-pane fade in" role="tabpanel">

                          <br/>


                           <div ng-controller="otherUsersCtrl">

                               <div style="color:red; font-weight: bolder;" ng-cloak> {{ otherUserDeleteResponse }} </div><br/>

                                  <table align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                                    <tr>
                                       <th> </th>
                                       <th> USER ID </th>
                                       <th> NAME </th>
                                       <th> EMAIL  </th>
                                       <th> PHONE </th>
                                       <th> ROLE </th>
                                       <th> EDIT </th>
                                       <th> DELETE  </th>
                                    </tr>

                                    <tr ng-repeat="x in otherusers">
                                      <td > <i class="fa fa-angle-double-right pull-right"> </i></td>
                                      <td> {{ x.userId }} </td>
                                      <td> {{ x.userName }} </td>
                                      <td> {{ x.email }} </td>
                                      <td> {{ x.phone }} </td>
                                      <td> {{ x.roles }} </td>

                                      <td align="center"> <a href ='#' ng-click="editOtherUser(x.userId)" > <i class="fa fa-edit"> </i> </a>   </td>
                                      <td align="center"> <a href ='#' ng-click="delOtherUser(x.userId)" ><i class="fa fa-trash"> </i> </a> </td>


                                    </tr>
                                 </table>

                            </div>

                   

                    </div>
                
             </div><!--Tab Content-->

         </div><!-- X-content -->

      
      </div>
    </div>
  </div>

  <script src="../vendors/angularJs/angular.min.js"></script>
  <!--<script src="../vendors/angularJs/angular-route.min.js"></script>-->
  <script type="text/javascript" src="../vendors/angularJs/ui-bootstrap-tpls-2.5.0.min.js"></script>

<script type="text/javascript">
  
  var app = angular.module('editApp',['ui.bootstrap']);

  app.controller('adminUsersCtrl', ['$scope', '$http', '$uibModal', '$rootScope', function($scope, $http, $uibModal, $rootScope){

    $http.get("../production/ajax_calls/json_ng_admin_users_call").then(function(response){

      $scope.users = response.data.userlist;  
    });

  //Function to delete an Admin User
    $scope.delUser = function(userId)
    {
      var conf = confirm('Are you sure you want to delete this user?');

          if(conf == true)
          {
             $http({

                  type: 'GET',
                  url:  '../production/ajax_calls/ng_delete_admin_user',
                  params: {deleteItem: userId},
                  headers: { 'Accept': 'application/json, text-plain' },

                  }).then(function successCallback(response){ 

                      $scope.adminUserDeleteResponse = response.data; //Delete Response 

                      //Then reload the controller call again
                          $http.get("../production/ajax_calls/json_ng_admin_users_call").then(function(response){ $scope.users = response.data.userlist;  });                     
                      },

                      function errorCallback(response){ $scope.adminUserDeleteResponse = response.statusText; });             
             
          }
    };


          //Call Bootstrap Modal Here and pass edit value
      $scope.editUser = function(id)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_edit_admin_user?userid=' + id,
                controller: 'editUserCtrl',
                backdrop: 'static',               
                resolve: { editId: function () { return id; } }
          });

      };

     $rootScope.$on('updateUserCtrl', function(event, args)
      {
         $scope.users = args;
         console.log($scope.users);
          
      });  
      

  }]).controller('editUserCtrl', ['$scope', '$http', '$uibModalInstance', 'editId', '$rootScope', function($scope, $http, $uibModalInstance, editId, $rootScope){

     //$scope.editFeeId = editId;

     //When Modal is Closed
      $scope.close = function(){ 
      $uibModalInstance.close(false);

      //Then reload the controller call again
      $http.get("../production/ajax_calls/json_ng_admin_users_call").then(function(response)
        { 
          //Now, instead of passing the response into a scope, use the $emit to pass the value from the Modal controller back to the previous controller
          $rootScope.$emit('updateUserCtrl', response.data.userlist );  

        });      
         
      };

      //When the Save Edit Button is clicked
     $scope.saveEdit = function(isValid){ 

    if(isValid){
             
             //Form Parameters
             var usrid = $scope.userId;
             var usrname = $scope.name;
             var email = $scope.email;
             var phone = $scope.phone;
             var roleid = $scope.roleId;
             var secure = $scope.secure;
             var merchid = $scope.merchId;
            
              
              //Prepare json data to be sent
               var sendData = {'userId': usrid, 'username': usrname, 'userEmail': email, 'userPhone': phone, 'role': roleid, 'secureCode': secure, 'merchantid': merchid};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_edit_admin_users',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.editUserResult = response.data; console.log(response); },

                          function errorCallback(response){ $scope.editUserResult = response.statusText; console.log(response); });
                  }
           };

  }]).controller('otherUsersCtrl', ['$http', '$scope', '$rootScope', '$uibModal', function($http, $scope, $rootScope, $uibModal){

    $http.get("../production/ajax_calls/json_ng_other_users_call").then(function(response){   $scope.otherusers = response.data.userlist;    });


    //Function to delete an Admin User
    $scope.delOtherUser = function(userId)
    {
      var conf = confirm('Are you sure you want to delete this user?');

          if(conf == true)
          {
             $http({

                  type: 'GET',
                  url:  '../production/ajax_calls/ng_delete_other_user',
                  params: {deleteItem: userId},
                  headers: { 'Accept': 'application/json, text-plain' },

                  }).then(function successCallback(response){ 

                      $scope.otherUserDeleteResponse = response.data; //Delete Response 

                      //Then reload the controller call again
                          $http.get("../production/ajax_calls/json_ng_other_users_call").then(function(response){ $scope.otherusers = response.data.userlist;  });                     
                      },

                      function errorCallback(response){ $scope.otherUserDeleteResponse = response.statusText; });             
             
          }
    };


          //Call Bootstrap Modal Here and pass edit value
      $scope.editOtherUser = function(id)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_edit_other_user?userid='+ id,
                controller: 'editOtherUserCtrl',
                backdrop: 'static',               
                resolve: { editId: function () { return id; } }
          });

      };

      $rootScope.$on('updateOtherUserCtrl', function(event, args)
      {
         $scope.otherusers = args;
          
      });  

  }]).controller('editOtherUserCtrl', ['$scope', '$http', '$uibModalInstance', 'editId', '$rootScope', function($scope, $http, $uibModalInstance, editId, $rootScope){

     //$scope.editFeeId = editId;

     //When Modal is Closed
      $scope.close = function(){ 
      $uibModalInstance.close(false);

      //Then reload the controller call again
      $http.get("../production/ajax_calls/json_ng_other_users_call").then(function(response)
        { 
          //Now, instead of passing the response into a scope, use the $emit to pass the value from the Modal controller back to the previous controller
          $rootScope.$emit('updateOtherUserCtrl', response.data.userlist );  

        });      
         
      };

      //When the Save Edit Button is clicked
     $scope.saveEdit = function(isValid){ 

    if(isValid){

             $scope.edit_loading = true;
             $scope.edit_result = false;
             
             //Form Parameters
             var usrid = $scope.userId;
             var usrname = $scope.name;
             var email = $scope.email;
             var phone = $scope.phone;
             var roleid = $scope.roleId;
             var secure = $scope.secure;
             var merchid = $scope.merchId;

             var progid = $scope.progId; 
             var cat = $scope.category;  
             var lev = $scope.level; 
             var nat = $scope.nationality;

              
              //Prepare json data to be sent
               var sendData = {'userId': usrid, 'username': usrname, 'userEmail': email, 'userPhone': phone, 'role': roleid, 'secureCode': secure, 'merchantid': merchid, 'prog': (progid) ? progid: null, 'categ': (cat) ? cat: null, 'levl': (lev) ? lev: null, 'national': (nat) ? nat: null };

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_edit_other_user',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.editUserResult = response.data; console.log(response); },

                          function errorCallback(response){ $scope.editUserResult = response.statusText; console.log(response); }).catch(function(err){ $scope.editUserResult = err; }).finally(function(){ $scope.edit_loading = false; $scope.edit_result = true; });
                  }
           };

    }]);

    angular.element(function() {
    angular.bootstrap(document.getElementById('edit_user'), ['editApp']);
  });

</script>

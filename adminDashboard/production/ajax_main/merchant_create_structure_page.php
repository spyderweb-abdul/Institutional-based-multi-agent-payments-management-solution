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

  <div class="row" id="structure">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
                  
                <div class="x_title">
                    <h4><i class="fa fa-wrench"> </i> Merchant Structure Profiling - <small> Structure Setup </small></h4>
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
                          <li class="active"><a data-toggle="pill" href="#menu" role="tab"> <i class="fa fa-folder-open"></i> CREATE FACULTY/SECTION </a></li>
                          <li><a data-toggle="pill" href="#sec_menu" role="tab"> <i class="fa fa-file-o"></i> CREATE DEPARTMENT </a></li>
                          <li><a data-toggle="pill" href="#third_menu" role="tab"> <i class="fa fa-list"></i> CREATE PROGRAMME </a></li>
                        </ul>
                     
              
                  <div class="tab-content">
                          
                          <!-- 1st TAB PILLS -->
            <div id="menu" class="tab-pane fade in active" role="tabpanel">

              <br/>

                <div ng-controller="facCtrl"><!-- ng-controller -->

                              <div ng-if="faculty_proc" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>

                                <div style="color:red; font-weight: bolder;" ng-if="faculty_res" ng-cloak> {{ facultyInputResult  }} </div><br/>

                              <table width="55%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                                <tr>
                                  <td colspan="4">

                                    <form class="form-horizontal form-label-left input_mask" name="structureFaculty" novalidate>

                                         <div class="row">
                                            <div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
                                                <input type="text" class="form-control has-feedback-left" placeholder="Insert Faculty Name" name="facultyName" ng-model="facultyName" required ng-required="true" >
                                                <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                                 <div ng-show="structureFaculty.$submitted || structureFaculty.facultyName.$touched">
                                                  <div style="color: red;" ng-show="structureFaculty.facultyName.$error.required"> *Faculty/Section Name is Required </div>
                                                </div>
                                            </div> 

                                            <input type="hidden" class="form-control has-feedback-left" name="merchantId" ng-model="merchantId" ng-init="merchantId='<?php echo $merchantId; ?>'">

                                            <button type="button" style="margin-left: 9px;" class="btn btn-success" ng-disabled="structureFaculty.$invalid" ng-click="submitFacPost(structureFaculty.$valid)" ><i class="fa fa-save"></i> Create Faculty/Section </button>                               

                                          </div>                                  
                                    </form>

                                  </td>
                                </tr>

                                <tr><td colspan="4">
                                  
                                   <div class="form-group has-feedback">
                                   <input type="text" name="facFilter" ng-model="facFilter" class="form-control" placeholder="Insert Faculty Name to Filter"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>

                                </td></tr>

                                <tr>
                                  <th> </th>
                                  <th> Faculty/Section </th>
                                  <th> Edit </th>
                                  <th> Delete </th>
                                </tr>

                                <tr ng-repeat="x in faclist | filter : facFilter">
                                 <td > <i class="fa fa-angle-double-right pull-right"> </i></td>
                                 <td> {{ x.faculty }} </td>
                                 <td> <a href ='#' ng-click="editFac(x.facId)" > <i class="fa fa-edit"> </i> </a>   </td>
                                 <td> <a href ='#' ng-click="delFac(x.facId)" ><i class="fa fa-trash"> </i> </a> </td>
                               </tr>


                              </table>


                        </div><!-- ng-controller ends -->

                   </div>

                    

                        <!-- 2nd TAB PILLS -->
                        <div id="sec_menu" class="tab-pane fade in" role="tabpanel">

                        <br/>
                         
                         <div ng-controller="deptCtrl">

                            <div ng-if="dept_proc" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>

                              <div style="color:red; font-weight: bolder;" ng-if="dpet_res" ng-cloak> {{ departmentInputResult  }} </div><br/>

                             <table width="50%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                                <tr>
                                  <td colspan="5">

                                     <form class="form-horizontal form-label-left input_mask" name="structureDepartment" novalidate>

                                       <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                                                <!-- <select ng-options="x as x.faculty for x in facDrop track by x.facId" name="selFac" ng-model="selFac" class="form-control has-feedback-left" required ng-required="true" > -->
                                                <select  name="selFac" ng-model="selFac" class="form-control has-feedback-left" required ng-required="true" >
                                                 <option value=""> - Select Faculty/Section - </option>
                                                 <option  ng-repeat="x in facDrop" ng-value="{{ x.facId }}"> {{ x.faculty }} </option>
                                                
                                                 </select>
                                                  <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                                  <div ng-show="structureDepartment.$submitted">
                                                   <div style="color: red;" ng-show="structureDepartment.selFac.$error.required"> *Select a Faculty/Section </div>
                                                  </div>
                                        </div>
                                       </div>

                                       <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                                            <input type="text" class="form-control has-feedback-left" placeholder="Insert Department Name" name="deptName" ng-model="deptName" required ng-required="true" >
                                            <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                            <div ng-show="structureDepartment.$submitted || structureDepartment.deptName.$touched">
                                              <div style="color: red;" ng-show="structureDepartment.deptName.$error.required"> *Department Name is Required </div>
                                            </div>
                                        </div>                            
                                      </div>

                                      <div class="row">
                                       <div class="col-md-4 col-sm-4 col-xs-12">

                                        <input type="hidden" class="form-control has-feedback-left" name="merchantId" ng-model="merchantId" ng-init="merchantId='<?php echo $merchantId; ?>'">

                                            <button type="button" class="btn btn-success" ng-disabled="structureDepartment.$invalid" ng-click="submitDeptPost(structureDepartment.$valid)" ><i class="fa fa-save"></i> Create Department </button> 

                                       </div>
                                      </div>

                                     </form>

                                    </td>
                                </tr>
                                 

                                <tr><td colspan="5">
                                  
                                   <div class="form-group has-feedback">
                                   <input type="text" name="deptFilter" ng-model="deptFilter" class="form-control" placeholder="Insert Department Name to Filter"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>

                                </td></tr>


                                <tr>
                                  <th> </th>
                                  <th> Faculty/Section </th>
                                  <th> Department </th>
                                  <th> Edit </th>
                                  <th> Delete </th>
                                </tr>

                                <tr ng-repeat="x in deptlist | filter:deptFilter">
                                 <td > <i class="fa fa-angle-double-right pull-right"> </i></td>
                                 <td> {{x.faculty}} </td>
                                 <td> {{ x.department }} </td>
                                 <td> <a href ='#' ng-click="editDept(x.deptId)" > <i class="fa fa-edit"> </i> </a>   </td>
                                 <td> <a href ='#' ng-click="delDept(x.deptId)" ><i class="fa fa-trash"> </i> </a> </td>
                               </tr>


                              </table>

                            </div><!-- ng-controller ends -->

                        </div> <!-- Tab ends -->


                        <!-- 3rd TAB PILLS -->
                          <div id="third_menu" class="tab-pane fade in" role="tabpanel">

                            <br/>

                            <div ng-controller="progCtrl">

                              <div ng-if="prog_proc" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>

                              <div style="color:red; font-weight: bolder;" ng-if="prog_res" ng-cloak> {{ programmeInputResult  }} </div><br/>

                                   <table width="50%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                                      <tr>
                                        <td colspan="5">

                                        <form class="form-horizontal form-label-left input_mask" name="structureProgram" id="structureProgram">
                                             
                                          <div class="row">
                                              <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                                                      <!-- <select ng-options="x as x.faculty for x in facDrop track by x.facId" name="selFac" ng-model="selFac" class="form-control has-feedback-left" required ng-required="true" > -->
                                                  <select  name="selFaculty" ng-model="selFaculty" class="form-control has-feedback-left" required ng-required="true" ng-change="deptOpt()" >
                                                       <option value=""> - Select Faculty/Section - </option>
                                                       <option  ng-repeat="x in facDrop" ng-value="{{ x.facId }}"> {{ x.faculty }} </option>
                                                      
                                                       </select>
                                                        <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                                        <div ng-show="structureProgram.$submitted">
                                                         <div style="color: red;" ng-show="structureProgram.selFaculty.$error.required"> *Select a Faculty/Section </div>
                                                        </div>
                                              </div>
                                            </div>

                                            <div class="row">
                                              <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">

                                                    <select  name="selDept" ng-model="selDept" class="form-control has-feedback-left" required ng-required="true">
                                                       <option value=""> - Select Department - </option>
                                                       <option  ng-repeat="x in deptDrop" ng-value="{{ x.deptId }}"> {{ x.department }} </option>
                                                      
                                                       </select>
                                                        <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                                        <div ng-show="structureProgram.$submitted">
                                                         <div style="color: red;" ng-show="structureProgram.selDept.$error.required"> *Select a Department </div>
                                                        </div>
                                              </div>
                                            </div>

                                             <div class="row">
                                              <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                                                  <input type="text" class="form-control has-feedback-left" placeholder="Insert Programme Name" name="programme" ng-model="programme" required ng-required="true" >
                                                  <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                                  <div ng-show="structureProgram.$submitted || structureProgram.programme.$touched">
                                                    <div style="color: red;" ng-show="structureProgram.programme.$error.required"> *Programme Name is Required </div>
                                                  </div>
                                              </div>                            
                                            </div>

                                            <div class="row">
                                             <div class="col-md-4 col-sm-4 col-xs-12">

                                              <input type="hidden" class="form-control has-feedback-left" name="merchantId" ng-model="merchantId" ng-init="merchantId='<?php echo $merchantId; ?>'">

                                                  <button type="button" class="btn btn-success" ng-disabled="structureProgram.$invalid" ng-click="submitProgPost(structureProgram.$valid)" ><i class="fa fa-save"></i> Create Programme </button> 

                                             </div>
                                            </div>                         
                                                                       
                                      </form>

                                  </td>
                                </tr>


                                <tr><td colspan="5">
                                  
                                   <div class="form-group has-feedback">
                                   <input type="text" name="progFilter" ng-model="progFilter" class="form-control" placeholder="Insert Programme Name to Filter"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>

                                </td></tr>

                                <tr>
                                  <th> </th>
                                  <th> Department </th>
                                  <th> Programme </th>
                                  <th> Edit </th>
                                  <th> Delete </th>
                                </tr>

                                <tr ng-repeat="x in proglist | filter : progFilter">
                                 <td > <i class="fa fa-angle-double-right pull-right"> </i></td>
                                 <td> {{ x.department }} </td>
                                 <td> {{ x.programme }} </td>
                                 <td> <a href ='#' ng-click="editProg(x.progId)" > <i class="fa fa-edit"> </i> </a>   </td>
                                 <td> <a href ='#' ng-click="delProg(x.progId)" ><i class="fa fa-trash"> </i> </a> </td>
                               </tr>


                              </table>

                          </div><!-- ng-controller ends -->

                         </div> <!-- Tab Ends -->
                
             </div><!--Tab Content-->

         </div><!-- X-content -->

      
      </div>
    </div>
  </div>



<script src="../vendors/angularJs/angular.min.js"></script>
<!--<script src="../vendors/angularJs/angular-route.min.js"></script>-->
<script type="text/javascript" src="../vendors/angularJs/ui-bootstrap-tpls-2.5.0.min.js"></script>

<script type="text/javascript">
  
 

  // ---------- AngularJS filter script ---------------------------------//
var app = angular.module("merchantStructure", ['ui.bootstrap']);


app.controller("facCtrl", ['$scope', '$http', '$rootScope', '$uibModal', function($scope, $http, $rootScope, $uibModal){

$http.get('../production/ajax_calls/json_faculty_list_call').then(function(response){ $scope.faclist = response.data.facultyList });

//Listener to calls to reload the Faculty list controller when a new faculty is created
$rootScope.$on('updateFacultyCtrl', function(event, arg){

  $scope.faclist = arg;

});

//Create New Faculty
  $scope.submitFacPost = function(isValid){ 

    if(isValid){

         $scope.faculty_proc = true;
         $scope.faculty_res = false;

             var fac = $scope.facultyName;
             var merchid = $scope.merchantId;
              
               var sendData = {'faculty': fac, 'merchantId': merchid};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_create_merchant_faculty',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response)

                          { 
                            $scope.facultyInputResult = response.data; 
                           
                            //Reload the faculty list controller
                            $http.get('../production/ajax_calls/json_faculty_list_call').then(function(response){ 
                             
                              //rootScope when faculty is updated
                              $rootScope.$emit('updateFacultyCtrl', response.data.facultyList);
                              
                              //rootScope to update the Faculty dropdown on department tab immediately a new faculty is created
                              $rootScope.$broadcast('updateDeptCtrl', response.data.facultyList);


                              //rootScope to update the Faculty dropdown on programme tab immediately a new faculty is created
                              $rootScope.$broadcast('updateProgCtrl', response.data.facultyList);


                              });                        
                            
                           },

                          function errorCallback(response){ $scope.facultyInputResult = response.statusText; }).catch(function(err){ $scope.facultyInputResult = err; }).finally(function(){ $scope.faculty_proc = false; $scope.faculty_res = true; });
                  }

 };

 //Delete a faculty
 //The ng-click function here to delete faculty
      $scope.delFac = function(facid)
      {
        var r = confirm('Are you sure you want to delete this faculty? Note! All departments associated with this faculty will be deleted.');
        if(r == true)
        {
           //var jsonData = JSON.stringify({cmdelete: feeID});

           $scope.faculty_proc = true;
           $scope.faculty_res = false;

          //Start Ajax call here
           $http({

                  type: 'GET',
                  url:  '../production/ajax_calls/ng_delete_faculty',
                  params: {cmdelete: facid},
                  headers: { 'Accept': 'application/json, text-plain' },

                  }).then(function successCallback(response){ 

                      $scope.facultyInputResult = response.data; //Delete Response 

                      //Then reload the controller call again
                      $http.get('../production/ajax_calls/json_faculty_list_call').then(function(response){ 
                        $scope.faclist = response.data.facultyList

                        //rootScope to update faculty on department tab when faculty is deleted
                        $rootScope.$emit('updDeptCtrl', response.data.facultyList); 

                        //rootScope to update faculty on programme tab when faculty is deleted
                        $rootScope.$broadcast('updProgCtrl', response.data.facultyList); 

                      });

                        //Populate department list controller when page loads
                        $http.get('../production/ajax_calls/json_department_list_call').then(function(response) { $rootScope.$emit('updateDeptTable', response.data.departmentList); });

                      },

                      function errorCallback(response){ $scope.facultyInputResult = response.statusText; }).catch(function(err){ $scope.facultyInputResult = err; }).finally(function(){ $scope.faculty_proc = false; $scope.faculty_res = true; });;             
             
        }         
        
      }; 

      //Edit Faculty Name. Call Bootstrap Modal Here and pass edit value
      $scope.editFac = function(facid)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_edit_faculty?facid=' + facid,
                controller: 'editFacultyCtrl',
                backdrop: 'static',              
                resolve: { editId: function () { return facid; } }
          });

      };

      //Listener to update Faculty List controller from on close of boostrap modal
      $rootScope.$on('updFacCtrl', function(event, args){

        $scope.faclist = args;

      });   
      

}]).controller('editFacultyCtrl', ['$scope', '$uibModalInstance', '$http', 'editId', '$rootScope', function($scope, $uibModalInstance, $http, editId, $rootScope){


   // $scope.editFacId = editId;

     //When Modal is Closed
      $scope.close = function(){ 
      $uibModalInstance.close(false);

      //Then reload the controller call again after modal close
      $http.get("../production/ajax_calls/json_faculty_list_call").then(function(response){ $rootScope.$emit('updFacCtrl', response.data.facultyList ); });

      //rootScope to update faculty dropdown in the department tab when a faculty name is edited and saved
      $http.get("../production/ajax_calls/json_faculty_list_call").then(function(response){ $rootScope.$broadcast('updFacOnDeptCtrl', response.data.facultyList ); });

      //rootScope to update faculty dropdown in the programme tab when a faculty name is edited and saved
      $http.get("../production/ajax_calls/json_faculty_list_call").then(function(response){ $rootScope.$emit('updFacOnProgCtrl', response.data.facultyList ); });
           
      };
      
      //Save update from Modal edit
      $scope.saveFacEdit = function(isValid){

         if(isValid){
             
             //Form Parameters
             var fac = $scope.faculty;
             var facID = $scope.facId;
              
              //Prepare json data to be sent
               var sendData = {'faculty': fac, 'facID': facID};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_update_faculty',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ 

                              $scope.editFacultyResult = response.data;
                              
                         },

                          function errorCallback(response){ $scope.editFacultyResult = response.statusText; });
                  }

      };

}]).controller('deptCtrl', ['$scope', '$http', '$rootScope', '$uibModal', function($scope, $http, $rootScope, $uibModal){

    //Populate department list controller when page loads
    $http.get('../production/ajax_calls/json_department_list_call').then(function(response) { $scope.deptlist = response.data.departmentList });

    //Populate faculty list in the dropdown box on department tab
    $http.get('../production/ajax_calls/json_faculty_list_call_select').then(function(response){ $scope.facDrop = response.data.facList });


    //Listener to rootScope to update faculty when a faculty name is saved after update.
    $rootScope.$on('updFacOnDeptCtrl', function(event, e){

       $scope.facDrop = e;

    });

    //$rootscope to update the faculty dropdown when a new faculty is created. It's a listener 
    $rootScope.$on('updateDeptCtrl', function(event, param){

      $scope.facDrop = param;

    });

    //$rotScope to update the faculty dropdown when a faculty is deleted. It's a listener
    $rootScope.$on('updDeptCtrl', function(event, r){
      
      $scope.facDrop = r;

    });

     //The listener $rootscope to re-populate the department table. 
    $rootScope.$on('updateDeptTable', function(e, a){ $scope.deptlist = a; });

  //Create New Department
  $scope.submitDeptPost = function(isValid){ 

    if(isValid){

          $scope.dept_proc = true;
          $scope.dpet_res = false;

             var facId = $scope.selFac;
             var dept = $scope.deptName;
             var merchid = $scope.merchantId;
              
               var sendData = {'facid': facId, 'department': dept, 'merchantId': merchid};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_create_merchant_department',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response)

                          { 
                            $scope.departmentInputResult = response.data; 
                           
                            //Reload the department list controller
                            $http.get('../production/ajax_calls/json_department_list_call').then(function(response){ 

                              $scope.deptlist = response.data.departmentList;

                              });                        
                            
                           },

                          function errorCallback(response){ $scope.departmentInputResult = response.statusText; }).catch(function(err){ $scope.departmentInputResult = err; }).finally(function(){ $scope.dept_proc = false; $scope.dept_res = true; });;
                  }
      };

      //Delete a department
      //The ng-click function here to delete department
      $scope.delDept = function(deptid)
      {
        var r = confirm('Are you sure you want to delete this department? Note! All programmes associated with this department will be deleted.');
        if(r == true)
        {

          $scope.dept_proc = true;
          $scope.dept_res = false;

          //Start Ajax call here
           $http({

                  type: 'GET',
                  url:  '../production/ajax_calls/ng_delete_department',
                  params: {cmdelete: deptid},
                  headers: { 'Accept': 'application/json, text-plain' },

                  }).then(function successCallback(response){ 

                      $scope.departmentInputResult = response.data; //Delete Response 

                     //Reload the department list controller
                      $http.get('../production/ajax_calls/json_department_list_call').then(function(response){ 

                         $scope.deptlist = response.data.departmentList;

                      });
                      

                      //$rootScope to update programme table when the corrensponding department is deleted
                        $http.get('../production/ajax_calls/json_programme_list_call').then(function(response){ $rootScope.$emit('updateProgTable',  response.data.programmeList); });
                      
                      },

                      function errorCallback(response){ $scope.departmentInputResult = response.statusText; }).catch(function(err){ $scope.departmentInputResult = err; }).finally(function(){ $scope.dept_proc = false; $scope.dept_res = true; });;            
             
        }         
        
      }; 

      //Edit Department Name. Call Bootstrap Modal Here and pass edit value
      $scope.editDept = function(id)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_edit_department?deptid=' + id,
                controller: 'editDepartmentCtrl', 
                backdrop: 'static',              
                resolve: { eId: function () { return id; } }
          });

      };
     
     //Listener to update Department List when a department name is updated
      $rootScope.$on('updDepCtrl', function(event, i){

        $scope.deptlist = i;

      });

}]).controller('editDepartmentCtrl', ['$scope', '$http', '$uibModalInstance', 'eId', '$rootScope', function($scope, $http, $uibModalInstance, eId, $rootScope){

  // $scope.editDeptId = eId;

  //Close Department Modal 
   $scope.close = function(){
  
      $uibModalInstance.close(false);

    //Then reload the controller call again after modal close
    $http.get("../production/ajax_calls/json_department_list_call").then(function(response){ $rootScope.$emit('updDepCtrl', response.data.departmentList ); });
          
   };

     //Save department name edit from Modal edit
      $scope.saveDeptEdit = function(isValid){

         if(isValid){
             
             //Form Parameters
             var dept = $scope.department;
             var deptID = $scope.deptId;
              
              //Prepare json data to be sent
               var sendData = {'department': dept, 'deptID': deptID};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_update_department',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.editDepartmentResult = response.data; },

                          function errorCallback(response){ $scope.editDepartmentResult = response.statusText; });
                  }

      };

}]).controller('progCtrl', ['$scope', '$http', '$uibModal', '$rootScope', function($scope, $http, $uibModal, $rootScope){


  $http.get('../production/ajax_calls/json_programme_list_call').then(function(response){ $scope.proglist = response.data.programmeList; console.log(response); });

       //Listener rootScope to update faculty dropdown on programme tab when a new is created
       $rootScope.$on('updateProgCtrl', function(event, g){
         $scope.facDrop = g;
       });

       //listener rootScope to update faculty dropdown on programme tab when faculty is deleted.
       $rootScope.$on('updProgCtrl', function(event, x){       
         $scope.facDrop = x;
       });

       //Listener rootScope to update faculty dropdown on  programme tab when faculty name is edited.
       $rootScope.$on('updFacOnProgCtrl', function(event, y){
         $scope.facDrop = y;
       });

       //Listener to re-populate the programme table when a department is deleted
       $rootScope.$on('updateProgTable', function(e, a) { $scope.proglist = a; });

   //Populate faculty list in the dropdown box on programme tab
    $http.get('../production/ajax_calls/json_faculty_list_call_select').then(function(response){ $scope.facDrop = response.data.facList });

    //To populate department dropdown when a faculty selection is made
    $scope.deptOpt = function(){
         
              var facid = $scope.selFaculty;

              var sendData = {'fID': facid};

               $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/json_pop_department_list_call',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.deptDrop = response.data.departmentList; },

                          function errorCallback(response){ $scope.departmentInputResult = response.statusText; 
                  });
    };


     //Create New Department
  $scope.submitProgPost = function(isValid){ 

    if(isValid){

           $scope.prog_proc = true;
           $scope.prog_res = false;

             var facId = $scope.selFaculty;
             var deptId = $scope.selDept;
             var prg = $scope.programme;
             var merchid = $scope.merchantId;
              
               var sendData = {'facultyId': facId, 'departmentId': deptId, 'prog': prg, 'merchantId': merchid};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_create_merchant_programme',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response)

                          { 
                            $scope.programmeInputResult = response.data; 
                           
                            //Reload the department list controller
                            $http.get('../production/ajax_calls/json_programme_list_call').then(function(response){ 

                              $scope.proglist = response.data.programmeList;

                              });                        
                            
                           },

                          function errorCallback(response){ $scope.programmeInputResult = response.statusText; }).catch(function(err){ $scope.programmeInputResult = err; }).finally(function(){ $scope.prog_proc = false; $scope.prog_res = true; });;
                  }
      };

      //Delete a progamme
      //The ng-click function here to delete programme
      $scope.delProg = function(progid)
      {
        var r = confirm('Are you sure you want to delete this programme?');
        if(r == true)
        {

          $scope.prog_proc = true;
          $scope.prog_res = false;

          //Start Ajax call here
           $http({

                  type: 'GET',
                  url:  '../production/ajax_calls/ng_delete_programme',
                  params: {cmdelete: progid},
                  headers: { 'Accept': 'application/json, text-plain' },

                  }).then(function successCallback(response){ 

                      $scope.programmeInputResult = response.data; //Delete Response 

                     //Reload the programme list controller
                      $http.get('../production/ajax_calls/json_programme_list_call').then(function(response){ 

                         $scope.proglist = response.data.programmeList

                      });
                      
                      },

                      function errorCallback(response){ $scope.programmeInputResult = response.statusText; }).catch(function(err){ $scope.programmeInputResult = err; }).finally(function(){ $scope.prog_proc = false; $scope.prog_res = true; });;            
             
        }         
        
      }; //

      //Edit Programme Name. Call Bootstrap Modal Here and pass edit value
      $scope.editProg = function(id)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_edit_programme?progid=' + id,
                controller: 'editProgrammeCtrl', 
                backdrop: 'static',              
                resolve: { prgId: function () { return id; } }
          });

      };

   //Listener to the $rootSope call to reload programme list controller when the Modal Pop up is closed
   $rootScope.$on('prgCtrl', function(e, a){
    
       $scope.proglist = a;

   })

}]).controller('editProgrammeCtrl', ['$scope', '$http', '$uibModalInstance', 'prgId', '$rootScope', function($scope, $http, $uibModalInstance, prgId, $rootScope){

    //$scope.editProgId = prgId;
   $scope.close = function(){

     $uibModalInstance.close(false);
     
     //$rootScope to recall the programme list controller when a programme name is edited from the Modal Pop Up
     $http.get('../production/ajax_calls/json_programme_list_call').then(function(response){ $rootScope.$emit('prgCtrl', response.data.programmeList) });
   };


   //Save Programme name edit from Modal edit
      $scope.saveProgEdit = function(isValid){

         if(isValid){
             
             //Form Parameters
             var prg = $scope.programme;
             var progid = $scope.progId;
              
              //Prepare json data to be sent
               var sendData = {'programme': prg, 'progID': progid};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_update_programme',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.editProgrammeResult = response.data; },

                          function errorCallback(response){ $scope.editProgrammeResult = response.statusText; });
                  }

      };

}]);    


    

 angular.bootstrap(document.getElementById('structure'), ['merchantStructure']);



</script>
        
</body></html>
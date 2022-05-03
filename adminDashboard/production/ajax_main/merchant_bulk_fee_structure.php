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

  <div class="row" id="bulkFeeSetup">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
                  
                <div class="x_title">
                    <h4><i class="fa fa-wrench"> </i> Bulk Fee Setup - <small> Fee Setup </small></h4>
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
                          <li class="active"><a data-toggle="pill" href="#menu" role="tab"> <i class="fa fa-shopping-cart"></i> CREATE FEE ITEMS </a></li>
                          <li><a data-toggle="pill" href="#sec_menu" role="tab"> <i class="fa fa-edit"></i> DELETE/EDIT FEE ITEMS </a></li>
                          <li><a data-toggle="pill" href="#third_menu" role="tab"> <i class="fa fa-university"></i> BUILD FEE STRUCTURE </a></li>
                        </ul>
                     
              
                  <div class="tab-content">
                          
                          <!-- 1st TAB PILLS -->
                      <div id="menu" class="tab-pane fade in active" role="tabpanel">

                                <br/>

                            <div ng-controller="bulkFeeItem"><!-- ng-controller -->


                          <div ng-if="fee_proc" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div> 

                                <div style="color:red; font-weight: bolder;" ng-if="fee_res" ng-cloak > {{ bulkFeeItemInputResult }} </div><br/>

                            <form class="form-horizontal form-label-left input_mask" name="bulkFeeItemForm" novalidate ng-cloak>
                                                                
                                 <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" placeholder="Insert Fee Item Name" name="feeItem" ng-model="feeItem" required ng-required="true" >
                                        <span class="fa fa-ellipsis-v form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="bulkFeeItemForm.$submitted || bulkFeeItemForm.feeItem.$touched">
                                          <div style="color: red;" ng-show="bulkFeeItemForm.feeItem.$error.required"> *Fee Item is Required </div>
                                        </div>
                                    </div>
                                   

                                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                       <input type="number" class="form-control has-feedback-left"  placeholder="Amount (e.g 10000)" name="feeAmount" ng-model="feeAmount" required ng-required="true" integer >
                                        <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="bulkFeeItemForm.$submitted || bulkFeeItemForm.feeAmount.$touched">
                                           <div style="color: red;" ng-show="bulkFeeItemForm.feeAmount.$error.integer"> *Amount Must be Integer </div> 
                                           <div style="color: red;" ng-show="bulkFeeItemForm.feeAmount.$error.required"> *Fee Amount is Required </div>
                                        </div>
                                    </div>
                                   

                                   <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                       <select name="reqScholarship" ng-model="reqScholarship" class="form-control has-feedback-left" required ng-required="true">
                                       <option value=""> - Scholarship Applied? - </option>
                                       <option value="YES"> YES </option>
                                       <option value="NO"> NO </option>
                                       </select>
                                        <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="bulkFeeItemForm.$submitted || bulkFeeItemForm.reqScholarship.$touched">
                                          <div style="color: red;" ng-show="bulkFeeItemForm.reqScholarship.$error.required"> *Select an Option </div>
                                        </div>
                                   </div>

                                  </div>

                                     <input type="hidden" class="form-control has-feedback-left" name="merchantId" ng-model="merchantId" ng-init="merchantId='<?php echo $merchantId; ?>'">
                                 
                                  
                                         <div class="ln_solid"></div>
                                                                 
                              

                                  <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                      <button class="btn btn-primary " type="reset" id="btn_bulk_fee_item_reset" ><i class="fa fa-times"></i> Reset</button>
                                      <button type="button" class="btn btn-success" ng-disabled="bulkFeeItemForm.$invalid" ng-click="submitForm(bulkFeeItemForm.$valid)" ><i class="fa fa-save"></i> Create Fee Item</button>
                                    </div>
                                  </div>

                             </form>

                                </div><!-- ng-controller ends -->

                         </div>

                    

                        <!-- 2nd TAB PILLS -->
                        <div id="sec_menu" class="tab-pane fade in" role="tabpanel">

                        <br/>
                       
                            <div ng-controller="filterController">

                                 <div style="color:red; font-weight: bolder;" ng-cloak> {{ feeItemDeleteResponse }} </div><br/>


                             <table width="60%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                               <tr>
                                 <td colspan="5">

                                 <form name="feeItemForm" ng-init="" class="form-horizontal form-label-left input_mask">
                                   <div class="form-group has-feedback">
                                   <input type="text" name="filt" ng-model="filters" class="form-control" placeholder="Insert Item Name to Filter"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>
                                 </form>
                                 
                                <!-- <span ng-show="!items.length"> No Match Found </span> -->
                                 </td>
                               </tr>
                               
                               <tr>
                                 <th> </th>
                                 <th> Fee Items </th>
                                 <th> Amount </th>
                                 <th> Edit </th>
                                 <th> Delete </th>
                               </tr>
                               
                               <!--<tr ng-repeat="x in items | filter:filters">-->
                                 <tr ng-repeat="x in items | filter:filters">
                                 <td > <i class="fa fa-angle-double-right pull-right"> </i></td>
                                 <td> {{ x.feeItem }} </td>
                                 <td> {{ x.amount | number }} </td>
                                 <td> <a href ='#' ng-click="editFee(x.feeID)" > <i class="fa fa-edit"> </i> </a>   </td>
                                 <td> <a href ='#' ng-click="feeNum(x.feeID)" ><i class="fa fa-trash"> </i> </a> </td>
                               </tr>
                                
                             </table>
                               
                            </div> 

                           <div class="ln_solid"></div>

                        </div>


                        <!-- 3rd TAB PILLS -->
                          <div id="third_menu" class="tab-pane fade in" role="tabpanel">

                            <br/>
                                                                
                                   <div ng-controller="feeStructureCtrl">

                                   <div style="color:red; font-weight: bolder;" ng-cloak> {{feeStructureInputResult}} </div><br/>


                                   <form class="form-horizontal form-label-left input_mask" name="feeStructureForm" id="feeStructureForm">

                                    <table width="80%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                                      <tr>
                                        <td colspan="3">
                                           
                                          
                                        <div class="row">
                                              
                                              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                                      <!-- <select ng-options="x as x.faculty for x in facDrop track by x.facId" name="selFac" ng-model="selFac" class="form-control has-feedback-left" required ng-required="true" > -->
                                                  <select  name="selFaculty" ng-model="selFaculty" class="form-control has-feedback-left" required ng-required="true" ng-change="deptOpt()" >
                                                       <option value=""> - Select Faculty - </option>
                                                       <option  ng-repeat="x in facDrop" ng-value="{{ x.facId }}"> {{ x.faculty }} </option>
                                                      
                                                       </select>
                                                        <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                                        <div ng-show="feeStructureForm.$submitted">
                                                         <div style="color: red;" ng-show="feeStructureForm.selFaculty.$error.required"> *Select a Faculty </div>
                                                        </div>
                                              </div>

                                               <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

                                                    <select  name="selDept" ng-model="selDept" class="form-control has-feedback-left" required ng-required="true" ng-change="progOpt()">
                                                       <option value=""> - Select Department - </option>
                                                       <option  ng-repeat="x in deptDrop" ng-value="{{ x.deptId }}"> {{ x.department }} </option>
                                                      
                                                       </select>
                                                        <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                                        <div ng-show="feeStructureForm.$submitted">
                                                         <div style="color: red;" ng-show="feeStructureForm.selDept.$error.required"> *Select a Department </div>
                                                        </div>
                                              </div>
                                          
                                          </div>

                                             <div class="row">

                                               <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

                                                    <select  name="selProg" ng-model="selProg" class="form-control has-feedback-left" required ng-required="true" >
                                                       <option value=""> - Select Programme - </option>
                                                       <option  ng-repeat="x in progDrop" ng-value="{{ x.progId }}"> {{ x.programme }} </option>
                                                      
                                                       </select>
                                                        <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                                        <div ng-show="feeStructureForm.$submitted">
                                                         <div style="color: red;" ng-show="feeStructureForm.selProg.$error.required"> *Select a Programme </div>
                                                        </div>
                                              </div>


                                               <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

                                                   <select  name="category" ng-model="category" class="form-control has-feedback-left" required ng-required="true">

                                                    <?php 
                                                    if($merchant_type == 'High School')
                                                    { ?>

                                                      <option value=""> - Select Student Category - </option>
                                                       <option value="3"> Pupil </option>
                                                       <option value="4"> Student </option>
                                                    <?php } else { ?>

                                                       <option value=""> - Select Student Category - </option>
                                                       <option value="1"> Undergraduate </option>
                                                       <option value="2"> Postgraduate </option>

                                                    <?php } ?>
                                                      
                                                    </select>
                                                    <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                                     <div ng-show="feeStructureForm.$submitted">
                                                         <div style="color: red;" ng-show="feeStructureForm.category.$error.required"> *Select Category </div>
                                                     </div>
                                               </div>

                                            </div>


                                             <div class="row">

                                               <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

                                                  <select  name="level" ng-model="level" class="form-control has-feedback-left" required ng-required="true">

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
                                                    <div ng-show="feeStructureForm.$submitted">
                                                      <div style="color: red;" ng-show="feeStructureForm.level.$error.required"> *Select Level </div>
                                                    </div>
                                               </div>

                                           <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                            <select  name="nationality" ng-model="nationality" class="form-control has-feedback-left" required ng-required="true">
                                                  <option value=""> - Select Nationality - </option>
                                                  <option value="1"> Local </option>
                                                  <option value="2"> Foreign </option>
                                                      
                                            </select>
                                              <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                                <div ng-show="feeStructureForm.$submitted">
                                                  <div style="color: red;" ng-show="feeStructureForm.nationality.$error.required"> *Select Nationality </div>
                                                </div>
                                            </div>

                                          </div>

                                            <div class="row">
                                             <div class="col-md-4 col-sm-4 col-xs-12">

                                              <input type="hidden" class="form-control has-feedback-left" name="merchantId" ng-model="merchantId" ng-init="merchantId='<?php echo $merchantId; ?>'">

                                                  
                                             </div>
                                            </div>                         
                                                                       
                               

                                      </td>
                                    </tr>


                                    <tr><td colspan="3">
                                      
                                       <div class="form-group has-feedback">
                                       <input type="text" name="feeFilter" ng-model="feeFilter" class="form-control" placeholder="Insert Fee Item Name to Filter"  />
                                       <i class="fa fa-search form-control-feedback"></i>
                                       </div>

                                    </td></tr>

                                    <tr>
                                      <th> </th>
                                      <th> Fee Item </th>
                                      <th> Amount </th>
           
                                    </tr>

                                    <tr ng-repeat="x in items | filter : feeFilter">
                                     
                                     <td > <input type="checkbox" value="{{x.feeID}}" style="height:auto; box-shadow:none; border:#CCC thin" ng-model="x.selected" />
                                     </td>
                                     <td> 
                                       <input type="text" name="feeItem" ng-model="x.feeItem" class="input-sm" style="border:thin #CCC; box-shadow:none;" readonly  /> 
                                      </td>
                                     <td> 
                                       <input type="text" name="amount" ng-model="x.amount" class="input-sm" style="border:thin #CCC; box-shadow:none;" readonly  />
                                     </td>
         
                                   </tr>

                                   <tr><td colspan="3"> 
                                    <button type="button" class="btn btn-success" ng-disabled="feeStructureForm.$invalid" ng-click="submitFeePost(feeStructureForm.$valid)" ><i class="fa fa-save"></i> Build Fee Structure </button> 
                                   </td></tr>


                            </table>

                         </form>

                            <br/>

                              <div style="color:red; font-weight: bolder;" ng-cloak> {{feeStructureInputResult}} </div><br/>


                          </div><!-- ng-controller ends -->                              
                                                                

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
  
 

  // ---------- AngularJS filter script ---------------------------------//
var app = angular.module("myApp",['ui.bootstrap']);

//For fee items entry
app.controller("bulkFeeItem", function($scope, $http, $rootScope){


  $scope.submitForm = function(isValid){ 

    if(isValid){

           $scope.fee_proc = true;
           $scope.fee_res = false;

             var feeitem = $scope.feeItem;
             var amount = $scope.feeAmount;
             var scholar = $scope.reqScholarship;
             var merchid = $scope.merchantId;
              
               var sendData = {'feeItem': feeitem, 'feeAmount': amount, 'reqScholarship': scholar, 'merchantId': merchid};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_create_bulk_fee_items',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ 

                            $scope.bulkFeeItemInputResult = response.data;

                            //Now, I want the filterController populating all fee items to be updated immediately a new fee item is created
                            $http.get("../production/ajax_calls/json_fee_items_call").then(function(response)
                            { 
                                $rootScope.$broadcast('updateFilterCtrl', response.data.records); 
                            });
                              
                            },
                       
                          function errorCallback(response){ $scope.bulkFeeItemInputResult = response.statusText; }).catch(function(err){ $scope.bulkFeeItemInputResult = err; }).finally(function(){ $scope.fee_proc = false; $scope.fee_res = true; });


                  }

 };

}).controller("filterController", ['$scope', '$http', '$uibModal', '$rootScope', function($scope, $http, $uibModal, $rootScope){
       
       //Populte all fee items available
       $http.get("../production/ajax_calls/json_fee_items_call").then(function(response){ $scope.items = response.data.records;  });

      //This $rootScope would automatically get the push from the fee item create controller. This code only executes if there's a new creation of fee item
       $rootScope.$on('updateFilterCtrl', function(event, arg){ $scope.items = arg; });

      //The ng-click function here to delete fees Item
      $scope.feeNum = function(feeID)
      {
        var r = confirm('Are you sure you want to delete?');
        if(r == true)
        {
           //var jsonData = JSON.stringify({cmdelete: feeID});

          //Start Ajax call here
           $http({

                  type: 'GET',
                  url:  '../production/ajax_calls/ng_delete_fee_items',
                  params: {cmdelete: feeID},
                  headers: { 'Accept': 'application/json, text-plain' },

                  }).then(function successCallback(response){ 

                      $scope.feeItemDeleteResponse = response.data; //Delete Response 

                      //Then reload the controller call again
                      $http.get("../production/ajax_calls/json_fee_items_call").then(function(response){ $scope.items = response.data.records;  });                     
                      },

                      function errorCallback(response){ $scope.feeItemDeleteResponse = response.statusText; });             
             
        }         
        
      };     
      
      //Call Bootstrap Modal Here and pass edit value
      $scope.editFee = function(id)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_edit_fee_item?feeid=' + id,
                controller: 'editFeeCtrl', 
                backdrop: 'static',             
                resolve: { editId: function () { return id; } }
          });

      };

     
    $rootScope.$on('updateFilterController', function(event, args)
      {
         $scope.items = args;
         console.log($scope.items);
          
      });      


}]).controller('editFeeCtrl', ['$scope', '$uibModalInstance', '$http', 'editId', '$rootScope', function($scope, $uibModalInstance, $http, editId, $rootScope){
  
     $scope.editFeeId = editId;

     //When Modal is Closed
      $scope.close = function(){ 
      $uibModalInstance.close(false);

      //Then reload the controller call again
      $http.get("../production/ajax_calls/json_fee_items_call").then(function(response){ $rootScope.$emit('updateFilterController', response.data.records); });
      
         
      };

     //When the Save Edit Button is clicked
     $scope.saveEdit = function(isValid){ 

    if(isValid){
             
             //Form Parameters
             var fitem = $scope.item;
             var famount = $scope.amount;
             var fscholar = $scope.scholarship;
             var feeid = $scope.feeID;
              
              //Prepare json data to be sent
               var sendData = {'feeItem': fitem, 'feeAmount': famount, 'scholarship': fscholar, 'feeId': feeid};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_edit_bulk_fee_items',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.editFeeResult = response.data; console.log(response); },

                          function errorCallback(response){ $scope.editFeeResult = response.statusText; console.log(response); });
                  }

           };

  }]).controller('feeStructureCtrl', ['$scope', '$http', '$uibModal', '$rootScope', function($scope, $http, $uibModal, $rootScope){

     //Populate faculty list in the dropdown box on programme tab
    $http.get('../production/ajax_calls/json_faculty_list_call_select').then(function(response){ $scope.facDrop = response.data.facList });


    //Populte all fee items available
    $http.get("../production/ajax_calls/json_fee_items_call").then(function(response){ $scope.items = response.data.records;  });

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


     //To populate programme dropdown when a department selection is made
    $scope.progOpt = function(){
         
            $scope.feeStructureInputResult = '';
              var deptid = $scope.selDept;

              var sendData = {'dID': deptid};

               $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/json_pop_programme_list_call',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.progDrop = response.data.programmeList; },

                          function errorCallback(response){ $scope.progDrop = response.statusText; 
                  });
    };

    $scope.submitFeePost = function(isValid){

      if(isValid){

                  var facid = $scope.selFaculty;
                  var deptid = $scope.selDept;
                  var progid = $scope.selProg;
                  var cat = parseInt($scope.category); //Convert value to integer from string
                  //var lev = parseInt($scope.level);      //Convert value to integer from string

                   var lev = $scope.level;      
                   var nat = parseInt($scope.nationality);  //Convert value to integer from string
                  var feeID = [];
                  //var merchid = $scope.merchantId;
                         
                  angular.forEach($scope.items, function(x){ if(x.selected) { feeID.push(x); }  });//Get Selected Items first

                  
                  var sumTotal = 0, display = "", arr = new Array();

                  display = "Kindly Confirm your selection before submission. Press OK if it's correct or CANCEL to discard" + "\n\n";

                  for (var key in feeID) //Loop through selected items
                  {
                    if(feeID.hasOwnProperty(key))
                    {
                      
                      display += feeID[key].feeItem + " - " + feeID[key].amount + "\n\n"; 
                      sumTotal += parseInt(feeID[key].amount);  //convert string to integer 

                       arr.push(feeID[key].feeID);  //Push into the new array only fee IDs        
                    }             
                  } 

                      display = display + "Total: " + sumTotal; 


                 //Prepare data to be sent for database submission
                 var sendData = {'feeId': arr, 'fId': facid, 'dId': deptid, 'pId': progid, 'catId': cat, 'levId': lev, 'natId': nat};

                 var r = confirm(display); //Pop Up Alert Confirmation Box
                 if( r == true){ //If user clicks Ok

                         $http({                         
                                method: 'POST',
                                url: '../production/ajax_calls/ng_build_fee_structure',
                                data: sendData,
                                headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                                }).then(function successCallback(response){ $scope.feeStructureInputResult = response.data;  },
                               
                                function errorCallback(response){ $scope.feeStructureInputResult = response.statusText;  });          
                           }
             };

         };

  }]);



 angular.bootstrap(document.getElementById('bulkFeeSetup'), ['myApp']);



</script>
        
</body></html>
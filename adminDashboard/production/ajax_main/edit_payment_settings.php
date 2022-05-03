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

  <div class="row" id="setup">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
                  
                <div class="x_title">
                    <h4><i class="fa fa-wrench"> </i> Merchant's Payment Codes - <small> Report </small></h4>
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
                          <li class="active"><a data-toggle="tab" href="#menu" role="tab"> <i class="fa fa-shopping-cart"></i> EDIT PAYMENT CHOICE </a></li>

                          <li><a data-toggle="pill" href="#sec_menu" role="tab"> <i class="fa fa-edit"></i> EDIT PAYMENT TYPE </a></li>

                          <li><a data-toggle="pill" href="#third_menu" role="tab"> <i class="fa fa-edit"></i> DELETE PAYMENT SETUP </a></li>
                          
                        </ul>


                     <div class="tab-content">
                          
                          <!-- 1st TAB PILLS -->
                      <div id="menu" class="tab-pane fade in active" role="tabpanel"> <br/>

                         <div ng-controller="choiceCtrl">

                           <div ng-if="choice_processing" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>


                              <div style="color:red; font-weight: bolder;" ng-cloak ng-if="choice_del_result"> {{ choiceDeleteResponse }} </div><br/>


                             <table width="60%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak style="font-size: 12px;">
                               <tr>
                                 <td colspan="8">

                                 <form name="choiceform" ng-init="" class="form-horizontal form-label-left input_mask">
                                   <div class="form-group has-feedback">
                                   <input type="text" name="filt" ng-model="filters" class="form-control" placeholder="Insert Choice Name to search"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>
                                 </form>
                                 
                                <!-- <span ng-show="!items.length"> No Match Found </span> -->
                                 </td>
                               </tr>
                               
                               <tr>
                                 <th> </th>
                                 <th > Payment Choice Name</th>
                                 <th > Require Fee Items? </th>
                                 <th > Edit </th>
                                 <th> Delete </th>
                               </tr>
                               
                               <tr ng-repeat="x in choices | filter:filters">
                                 <td > {{$index + 1}}</i></td>
                                 <td> {{x.choiceName}} </td>
                                 <td> {{x.req}} </td>
                                 <td> <a href="#" ng-click="editChoice(x.choiceId)"> <i class="fa fa-edit"> </i> </a> </td>
                                 <td> <a href="#" ng-click="delChoice(x.choiceId)"> <i class="fa fa-trash"> </i> </a></td>
                               </tr>
                                
                             </table>
                               
                         </div>  


                          <div class="ln_solid"></div>
                           
                      </div>    <!-- 1st Tab Ends -->

                     <!-- 2nd TAB PILLS -->
                     <div id="sec_menu" class="tab-pane fade in" role="tabpanel"> <br/>

                           <div ng-controller="typeCtrl">

                           <div ng-if="type_processing" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>


                              <div style="color:red; font-weight: bolder;" ng-cloak ng-if="type_del_result"> {{ typeDeleteResponse }} </div><br/>


                             <table width="50%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak style="font-size: 12px;">
                               <tr>
                                 <td colspan="8">

                                 <form name="typeform" ng-init="" class="form-horizontal form-label-left input_mask">
                                   <div class="form-group has-feedback">
                                   <input type="text" name="filt" ng-model="filters" class="form-control" placeholder="Insert Type Name to search"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>
                                 </form>
                                 
                                <!-- <span ng-show="!items.length"> No Match Found </span> -->
                                 </td>
                               </tr>
                               
                               <tr>
                                 <th> </th>
                                 <th > Payment Choice Name</th>
                                 <th> Payment Type Name </th>
                                 <th > Edit </th>
                                 <th> Delete </th>
                               </tr>
                               
                               <tr ng-repeat="x in types | filter:filters">
                                 <td > {{$index + 1}}</i></td>
                                 <td> {{x.choiceName}} </td>
                                 <td> {{x.typeName }} </td>
                                 <td> <a href="#" ng-click="editType(x.typeId)"> <i class="fa fa-edit"> </i> </a> </td>
                                 <td> <a href="#" ng-click="delType(x.typeId)"> <i class="fa fa-trash"> </i> </a></td>
                               </tr>
                                
                             </table>
                               
                         </div>  


                          <div class="ln_solid"></div>

                     </div><!-- 2nd Tab Ends -->

                    <!-- 3rd TAB PILLS -->
                    <div id="third_menu" class="tab-pane fade in" role="tabpanel"> <br/> 

                        <div ng-controller="setupCtrl">

                              <div ng-if="processing" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>


                              <div style="color:red; font-weight: bolder;" ng-cloak ng-if="del_result"> {{ setupDeleteResponse }} </div><br/>


                             <table width="80%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak style="font-size: 12px;">
                               <tr>
                                 <td colspan="8">

                                 <form name="setupform" ng-init="" class="form-horizontal form-label-left input_mask">
                                   <div class="form-group has-feedback">
                                   <input type="text" name="filt" ng-model="filters" class="form-control" placeholder="Insert Setup Name to search"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>
                                 </form>
                                 
                                 </td>
                               </tr>
                               
                               <tr>
                                 <th> </th>
                                 <th > Setup Name</th>
                                 <th > Setup Code </th>
                                 <th > Channel </th>
                                 <th > Service Type ID </th>
                                 <th > Is Payment Reprocessible? </th>
                                 <th> Delete </th>
                               </tr>
                               
                               <tr ng-repeat="x in setups | filter:filters">
                                 <td > {{$index + 1}}</i></td>
                                 <td> {{x.setupName}} </td>
                                 <td> {{x.paymentCode}} </td>
                                 <td> {{x.gatewayName}} </td>
                                 <td> {{x.serviceId}} </td>
                                 <td> {{x.reprocess}} </td>
                                 <td> <a href="#" ng-click="delSetup(x.setupId)"> <i class="fa fa-trash"> </i> </a></td>
                               </tr>
                                
                             </table>
                               
                            </div> 

                           <div class="ln_solid"></div>


                </div> <!-- ng-controller ends -->



                    </div><!-- 3rd Tab Ends -->          
                  
                      

         </div><!-- X-content -->

      
      </div>
    </div>
  </div>



<script src="../vendors/angularJs/angular.min.js"></script>
<!--<script src="../vendors/angularJs/angular-route.min.js"></script>-->
<script type="text/javascript" src="../vendors/angularJs/ui-bootstrap-tpls-2.5.0.min.js"></script>

<script type="text/javascript">
  
 

  // ---------- AngularJS filter script ---------------------------------//
var app = angular.module("setupApp",['ui.bootstrap']);

//For fee schedules
app.controller("setupCtrl", ['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){

  //Populte all fee schedules
$http.get("../production/ajax_calls/json_pay_code_call").then(function(response){ $scope.setups = response.data.records; console.log(response);  });


//The ng-click function here to delete fees Item
      $scope.delSetup = function(id)
      {
        
      var r = confirm('Are you sure you want to delete? Note that all Payment Profiles associated with this setup will be deleted.');       

        if(r == true)
        {
           $scope.processing = true;
           $scope.del_result = false;

          //Start Ajax call here
           $http({

                  type: 'GET',
                  url:  '../production/ajax_calls/ng_delete_setup',
                  params: {delSetup: id},
                  headers: { 'Accept': 'application/json, text-plain' },

                  }).then(function successCallback(response){ 

                      $scope.setupDeleteResponse = response.data; //Delete Response 

                      //Then reload the controller call again
                      $http.get("../production/ajax_calls/json_pay_code_call").then(function(response){ $scope.setups = response.data.records;  });

                       //Then reload the Payment type controller
                      $http.get("../production/ajax_calls/json_pay_type_call").then(function(response){ $rootScope.$broadcast('updatePayTypeCtrl', response.data.records); });                       
                      },

                      function errorCallback(response){ $scope.setupDeleteResponse = response.statusText; }).catch(function(err){ $scope.setupDeleteResponse = err; }).finally(function(){ $scope.processing = false; $scope.del_result = true; 
                      });             
             
        }         
        
      }; 

      
      //Listener to the delete call on payment type tab
      $rootScope.$on('updatePaySetupCtrl', function(event, args){

          $scope.setups = args;
      });  


}]).controller('choiceCtrl', ['$scope', '$http', '$rootScope', '$uibModal', function($scope, $http, $rootScope, $uibModal){

  //Populte all fee schedules
$http.get("../production/ajax_calls/json_pay_choice_call").then(function(response){ $scope.choices = response.data.records; console.log(response);  });


//The ng-click function here to delete fees Item
      $scope.delChoice = function(choiceid)
      {
        
        var r = confirm('Are you sure you want to delete? Note that all Payment Profiles associated with this option will be deleted.');
        if(r == true)
        {
           $scope.choice_processing = true;
           $scope.choice_del_result = false;

          //Start Ajax call here
           $http({

                  type: 'GET',
                  url:  '../production/ajax_calls/ng_delete_choice',
                  params: {delChoice: choiceid},
                  headers: { 'Accept': 'application/json, text-plain' },

                  }).then(function successCallback(response){ 

                      $scope.choiceDeleteResponse = response.data; //Delete Response 

                      //Then reload the controller call again
                      $http.get("../production/ajax_calls/json_pay_choice_call").then(function(response){ $scope.choices = response.data.records;  });

                      //Then reload the Payment setup controller
                      $http.get("../production/ajax_calls/json_pay_code_call").then(function(response){ $rootScope.$emit('updatePaySetupCtrl', response.data.records); });                      
                      },

                      function errorCallback(response){ $scope.choiceDeleteResponse = response.statusText; }).catch(function(err){ $scope.choiceDeleteResponse = err; }).finally(function(){ $scope.choice_processing = false; $scope.choice_del_result = true; 
                      });             
             
        }         
        
      };   

       //Call Bootstrap Modal Here and pass edit value
      $scope.editChoice = function(choiceid)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_edit_payment_choice?id=' + choiceid,
                controller: 'editPayChoiceCtrl', 
                backdrop: 'static',             
                resolve: { editId: function () { return choiceid; } }
          });
      };

      //Listener to the Update call
      $rootScope.$on('updateChoiceCtrl', function(e, a)
      {
         $scope.choices = a;
      });

}]).controller('editPayChoiceCtrl', ['$http', '$scope', '$rootScope', '$uibModalInstance', 'editId', function($http, $scope, $rootScope, $uibModalInstance, editId){

     //When Modal is closed
     $scope.close = function(){

      $uibModalInstance.close(false);

      //Then reload the controller call again
      $http.get("../production/ajax_calls/json_pay_choice_call").then(function(response){ $rootScope.$emit('updateChoiceCtrl', response.data.records); });
   };
  
  //When the Save Edit Button is clicked for Choice
     $scope.saveChoiceEdit = function(isValid){ 

    if(isValid){

               $scope.choice_proc = true;
               $scope.choice_edit_result = false;
                          
              //Prepare json data to be sent
               var sendData = {'choiceid': $scope.choiceId, 'choice': $scope.choicename};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_update_pay_choice_edit',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.editChoiceResult = response.data; console.log(response);

                           },

                         function errorCallback(response){ $scope.editChoiceResult = response.statusText; }).catch(function(err){ $scope.editChoiceResult = err; }).finally(function(){ $scope.choice_proc = false; $scope.choice_edit_result = true; 
                      });        
                  }

           };


}]).controller('typeCtrl',['$scope', '$http', '$rootScope', '$uibModal', function($scope, $http, $rootScope, $uibModal){

  //Populte all payment type for merchant
$http.get("../production/ajax_calls/json_pay_type_call").then(function(response){ $scope.types = response.data.records; console.log(response);  });


//Listener to setup delete on Payment setup tab
$rootScope.$on('updatePayTypeCtrl', function(event, arg){

    $scope.types = arg;

});



//The ng-click function here to delete fees Item
      $scope.delType = function(typeid)
      {
        
    var r = confirm('Are you sure you want to delete? Note that all Payment Profiles associated with this option will be deleted.');

        if(r == true)
        {
           $scope.type_processing = true;
           $scope.type_del_result = false;

          //Start Ajax call here
           $http({

                  type: 'GET',
                  url:  '../production/ajax_calls/ng_delete_type',
                  params: {delType: typeid},
                  headers: { 'Accept': 'application/json, text-plain' },

                  }).then(function successCallback(response){ 

                      $scope.typeDeleteResponse = response.data; //Delete Response 

                      //Then reload the controller call again
                      $http.get("../production/ajax_calls/json_pay_type_call").then(function(response){ $scope.types = response.data.records;  });

                      //Then reload the Payment setup controller
                      $http.get("../production/ajax_calls/json_pay_code_call").then(function(response){ $rootScope.$emit('updatePaySetupCtrl', response.data.records); });                     
                      },

                      function errorCallback(response){ $scope.typeDeleteResponse = response.statusText; }).catch(function(err){ $scope.typeDeleteResponse = err; }).finally(function(){ $scope.type_processing = false; $scope.type_del_result = true; 
                      });             
             
        }         
        
      };   

       //Call Bootstrap Modal Here and pass edit value
      $scope.editType = function(typeid)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_edit_payment_type?id=' + typeid,
                controller: 'editPayTypeCtrl', 
                backdrop: 'static',             
                resolve: { editId: function () { return typeid; } }
          });
      };

      //Listener to the Update call
      $rootScope.$on('updateTypeCtrl', function(e, a)
      {
         $scope.types = a;
      });

}]).controller('editPayTypeCtrl', ['$http', '$scope', '$rootScope', '$uibModalInstance', 'editId', function($http, $scope, $rootScope, $uibModalInstance, editId){

     //When Modal is closed
     $scope.close = function(){

      $uibModalInstance.close(false);

      //Then reload the controller call again
      $http.get("../production/ajax_calls/json_pay_type_call").then(function(response){ $rootScope.$emit('updateTypeCtrl', response.data.records); });
   };
  
  //When the Save Edit Button is clicked for Choice
     $scope.saveTypeEdit = function(isValid){ 

    if(isValid){

               $scope.type_proc = true;
               $scope.type_edit_result = false;
                          
              //Prepare json data to be sent
               var sendData = {'typeid': $scope.typeId, 'type': $scope.typename};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_update_pay_type_edit',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.editTypeResult = response.data; console.log(response);

                           },

                         function errorCallback(response){ $scope.editTypeResult = response.statusText; }).catch(function(err){ $scope.editTypeResult = err; }).finally(function(){ $scope.type_proc = false; $scope.type_edit_result = true; 
                      });        
                  }

           };


}])

 angular.bootstrap(document.getElementById('setup'), ['setupApp']);


</script>
        
</body></html>
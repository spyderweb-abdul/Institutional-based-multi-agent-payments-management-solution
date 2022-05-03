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

  <div class="row" id="feeSchedules">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
                  
                <div class="x_title">
                    <h4><i class="fa fa-wrench"> </i> Merchant's Fee Schedule - <small> Fee Schedule </small></h4>
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
                                       
                       
                  <div ng-controller="feeScheduleCtrl">

                                 <div style="color:red; font-weight: bolder;" ng-cloak> {{ feeScheduleResponse }} </div><br/>


                             <table width="80%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                               <tr>
                                 <td colspan="7">

                                 <form name="feeItemForm" ng-init="" class="form-horizontal form-label-left input_mask">
                                   <div class="form-group has-feedback">
                                   <input type="text" name="filt" ng-model="filters" class="form-control" placeholder="Insert Programme Name to Filter"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>
                                 </form>
                                 
                                <!-- <span ng-show="!items.length"> No Match Found </span> -->
                                 </td>
                               </tr>
                               
                               <tr>
                                 <th> </th>
                                 <th ng-click="orders('programme')" > Programme </th>
                                 <th ng-click="orders('amount')" > Amount </th>
                                 <th ng-click="orders('level')" > Level </th>
                                 <th ng-click="orders('nationality')" > Nationality </th>
                                 <th> Edit </th>
                                 <th> Delete </th>
                               </tr>
                               
                               <tr ng-repeat="x in schedules | filter:filters | orderBy: feeOrders">
                                 <td > {{$index + 1}}</i></td>
                                 <td> {{x.programme}} </td>
                                 <td> {{x.amount}} </td>
                                 <td> {{x.level}} </td>
                                 <td> {{x.nationality}} </td>
                                 <td> <a href ='#' ng-click="editSchedule(x.progId, x.nationality, x.level)" > <i class="fa fa-edit"> </i> </a>   </td>
                                 <td> <a href ='#' ng-click="delSchedule(x.progId, x.nationality, x.level)" ><i class="fa fa-trash"> </i> </a> </td>
                               </tr>
                                
                             </table>
                               
                            </div> 

                           <div class="ln_solid"></div>


                </div> <!-- ng-controller ends -->

                      

         </div><!-- X-content -->

      
      </div>
    </div>
  </div>



<script src="../vendors/angularJs/angular.min.js"></script>
<!--<script src="../vendors/angularJs/angular-route.min.js"></script>-->
<script type="text/javascript" src="../vendors/angularJs/ui-bootstrap-tpls-2.5.0.min.js"></script>

<script type="text/javascript">
  
 

  // ---------- AngularJS filter script ---------------------------------//
var app = angular.module("scheduleApp",['ui.bootstrap']);

//For fee schedules
app.controller("feeScheduleCtrl", ['$scope', '$http', '$rootScope', '$uibModal', function($scope, $http, $rootScope, $uibModal){

  $scope.orders = function(x){ $scope.feeOrders = x;}

//Populte all fee schedules
$http.get("../production/ajax_calls/json_fee_schedule_call").then(function(response){ $scope.schedules = response.data.records; console.log(response);  });

      //To delete fee schedule programme
      $scope.delSchedule = function(progid, nat, lev){

         var r = confirm('Are you sure you want to delete?');
              if(r == true)
              {

                 $http({

                        type: 'GET',
                        url:  '../production/ajax_calls/ng_delete_fee_schedule',
                        params: {delId: progid, natId: nat, levId: lev},
                        headers: { 'Accept': 'application/json, text-plain' },

                        }).then(function successCallback(response){ 

                            $scope.feeScheduleResponse = response.data; //Delete Response
                            //Then reload the controller call again
                            $http.get("../production/ajax_calls/json_fee_schedule_call").then(function(response){ $scope.schedules = response.data.records; });
                          },

                          function errorCallback(response){ $scope.feeScheduleResponse = response.statusText; });             
                   
              }         
      };

      //Call Bootstrap Modal Here and pass edit value
      $scope.editSchedule = function(progid, nat, lev)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_edit_fee_structure?progId=' + progid + '&natId=' + nat + '&levId=' + lev,
                controller: 'editFeeStructureCtrl', 
                backdrop: 'static',             
                resolve: { progId: function(){return progid;}, natId: function(){return nat;}, levId: function(){return lev;} }
          });

      };

      $rootScope.$on('updateScheduleCtrl', function(event, params) {
        
        $scope.schedules = params;
        console.log($scope.schedules);

      });
 

}]).controller('editFeeStructureCtrl', ['$scope', '$http', '$rootScope', '$uibModalInstance', 'progId', 'levId', 'natId', function($scope, $http, $rootScope, $uibModalInstance, progId, levId, natId){

    //Populate the fees breakdown for selected programme
      $http.get("../production/ajax_calls/json_fee_schedule_update_call").then(function(response){ 
            
             $scope.feesBreakdown = response.data.records; 
             $scope.tot = response.data.total;

        });


    //populate All Fee items for 'ADD NEW' drop down in the Modal Pop up to edit programme fee schedules
    $http.get("../production/ajax_calls/json_fee_items_call").then(function(response){ $scope.feeDrop = response.data.records; });

          //When Modal is closed
          $scope.close = function(){

          $uibModalInstance.close(false);
            //Then reload the fee schedule controller call again
          $http.get("../production/ajax_calls/json_fee_schedule_call").then(function(response){ $rootScope.$emit('updateScheduleCtrl', response.data.records); });
        };

     
       //To delete an Item from the Modal class list of item
       $scope.delItem = function(feeid){

         var d = confirm('Are you sure you want to delete?');     
            if(d == true){

              $http({

                            type: 'GET',
                            url:  '../production/ajax_calls/ng_delete_fee_schedule_item',
                            params: {feeId: feeid},
                            headers: { 'Accept': 'application/json, text-plain' },

                            }).then(function successCallback(response){ 

                                $scope.feeScheduleUpdate = response.data; //Delete Response
                                
                                //Then reload the controller call again
                                $http.get("../production/ajax_calls/json_fee_schedule_update_call").then(function(response){         
                                     $scope.feesBreakdown = response.data.records; 
                                     $scope.tot = response.data.total;

                                });
                              },

                              function errorCallback(response){ $scope.feeScheduleResponse = response.statusText; });             
                       
         }

        };

      $scope.saveAdd = function(isValid){

        if(isValid){

          var feeid = $scope.feeID;

          var sendData = {'feeID': feeid};

             $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_update_schedule_item',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ 

                               $scope.feeScheduleUpdate = response.data;

                                //Then reload the controller call again
                                $http.get("../production/ajax_calls/json_fee_schedule_update_call").then(function(response){         
                                     $scope.feesBreakdown = response.data.records; 
                                     $scope.tot = response.data.total;

                                });
                              
                            },
                          function errorCallback(response){ $scope.bulkFeeItemInputResult = response.statusText; });
        }

      };


}]);

//To open the hidden 'ADD NEW' div
function openMe()
{
  document.getElementById('openDiv').style.display = 'inline';
}

 angular.bootstrap(document.getElementById('feeSchedules'), ['scheduleApp']);


</script>
        
</body></html>
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

  <div class="row" id="payCode">
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
                                       
                       
                  <div ng-controller="payCodeCtrl">

                                <!--<div style="color:red; font-weight: bolder;"> {{ feeScheduleResponse }} </div><br/>-->


                             <table width="80%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak style="font-size: 12px;">
                               <tr>
                                 <td colspan="8">

                                 <form name="paycodeform" ng-init="" class="form-horizontal form-label-left input_mask">
                                   <div class="form-group has-feedback">
                                   <input type="text" name="filt" ng-model="filters" class="form-control" placeholder="Insert Payment Name to search"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>
                                 </form>
                                 
                                <!-- <span ng-show="!items.length"> No Match Found </span> -->
                                 </td>
                               </tr>
                               
                               <tr>
                                 <th> </th>
                                 <th > Setup Name</th>
                                 <th > Setup Code </th>
                                 <th > Channel </th>
                                 <th > Service Type ID </th>
                                 <th > Api Key </th>
                                 <th > Merchant Gateway ID </th>
                                 <th > Is Payment Reprocessible? </th>
                               </tr>
                               
                               <tr ng-repeat="x in codes | filter:filters">
                                 <td > {{$index + 1}}</i></td>
                                 <td> {{x.setupName}} </td>
                                 <td> {{x.paymentCode}} </td>
                                 <td> {{x.gatewayName}} </td>
                                 <td> {{x.serviceId}} </td>
                                 <td> {{x.apikey}} </td>
                                 <td> {{x.merchGatewayId}} </td>
                                 <td> {{x.reprocess}} </td>
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
var app = angular.module("codeApp",[]);

//For fee schedules
app.controller("payCodeCtrl", ['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){

  //Populte all fee schedules
$http.get("../production/ajax_calls/json_pay_code_call").then(function(response){ $scope.codes = response.data.records; console.log(response);  });


}]);

 angular.bootstrap(document.getElementById('payCode'), ['codeApp']);


</script>
        
</body></html>
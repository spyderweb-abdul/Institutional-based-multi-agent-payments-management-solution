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

  <div class="row" id="generalCollection">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
                  
                <div class="x_title">
                    <h4><i class="fa fa-wrench"> </i> Collection Report - <small> Report </small></h4>
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
                          <li class="active"><a data-toggle="pill" href="#menu" role="tab"> <i class="fa fa-list"></i> PAYMENT SUMMARY </a></li>
                          <li><a data-toggle="pill" href="#sec_menu" role="tab"> <i class="fa fa-search"></i> FILTER PAYMENTS </a></li>
                        </ul>
                     
              
                  <div class="tab-content">
                          
                          <!-- 1st TAB PILLS -->
                      <div id="menu" class="tab-pane fade in active" role="tabpanel">

                                <br/>

                                <p style="font-size: 14px; font-weight: bold; font-color: blue; margin-left: 200px; padding-bottom: 10px;"> Payment Summary Year: <?php echo $current_session; ?> </p>

                            <div ng-controller="paymentSummaryCtrl"><!-- ng-controller -->

                              <table width="80%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                               <tr>
                                 <td colspan="8">

                                 <form name="paysumform" ng-init="" class="form-horizontal form-label-left input_mask">
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
                                 <th > No. of Depositors </th>
                                 <th > Amount </th>
                              </tr>
                               
                               <tr ng-repeat="x in summary | filter:filters">
                                 <td > {{$index + 1}} </td>
                                 <td> <a href="#" ng-click="fetchSummary(x.setupId, 'lg')"> {{x.setupName}} </a> </td>
                                 <td> {{x.depositors}} </td>
                                 <td> {{x.amount}} </td>
                              </tr>

                              <tr ng-repeat="i in tot"> <td colspan="4" style="font-size: 18px; font-weight: bold; font-color: blue; text-align: center;"> Total Amount: <br/> {{ i.totalSum }} </td> </tr>
                                
                             </table>
                               
                            <div class="ln_solid"></div>

                            </div><!-- ng-controller ends -->

                         </div>

                    

                        <!-- 2nd TAB PILLS -->
                        <div id="sec_menu" class="tab-pane fade in" role="tabpanel">

                        <br/>
                       
                            <div ng-controller="paymentFilterCtrl" style="padding: 20px; margin: 20px;">

                                 
                            <form class="form-horizontal form-label-left input_mask" name="filterForm" id="filterForm" >

                               <div class="row well well-sm" ng-cloak>

                                    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                      <label>Select Payment Type: </label>
                                      <select  name="selSetup" ng-model="selSetup" class="form-control has-feedback-left" required ng-required="true" >
                                        <option value=""> - </option>
                                        <option  ng-repeat="x in payFilter" ng-value="{{ x.setupId }}"> {{ x.setupName }} </option>
                                                      
                                      </select>
                                      <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="filterForm.$submitted">
                                            <div style="color: red;" ng-show="filterForm.selSetup.$error.required"> *Select a Payment Type </div>
                                        </div>
                                   </div>

                                   <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                    <label>Select Status: </label>
                                      <select  name="selStatus" ng-model="selStatus" class="form-control has-feedback-left" required ng-required="true" >
                                        <option value=""> - </option>
                                        <option value="PAID"> PAID </option>
                                        <option value="PENDING"> PENDING </option>
                                        <option value="CANCELLED"> CANCELLED </option>
                                                      
                                      </select>
                                      <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="filterForm.$submitted">
                                            <div style="color: red;" ng-show="filterForm.selStatus.$error.required"> *Select Payment Status </div>
                                        </div>
                                   </div>
                             
                                  <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                    <label> Select Session: </label>
                                      <select  name="selSession" ng-model="selSession" class="form-control has-feedback-left" required ng-required="true" >
                                        <option value=""> - </option>
                                        <?php

                                          $sel_sess = $paydb->query("SELECT session FROM ".PAYMENT_RECORDS." GROUP BY session ORDER BY session ASC " );

                                          while($ses = $sel_sess->fetch_array())
                                          {
                                            echo '<option value="'.$ses['session'].'">'.$ses['session'].'</option>';
                                          }

                                        ?>
                                                      
                                      </select>
                                      <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                        <div ng-show="filterForm.$submitted">
                                            <div style="color: red;" ng-show="filterForm.selSession.$error.required"> *Select a Session </div>
                                        </div>
                                   </div>
                                  
                                  <div class="col-md-3 col-sm-3 col-xs-12">
                                    <label>  </label>
                                   <button style="border-radius: 0px; margin-top: 24px; margin-left: -5px;" class="btn btn-success" ng-disabled="filterForm.$invalid" ng-click="submitFilterForm(filterForm.$valid, 'lg')" ><i class="fa fa-list-alt"></i> Generate Report </button>
                                  </div>                       
                             
                              </div> 
                          </form>


                      </div><!-- ng-controller ends -->

                           <div class="ln_solid"></div>

                  </div>


                       
         </div><!-- X-content -->

      
      </div>
    </div>
  </div>



<script src="../vendors/angularJs/angular.min.js"></script>
<!--<script src="../vendors/angularJs/angular-route.min.js"></script>-->
<script type="text/javascript" src="../vendors/angularJs/ui-bootstrap-tpls-2.5.0.min.js"></script>

<script type="text/javascript">
  
 

  // ---------- AngularJS filter script ---------------------------------//
var app = angular.module("summaryApp",['ui.bootstrap']);

//For fee items entry
app.controller("paymentSummaryCtrl", function($scope, $http, $rootScope, $uibModal){

   $http.get("../production/ajax_calls/json_pay_summary_call").then(function(response){ $scope.summary = response.data.records; $scope.tot = response.data.total; });

   //Call Bootstrap Modal Here and pass edit value
      $scope.fetchSummary = function(id, size)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_setup_summary_report?setupid=' + id,
                controller: 'setupReportCtrl',
                backdrop: 'static',
                size: size,           
                resolve: { setid: function () { return id; } }
          });

      };

}).controller("setupReportCtrl", ['$scope', '$http', '$uibModalInstance', 'setid', '$rootScope', function($scope, $http, $uibModalInstance, setid, $rootScope){


     $scope.close = function(){
        $uibModalInstance.close(false);
     }
       
  }]).controller('paymentFilterCtrl', ['$http', '$scope', '$uibModal', '$rootScope', function($http, $scope, $uibModal, $rootScope){

   $http.get("../production/ajax_calls/json_pay_summary_call").then(function(response){ $scope.payFilter = response.data.records;  });

      //When the Save Edit Button is clicked
     $scope.submitFilterForm = function(isValid, size){ 


        var setup = $scope.selSetup;
        var status = $scope.selStatus;
        var session = $scope.selSession;
              
                var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_payment_filter_report?setupid='+setup+'&stat='+status+'&sess='+session,
                controller: 'filterReportCtrl',
                backdrop: 'static',
                size: size,           
                resolve: { 
                  setupid: function () { return setup; },
                  stat: function () { return status; },
                  sess: function () { return session; }
                 }
              });

        };

  }]).controller('filterReportCtrl', ['$http', '$scope', '$rootScope', 'setupid', 'stat', 'sess', '$uibModalInstance', function($http, $scope, $rootScope, setupid, stat, sess, $uibModalInstance){

        $scope.close = function(){
          $uibModalInstance.close(false);
        }

  }]);



 angular.bootstrap(document.getElementById('generalCollection'), ['summaryApp']);



</script>
        
</body></html>
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

  <div class="row" id="allSummary">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
                  
                <div class="x_title">
                    <h4><i class="fa fa-wrench"> </i> Collection Breakdown Report - <small> Report </small></h4>
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

                     FEES BREAKDOWN: <br/><br/>
                                       
                        <ul class="nav nav-pills" id="myTab">
                        <!--  <li class="active"><a data-toggle="pill" href="#menu" role="tab"> <i class="fa fa-list"></i> BY SETUP </a></li> -->
                          <li class="active"><a data-toggle="pill" href="#sec_menu" role="tab"> <i class="fa fa-list"></i> BY FACULTY </a></li>
                          <li><a data-toggle="pill" href="#third_menu" role="tab"> <i class="fa fa-list"></i> BY DEPARTMENT </a></li>
                          <li><a data-toggle="pill" href="#fourth_menu" role="tab"> <i class="fa fa-list"></i> BY PROGRAMME </a></li>
                          <li><a data-toggle="pill" href="#fifth_menu" role="tab"> <i class="fa fa-list"></i> BY LEVEL </a></li>
                          <li><a data-toggle="pill" href="#sixth_menu" role="tab"> <i class="fa fa-list"></i> BY ITEM </a></li>
                        </ul>
                     
              
                  <div class="tab-content">                   

                        <!-- 2nd TAB PILLS -->
                        <div id="sec_menu" class="tab-pane fade in active" role="tabpanel">

                        <br/>
                       
                            <div ng-controller="facultySummaryCtrl" style="padding: 20px; margin: 20px;" ng-cloak>

                            <table width="80%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                               <tr>
                                 <td colspan="8">

                                 <form name="facSumForm" ng-init="" class="form-horizontal form-label-left input_mask">
                                   <div class="form-group has-feedback">
                                   <input type="text" name="filt" ng-model="filters" class="form-control" placeholder="Insert Faculty Name to search"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>
                                 </form>
                                 
                                <!-- <span ng-show="!items.length"> No Match Found </span> -->
                                 </td>
                               </tr>
                               
                               <tr>
                                 <th> </th>
                                 <th > Faculty </th>
                                 <th > No. of Depositors </th>
                                 <th > Amount </th>
                              </tr>
                               
                               <tr ng-repeat="x in facsum | filter:filters">
                                 <td > {{$index + 1}} </td>
                                 <td> <a href="#" ng-click="fetchFacSummary(x.facId)"> {{x.facName}} </a> </td>
                                 <td> {{x.depositors}} </td>
                                 <td> {{x.amount}} </td>
                              </tr>

                              <tr ng-repeat="i in factotal"> <td colspan="4" style="font-size: 18px; font-weight: bold; font-color: blue; text-align: center;"> Total Amount: <br/> {{ i.facTotalSum }} </td> </tr>
                                
                             </table>                         


                            </div><!-- ng-controller ends --> <br/>

                                <div id="piechart_3d" ></div> 

                           <div class="ln_solid"></div>

                       </div>


                        <!-- 3rd TAB PILLS -->
                        <div id="third_menu" class="tab-pane fade in" role="tabpanel">

                        <br/>
                       
                            <div ng-controller="departmentSummaryCtrl" style="padding: 20px; margin: 20px;">

                                 
                                <table width="80%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                                 <tr>
                                 <td colspan="8">

                                 <form name="deptSumForm" ng-init="" class="form-horizontal form-label-left input_mask">
                                   <div class="form-group has-feedback">
                                   <input type="text" name="filt" ng-model="filters" class="form-control" placeholder="Insert Department Name to search"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>
                                 </form>
                                 
                                <!-- <span ng-show="!items.length"> No Match Found </span> -->
                                 </td>
                               </tr>
                               
                               <tr>
                                 <th> </th>
                                 <th > Department </th>
                                 <th > No. of Depositors </th>
                                 <th > Amount </th>
                              </tr>
                               
                               <tr ng-repeat="x in deptsum | filter:filters">
                                 <td > {{$index + 1}} </td>
                                 <td> <a href="#" ng-click="fetchDeptSummary(x.deptId)"> {{x.deptName}} </a> </td>
                                 <td> {{x.depositors}} </td>
                                 <td> {{x.amount}} </td>
                              </tr>

                              <tr ng-repeat="i in deptotal"> <td colspan="4" style="font-size: 18px; font-weight: bold; font-color: blue; text-align: center;"> Total Amount: <br/> {{ i.deptTotalSum }} </td> </tr>
                                
                             </table>                    

                            </div><!-- ng-controller ends -->

                           <div class="ln_solid"></div>

                       </div>



                        <!-- 4th TAB PILLS -->
                        <div id="fourth_menu" class="tab-pane fade in" role="tabpanel">

                        <br/>
                       
                            <div ng-controller="programmeSummaryCtrl" style="padding: 20px; margin: 20px;">

                                 
                                 <table width="80%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                                 <tr>
                                 <td colspan="8">

                                 <form name="progSumForm" ng-init="" class="form-horizontal form-label-left input_mask">
                                   <div class="form-group has-feedback">
                                   <input type="text" name="filt" ng-model="filters" class="form-control" placeholder="Insert Department Name to search"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>
                                 </form>
                                 
                                <!-- <span ng-show="!items.length"> No Match Found </span> -->
                                 </td>
                               </tr>
                               
                               <tr>
                                 <th> </th>
                                 <th > Programme </th>
                                 <th > No. of Depositors </th>
                                 <th > Amount </th>
                              </tr>
                               
                               <tr ng-repeat="x in progsum | filter:filters">
                                 <td > {{$index + 1}} </td>
                                 <td> <a href="#" ng-click="fetchProgSummary(x.progId)"> {{x.progName}} </a> </td>
                                 <td> {{x.depositors}} </td>
                                 <td> {{x.amount}} </td>
                              </tr>

                              <tr ng-repeat="i in progtotal"> <td colspan="4" style="font-size: 18px; font-weight: bold; font-color: blue; text-align: center;"> Total Amount: <br/> {{ i.progTotalSum }} </td> </tr>
                                
                             </table>
                         


                            </div><!-- ng-controller ends -->

                           <div class="ln_solid"></div>

                       </div><!-- $th Tab Ends -->


                       <!-- 5th TAB PILLS -->
                        <div id="fifth_menu" class="tab-pane fade in" role="tabpanel">

                        <br/>
                       
                            <div ng-controller="levelSummaryCtrl" style="padding: 20px; margin: 20px;">

                                 
                                <form name="levelBreakdownForm" id="levelBreakdownForm" ng-init="" class="form-horizontal form-label-left input_mask" ng-cloak>

                                    <div class="row well well-sm">

                                    <div class="col-sm-4 col-md-4 col-xs-12 form-group has-feedback">
                                     <label>Select Programme: </label>
                                      <select  name="selProg" ng-model="selProg" class="form-control has-feedback-left" required ng-required="true" >
                                        <option value=""> - </option>
                                        <option  ng-repeat="x in progList" ng-value="{{ x.progId }}"> {{ x.programme }} </option>
                                                      
                                      </select>
                                      <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                    </div>

                                    <div class="col-sm-4 col-md-4 col-xs-12 form-group has-feedback">

                                     <label>Select Level: </label>

                                              <select  name="level" ng-model="level" class="form-control has-feedback-left" required ng-required="true">
                                                       <option value=""> - </option>
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
                                                      
                                                </select>
                                              <span class="fa fa-angle-double-down form-control-feedback left" aria-hidden="true"></span>
                                                   
                                    </div>

                                    <div class="col-md-3 col-sm-3 col-xs-12">

                                        <button type="button" style="border-radius: 0px; margin-top: 24.5px; margin-left: -10px;" class="btn btn-success" ng-disabled="levelBreakdownForm.$invalid" ng-click="submitLevelBreakdownForm(levelBreakdownForm.$valid)" ><i class="fa fa-search"></i> Fetch Payment Records </button>
                                    </div> 

                                  </div>
                                </form>



                            </div><!-- ng-controller ends -->

                           <div class="ln_solid"></div>

                       </div><!-- 5th Tab -->

                        <!-- 6th TAB PILLS -->
                        <div id="sixth_menu" class="tab-pane fade in" role="tabpanel">

                        <br/>
                       
                            <div ng-controller="itemSummaryCtrl" style="padding: 20px; margin: 20px;">

                                 
                                 <table width="80%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                                 <tr>
                                 <td colspan="8">

                                 <form name="itemSumForm" ng-init="" class="form-horizontal form-label-left input_mask">
                                   <div class="form-group has-feedback">
                                   <input type="text" name="filt" ng-model="filters" class="form-control" placeholder="Insert Department Name to search"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>
                                 </form>
                                 
                                <!-- <span ng-show="!items.length"> No Match Found </span> -->
                                 </td>
                               </tr>
                               
                               <tr>
                                 <th> </th>
                                 <th > Fee Items </th>
                                 <th > No. of Depositors </th>
                                 <th > Amount </th>
                              </tr>
                               
                               <tr ng-repeat="x in itemsum | filter:filters">
                                 <td > {{$index + 1}} </td>
                                 <td> <a href="#" ng-click="fetchItemSummary(x.feeid)"> {{x.feeitem}} </a> </td>
                                 <td> {{x.depositors}} </td>
                                 <td> {{x.amount}} </td>
                              </tr>

                              <tr ng-repeat="i in itemtotal"> <td colspan="4" style="font-size: 18px; font-weight: bold; font-color: blue; text-align: center;"> Total Amount: <br/> {{ i.itemTotalSum }} </td> </tr>
                                
                             </table>
                         


                            </div><!-- ng-controller ends -->

                           <div class="ln_solid"></div>

                       </div><!-- 6th Tab Ends -->

                                    
                  </div> <!-- DIV Tab content -->

               </div><!-- X-content -->

      </div>
    </div>
  </div>




    <script src="../vendors/angularJs/angular.min.js"></script>
    <!--<script src="../vendors/angularJs/angular-route.min.js"></script>-->
    <script src="../vendors/angularJs/ui-bootstrap-tpls-2.5.0.min.js"></script>

     <script type="text/javascript">
  
 //Google Chart

     google.charts.load("visualization", "1", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

          var jsonData = $.ajax({
          url: "../production/ajax_calls/json_faculty_chart_stats",
          dataType: "json",
          async: false
          }).responseText;

         // console.log(jsonData);          
      
        var data = new google.visualization.DataTable(jsonData);


        var options = {

                        title: 'Faculty Payment Transactions Log Chart',
                        is3D: true,
                        width: 850,
                        height: 500,
                        titleTextStyle: {
                                          color: '#666666',    // any HTML string color ('red', '#cc00cc')
                                          fontName: 'Amiko', // i.e. 'Times New Roman'
                                          fontSize: 12, // 12, 18 whatever you want (don't specify px)
                                          bold: true,    // true or false
                                          italic: false 
                                        },
                                            // any HTML string color ('red', '#cc00cc')
                          fontName: 'Amiko', 
                          fontSize: '11' 
                       // pieSliceText: 'value'
                      };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
 

  // ---------- AngularJS filter script ---------------------------------//
var app = angular.module("summaryApp",['ui.bootstrap']);


app.controller('facultySummaryCtrl', ['$http', '$scope',  '$rootScope', '$uibModal', function($http, $scope, $rootScope, $uibModal){

 $http.get("../production/ajax_calls/json_faculty_summary_call").then(function(response){ $scope.facsum = response.data.records; $scope.factotal = response.data.total; });

   //Call Bootstrap Modal Here and pass edit value
      $scope.fetchFacSummary = function(id)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_faculty_summary_report?facid=' + id,
                controller: 'facultyReportCtrl',
                windowClass: 'app-modal-window',
                backdrop: 'static',       
                resolve: { facid: function () { return id; } }
          });

      };

  }]).controller('facultyReportCtrl', ['$http', '$scope', '$rootScope', 'facid', '$uibModalInstance', function($http, $scope, $rootScope, facid, $uibModalInstance){
 
      $scope.close = function(){
        $uibModalInstance.close(false);
      }

  }]).controller('departmentSummaryCtrl', ['$http', '$scope', '$rootScope', '$uibModal', function($http, $scope, $rootScope, $uibModal){

       $http.get('../production/ajax_calls/json_department_summary_call').then(function(response){ $scope.deptsum = response.data.records; $scope.deptotal = response.data.total; });


       //Call Bootstrap Modal Here and pass edit value
      $scope.fetchDeptSummary = function(id)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_department_summary_report?deptid=' + id,
                controller: 'departmentReportCtrl',
                windowClass: 'app-modal-window',
                backdrop: 'static',       
                resolve: { deptid: function () { return id; } }
          });

      };

  }]).controller('departmentReportCtrl', ['$http', '$scope', '$rootScope', 'deptid', '$uibModalInstance', function($http, $scope, $rootScope, deptid, $uibModalInstance){

       $scope.close = function(){            
          $uibModalInstance.close(false);
        }
       

  }]).controller('programmeSummaryCtrl', ['$http', '$scope', '$rootScope', '$uibModal', function($http, $scope, $rootScope, $uibModal){

       $http.get('../production/ajax_calls/json_programme_summary_call').then(function(response){ $scope.progsum = response.data.records; $scope.progtotal = response.data.total; });


       //Call Bootstrap Modal Here and pass edit value
      $scope.fetchProgSummary = function(id)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_programme_summary_report?progid=' + id,
                controller: 'programmeReportCtrl',
                windowClass: 'app-modal-window',
                backdrop: 'static',       
                resolve: { progid: function () { return id; } }
          });

      };

  }]).controller('programmeReportCtrl', ['$http', '$scope', '$rootScope', 'progid', '$uibModalInstance', function($http, $scope, $rootScope, progid, $uibModalInstance){

       $scope.close = function(){            
          $uibModalInstance.close(false);
       }

  }]).controller('levelSummaryCtrl', ['$http', '$scope', '$uibModal', function($http, $scope, $uibModal){

    $http.get('../production/ajax_calls/json_programme_list_call').then(function(response){ $scope.progList = response.data.programmeList; });

    $scope.submitLevelBreakdownForm = function(isValid)
    {
       if(isValid)
       {
         var progId = $scope.selProg;
         var level = $scope.level;

                var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_level_summary_report?progid='+progId+'&lev='+level,
                controller: 'levelReportCtrl',
                windowClass: 'app-modal-window',
                backdrop: 'static',          
                resolve: { 
                          progid: function () { return progId; },
                          lev: function () { return level; },
                         }
               });
       }

    };

  }]).controller('levelReportCtrl', ['$http', '$scope', 'progid', 'lev', '$uibModalInstance', function($http, $scope, progid, lev, $uibModalInstance){

     $scope.close = function()
     {
        $uibModalInstance.close(false);
     }

  }]).controller('itemSummaryCtrl', ['$http', '$scope', '$uibModal', function($http, $scope, $uibModal){

    $http.get('../production/ajax_calls/json_item_summary_call').then(function(response){ $scope.itemsum = response.data.records; $scope.itemtotal = response.data.total; });

      $scope.fetchItemSummary = function(id)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_item_summary_report?feeid=' + id,
                controller: 'itemReportCtrl',
                windowClass: 'app-modal-window',
                backdrop: 'static',       
                resolve: { feeid: function () { return id; } }
          });

      };

  }]).controller('itemReportCtrl', ['$http', '$scope', 'feeid', '$uibModalInstance', function($http, $scope, feeid, $uibModalInstance){

     $scope.close = function()
     {
        $uibModalInstance.close(false);
     }

  }]);


 angular.bootstrap(document.getElementById('allSummary'), ['summaryApp']);


</script>
        
</body></html>
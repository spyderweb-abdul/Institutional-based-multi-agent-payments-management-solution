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


<div id="setupSummary">    

<?php
    if($_SESSION['merchID'] != 0) 
    {
?>

           <!-- Pie Chart -->
             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h4> Payment Setup Transactions <small> Graph </small></h4>
                    <ul class="nav navbar-right panel_toolbox">
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
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!-- <canvas id="lineChart"></canvas> -->
                    <div id="piechart_3d" ></div>
                  </div>
                </div>
              </div>

                  <div class="clearfix"></div>

            <!-- -->
           
            <!-- Gateway Payment Statistics --> 
            
             <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h4> Activated Gateway Transactions Meter </h4>
                  <ul class="nav navbar-right panel_toolbox">
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
                  </ul>
                  <div class="clearfix"></div>
                </div>

                <div class="x_content">
                  <h4> Payments Instances Across Gateways </h4>
                 

                  <?php
          
                  //Loop through all active payment gateways for merchant

                   $gate = $paydb->query("SELECT b.gateway_name, b.gatewayId FROM ".ACTIVE_CHANNEL." a 
                                          INNER JOIN ".CHANNEL." b ON b.gatewayId = a.gatewayId
                                          WHERE a.merchantId = '$merchantId' AND a.status = 'ACTIVE'");
                    
                    while($row = $gate->fetch_array())
                     {
                        $gateway_name = $row[0];
                        $gatewayId = $row[1];
                                           
                      echo '<div class="widget_summary">
                              <div class="w_left w_25"> <span>'.$gateway_name.'</span> </div>
                                  <div class="w_center w_55">
                                    <div class="progress">';

                                    //get the total number of transactions
                                    $total_trans = $paydb->query("SELECT * FROM ".PAYMENT_RECORDS." WHERE merchantId = '$merchantId' AND session = '$current_session' ");

                                    $total_num = mysqli_num_rows($total_trans);

                                      if($total_num > 0)
                                      {
                                         //Get the number of transactions per gateway
                                         $gate_details = $paydb->query("SELECT * FROM ".PAYMENT_RECORDS." WHERE gatewayId = '$gatewayId' AND session = '$current_session' ");

                                          $gateway_num_rows = mysqli_num_rows($gate_details);

                                           //get the percentage of each gateways overall
                                           $percentage = $gateway_num_rows/$total_num * 100;

                                     //echo $percentage;

                                            echo '<div class="progress-bar bg-green" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percentage.'%;">
                                              <span class="sr-only">'.$percentage.'% Complete</span>
                                            </div>
                                          </div>
                                        </div>
                                  <div class="w_right w_20"> <span>'.$gateway_num_rows.'</span> </div>
                                <div class="clearfix"></div>
                               </div>';

                                 }
                     }

                  ?>                

                </div>
              </div>
            </div>
            <!-- -->

            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h4> Payment Setup Badges <small> Report </small></h4>
                    <ul class="nav navbar-right panel_toolbox">
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
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                <div ng-controller="summCtrl" >


                         <?php
                             
                             //call to function
                            $paysetups = get_payments_stats($_SESSION['userId']);

                            $pay_num = mysqli_num_rows($paysetups);

                            while ($setups = $paysetups->fetch_array())
                            {
                              $setupId = $setups[0];
                              $setup_name = $setups[1];

                              //$param = "'.$setupId.'";

                              echo '<button type="button" class="btn btn-success" ng-click="fetchSum('.$setupId.')" > <i class="fa fa-pie-chart"></i> '.$setup_name.'</button>';

                            }


                          ?>

                </div>

          </div>
        </div>
      </div>


<?php } else { ?>



<div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              <div class="x_title">
                        <h4> List of Activated Merchants <small> Summary </small></h4>
                        <ul class="nav navbar-right panel_toolbox">
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
                        </ul>
                        <div class="clearfix"></div>
                </div>
                <div class="x_content">

                      <div ng-controller="merchantListCtrl">

                       <table width="90%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                               <tr>
                                 <td colspan="6">

                                 <form name="merchForm" ng-init="" class="form-horizontal form-label-left input_mask">
                                   <div class="form-group has-feedback">
                                   <input type="text" name="filt" ng-model="filters" class="form-control" placeholder="Insert Merchant Name to search"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>
                                 </form>
                                 
                                <!-- <span ng-show="!items.length"> No Match Found </span> -->
                                 </td>
                               </tr>
                               
                               <tr>

                                 <th > Merchant ID </th>
                                 <th > Merchant Name </th>
                                 <th > Merchant Session </th>
                                 <th> Merchant Email </th>
                                 <th> Merchant Type</th>
                                 <th> No. of Payment Setups </th>
                              </tr>
                               
                               <tr ng-repeat="x in merchList | filter:filters">
                                 
                                 <td> {{x.merchantid}} </td>
                                 <td> <a href="#" ng-click="popMerchDetails(x.merchantid)"> {{x.merchantName}} </a> </td>
                                 <td> {{x.currentSession}} </td>
                                 <td> {{x.merchantEmail}} </td>
                                 <td> {{x.merchantType }} </td>
                                 <td> {{x.setnum }} </td>
                              </tr>
                                
                        </table>   

                      </div>   <!-- ng -->             

                  </div>
       </div>
    </div>

<?php } ?>

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
          url: "../production/ajax_calls/admin_json_lineChart_stats",
          dataType: "json",
          async: false
          }).responseText;

          //console.log(jsonData);          
      
        var data = new google.visualization.DataTable(jsonData);


        var options = {

                        title: 'Payment Setup Transactions Log Chart',
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



    
  /*    $(document).ready(function(){ 

      $.getJSON('../production/ajax_calls/admin_json_lineChart_stats.php', function(json){

            var ctx = document.getElementById("lineChart").getContext("2d");
            var lineChart = new Chart(ctx, { 

               type: 'line',
               data: {
                  labels: json['args1'],
                  datasets: [{
                              label: "No. of Transactions",
                              backgroundColor: "rgba(38, 185, 154, 0.31)",
                              borderColor: "#333333",
                              pointBorderColor: "rgba(38, 185, 154, 0.7)",
                              pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                              pointHoverBackgroundColor: "#fff",
                              pointHoverBorderColor: "rgba(220,220,220,1)",
                              pointBorderWidth: 1,
                              data: json['args2']
                            }]
                    }, 
                  options: {
              scales: {
                yAxes: [{
                  ticks: {
                          beginAtZero: true
                         }
                       }]
                      }
                         }
               });
                   });
      });
      *///Angular JS FOr Modal pop up
 var app = angular.module("setupSummaryApp", ['ui.bootstrap']);

    app.controller("summCtrl", ['$scope', '$http', '$uibModal', function($scope, $http, $uibModal){

       //Call Bootstrap Modal Here and pass edit value
          $scope.fetchSum = function(id)
          {
              var uibModalInstance = $uibModal.open({
                    animation: true,
                    templateUrl: '../production/ajax_main/merchant_setup_summary_report?setupid=' + id,
                    controller: 'setupReportCtrl',
                    windowClass: 'app-modal-window',
                    backdrop: 'static',       
                    resolve: { setid: function () { return id; } }
              });

          };

    }]).controller("setupReportCtrl", ['$scope', '$http', '$uibModalInstance', 'setid', function($scope, $http, $uibModalInstance, setid){


         $scope.close = function(){
            $uibModalInstance.close(false);
         }
            

  }]).controller("merchantListCtrl", ['$scope', '$http', '$uibModal', '$rootScope', function($scope, $http, $uibModal, $rootScope){

  $http.get('../production/ajax_calls/json_merchant_list_call').then(function(response){ $scope.merchList = response.data.merchantList; console.log(response); });


  $scope.popMerchDetails = function(merchid)
  {
    var uibModalInstance = $uibModal.open({
                    animation: true,
                    templateUrl: '../production/ajax_main/merchant_edit_setup_details?merchid=' + merchid,
                    controller: 'merchDetailsCtrl',
                    windowClass: 'app-modal-window',
                    backdrop: 'static',       
                    resolve: { id: function () { return merchid; } }
              });
  };

  //Listener to update the merchant list controller on close of the modal box
  $rootScope.$on('merchantListCtrl', function(e, a){

      $scope.merchList = a;
  });

 }]).controller('merchDetailsCtrl', ['$scope', '$http', '$uibModalInstance', 'id', '$rootScope', function ($scope, $http,$uibModalInstance, id, $rootScope){

        $scope.close = function()
         {
            $uibModalInstance.close(false);

            //Then reload the merchant list controller again after modal close
            $http.get('../production/ajax_calls/json_merchant_list_call').then(function(response){ $rootScope.$emit('merchantListCtrl', response.data.merchantList); });
         };

        $scope.saveEdit = function()
        {
            $scope.edit_saving = true;
            $scope.edit_result = false;

            if(document.getElementById('merchant_logo').files.length == 0)
              {
                  var sendData = {'merchantName': $scope.merchant_name, 'merchantEmail': $scope.merchant_email, 'currentSess': $scope.session, 'merchantType': $scope.merchant_type, 'merchId': $scope.merchantId };


                      $http({                         
                              method: 'POST',
                              url: '../production/ajax_calls/ng_update_merchant_setup',
                              data: sendData,
                              withCredentials: true,
                              headers :  { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' }

                              }).then(function successCallback(response)

                              { 
                                $scope.editResponse = response.data;                
                                 console.log(response);
                              },

                              function errorCallback(response){ $scope.editResponse = response.statusText; }).catch(function(err){ $scope.editResponse = err; }).finally(function(){ $scope.edit_saving = false; $scope.edit_result = true;
                               });

              }
              else
              {
                  var sendData = new FormData();
                  var files = document.getElementById('merchant_logo').files[0];
                  sendData.append('merchant_logo', files);
                  sendData.append('merchantName', $scope.merchant_name);
                  sendData.append('merchantEmail', $scope.merchant_email);
                  sendData.append('currentSess', $scope.session);
                  sendData.append('merchantType', $scope.merchant_type);
                  sendData.append('merchId', $scope.merchantId);



                        $http({                         
                              method: 'POST',
                              url: '../production/ajax_calls/ng_update_merchant_setup',
                              data: sendData,
                              withCredentials: true,
                              headers :  { 'Content-Type': undefined },
                              transformRequest: angular.identity

                              }).then(function successCallback(response)

                              { 
                                $scope.editResponse = response.data;                
                                 console.log(response);
                              },

                              function errorCallback(response){ $scope.editResponse = response.statusText; }).catch(function(err){ $scope.editResponse = err; }).finally(function(){ $scope.edit_saving = false; $scope.edit_result = true; });

               }

       };

 }]);


  
  angular.bootstrap(document.getElementById('setupSummary'), ['setupSummaryApp']);
    

  </script>

</body>
</html>
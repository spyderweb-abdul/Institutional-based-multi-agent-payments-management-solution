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

  <div class="row" id="verification">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
                  
                <div class="x_title">
                    <h4><i class="fa fa-wrench"> </i> Payment Verification &amp; Clearance - <small> Report </small></h4>
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
                          <li class="active"><a data-toggle="pill" href="#menu" role="tab"> <i class="fa fa-search"></i> VERIFY PAYMENT </a></li>
                          <li><a data-toggle="pill" href="#sec_menu" role="tab"> <i class="fa fa-check-square"></i> ISSUE CLEARANCE </a></li>
                          <li><a data-toggle="pill" href="#third_menu" role="tab"> <i class="fa fa-times-circle"></i> DELETE INVOICE </a></li>
                        </ul>
                     
              
                  <div class="tab-content">
                          
                          <!-- 1st TAB PILLS -->
                      <div id="menu" class="tab-pane fade in active" role="tabpanel">

                                <br/>                              

                            <div ng-controller="verifyPaymentCtrl" style="padding: 20px; margin: 20px;"><!-- ng-controller -->

                          <form name="verifyForm" id="verifyForm" ng-init="" class="form-horizontal form-label-left input_mask">

                              <div class="row well well-sm">

                                   <div class="col-sm-4 col-md-4 col-xs-12 form-group has-feedback">
                                     <input type="text" name="verifyInvoice" ng-model="verifyInvoice" class="form-control has-feedback-left" placeholder="Insert Invoice No." ng-required="true"  />
                                       <span class="fa fa-check-square form-control-feedback left" aria-hidden="true"></span>

                                   </div>

                                   <div class="col-md-3 col-sm-3 col-xs-12">
                                        <button type="button" style="border-radius: 0px; margin-top: 0px; margin-left: -10px;" class="btn btn-success" ng-disabled="verifyForm.$invalid" ng-click="submitVerifyForm(verifyForm.$valid)" ><i class="fa fa-search"></i> Look Up Invoice No. </button>
                                    </div> 

                              </div>
                            </form>

                                <div ng-if="loading" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>


                                <div style="color: red; font-size: 12px; font-style: italic;" ng-cloak ng-if="verify">  {{ verified }} </div>
                              
                               
                               <div class="ln_solid"></div>

                            </div><!-- ng-controller ends -->

                         </div>

                    

                        <!-- 2nd TAB PILLS -->
                        <div id="sec_menu" class="tab-pane fade in" role="tabpanel">

                        <br/>
                       
                            <div ng-controller="clearPaymentCtrl" style="padding: 20px; margin: 20px;">

                                  <form name="clearanceForm" id="clearanceForm" ng-init="" class="form-horizontal form-label-left input_mask">

                                    <div class="row well well-sm">

                                      <div class="col-sm-4 col-md-4 col-xs-12 form-group has-feedback">
                                      <input type="text" name="payerId" ng-model="payerId" class="form-control has-feedback-left" placeholder="Insert Payer ID" ng-required="true"  />
                                       <span class="fa fa-check-square form-control-feedback left" aria-hidden="true"></span>

                                    </div>

                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <button type="button" style="border-radius: 0px; margin-top: 0px; margin-left: -10px;" class="btn btn-success" ng-disabled="clearanceForm.$invalid" ng-click="submitClearanceForm(clearanceForm.$valid, 'lg')" ><i class="fa fa-search"></i> Fetch Payment Records </button>
                                    </div> 

                                  </div>
                                </form>

                                         <div style="color: red; font-size: 12px; font-style: italic;" ng-cloak>  {{ verified }} </div>
                              

                            </div><!-- ng-controller ends -->

                           <div class="ln_solid"></div>

                       </div>


                        <!-- 3rd TAB PILLS -->
                        <div id="third_menu" class="tab-pane fade in" role="tabpanel">

                        <br/>
                       
                            <div ng-controller="deleteInvoiceCtrl" style="padding: 20px; margin: 20px;">


                               <form name="deleteForm" id="deleteForm" ng-init="" class="form-horizontal form-label-left input_mask">

                                  <div class="row well well-sm">

                                   <div class="col-sm-4 col-md-4 col-xs-12 form-group has-feedback">
                                     <input type="text" name="id" ng-model="id" class="form-control has-feedback-left" placeholder="Insert User ID." ng-required="true"  />
                                       <span class="fa fa-check-square form-control-feedback left" aria-hidden="true"></span>

                                   </div>

                                   <div class="col-md-3 col-sm-3 col-xs-12">
                                        <button type="button" style="border-radius: 0px; margin-top: 0px; margin-left: -10px;" class="btn btn-success" ng-disabled="deleteForm.$invalid" ng-click="submitDeleteForm(deleteForm.$valid)" ><i class="fa fa-search"></i> Fetch Invoice(s). </button>
                                    </div> 

                                  </div>

                                </form>

                                   <div ng-if="loading" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>

                                   <p> <div style="color: red; font-size: 12px; font-style: italic; font-weight: bold;" ng-cloak ng-if="delete">  {{ deleteResponse }} </div> </p>
                                   <br/>


                               <form name="checkedForm" id="checkedForm" ng-init="" class="form-horizontal form-label-left input_mask">

                                    <table width="95%" style="font-size: 11px;" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-show="formSubmitted" ng-cloak>
                               
                                       <tr>
                                         <th> </th>
                                         <th>  User ID </th>
                                         <th>  Invoice No. </th>
                                         <th>  Transaction ID </th>
                                         <th>  Amount </th>
                                         <th>  Level </th>
                                         <th>  Setup Name </th>
                                         <th>  Session </th>
                                         <th>  Status </th>
                                         <th>  Date/Time </th>
                                       </tr>

                                       <tr ng-repeat="x in invoice">
                                        <td> <input type="checkbox" value="{{x.invoice}}" ng-model="x.selected" style="height:auto; box-shadow:none; border:#CCC thin" > </td>
                                        <td> {{ x.userId }} </td>
                                        <td> {{ x.invoice }} </td>
                                        <td> {{ x.transactionId }} </td>
                                        <td> {{ x.amount | number }} </td>
                                        <td> {{ x.level }} </td>
                                        <td> {{ x.setup_name }} </td>
                                        <td> {{ x.session }} </td>
                                        <td> {{ x.status }} </td>
                                        <td> {{ x.dateTime }} </td>

                                       </tr>
                                       <tr>

                                         <td colspan="10">  <button type="button" class="btn btn-danger" ng-click="delChecked(checkedForm.$valid)"><i class="fa fa-times-circle"></i> Delete Invoice(s) </button>  </td>

                                       </tr>
                                    </table>

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
var app = angular.module("verifyApp",['ui.bootstrap']);

//For fee items entry
app.controller('verifyPaymentCtrl', ['$http', '$scope', '$rootScope', '$uibModal', function($http, $scope, $rootScope, $uibModal){

   $scope.submitVerifyForm = function(isValid){

    $scope.loading = true; //Loading is set to true while execution is taking place
    $scope.verify = false;  //ng-if="verify" is set to false (not to display) when execution is taking place

    if(isValid)
    {

     var sendData = {'invoice': $scope.verifyInvoice };

                         $http({                         
                                method: 'POST',
                                url: '../production/ajax_calls/ng_verify_payment',
                                data: sendData,
                                headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                                }).then(function successCallback(response) { $scope.verified = response.data; console.log(response); },

                                function errorCallback(response){ $scope.verified = response.statusText; }).catch(function(err){ $scope.verified = err; }).finally(function(){ $scope.loading = false; $scope.verify = true;
                                 });


    }


   }

}]).controller('clearPaymentCtrl', ['$http', '$scope', '$rootScope', '$uibModal', function($http, $scope, $rootScope, $uibModal){

         //When the the Fetch Payment Record Button is clicked
     $scope.submitClearanceForm = function(isValid, size){ 

        var userId = $scope.payerId;
              
                var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_payer_clearance_page?userid='+userId,
                controller: 'paymentRecordCtrl',
                backdrop: 'static',
                size: size,           
                resolve: { 
                          userid: function () { return userId; },  
                          }
              });

        }
}]).controller('paymentRecordCtrl', ['$http', '$scope', 'userid', '$uibModalInstance', function($http, $scope, userid, $uibModalInstance){

  $scope.close = function()
  {
    $uibModalInstance.close(false);
  }

}]).controller('deleteInvoiceCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope){


    var user_id = $scope.id;

           //When the the Fetch Invoice(s) Button is clicked
     $scope.submitDeleteForm = function(isValid){ 


        $scope.loading = true; //Loading is set to true while execution is taking place

              var sendData = {'payerid': $scope.id};

               $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/json_payer_invoice_call',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.invoice = response.data.invoiceList; console.log(response); $scope.formSubmitted = true;},

                          function errorCallback(response){ $scope.invoice = response.statusText; }).catch( function (err){ $scope.invoice = err; }).finally(function(){ $scope.loading = false; $scope.delete = false; });
                          

        },

    $scope.delChecked = function(isValid)
    {

          var invoiceId = [];

          angular.forEach($scope.invoice, function(x){ if(x.selected){ invoiceId.push(x); }});

          var arr = new Array(), display = "";

           display = "Kindly Confirm the invoice(s) number to be deleted." + "\n\n";

            for (var key in invoiceId)
            {
               if(invoiceId.hasOwnProperty(key))
               {
                   display += invoiceId[key].invoice + "\n";

                   arr.push(invoiceId[key].invoice);
               }
            }

            if(typeof arr == 'undefined' || arr.length == 0)
            {
              alert('No selection was made');
            }
            else
            {

                display += "\n"+"Press OK if selection(s) is/are correct or CANCEL to discard."

                var sendData = {'invoices': arr}

                var r = confirm(display);

              if(r == true)
               {
                             $scope.loading = true;
                             $scope.delete = false;

                              $http({                            
                                    method: 'POST',
                                    url: '../production/ajax_calls/ng_delete_invoice',
                                    data: sendData,
                                    headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                                    }).then(function successCallback(response){

                                      $scope.deleteResponse = response.data; 

                                      //Recall the InvoiceList after deletion
                                      //$http.get("../production/ajax_calls/json_payer_invoice_call", { params: {payerid: user_id} }).then(function(response){ 

                                     // $scope.invoice = response.data.invoiceList; });

                                    },
                                   
                                    function errorCallback(response){ 

                                        $scope.deleteResponse = response.statusText;  

                                     }).catch(function(err){ $scope.deleteResponse = err}).finally(function(){ 

                                          $scope.loading = false; 
                                          $scope.delete = true; 

                                    });         
                  }

              }


    }

}]);


angular.bootstrap(document.getElementById('verification'), ['verifyApp']);



</script>
        
</body></html>
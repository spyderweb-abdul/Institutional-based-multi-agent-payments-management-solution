<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';


    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $current_session = $getDetails['current_session'];

?>

 <html><body>
          
<div id="singleFeeSetup">
    <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h4><i class="fa fa-wrench"> </i> Merchant Single Fee Structure - <small> Fee Setup </small></h4>
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
                          <li class="active"><a data-toggle="tab" href="#menu" role="tab"> <i class="fa fa-shopping-cart"></i> CREATE SINGLE FEE AMOUNT </a></li>
                          <li><a data-toggle="pill" href="#sec_menu" role="tab"> <i class="fa fa-edit"></i> EDIT SINGLE FEE AMOUNT </a></li>
                          
                        </ul>


                     <div class="tab-content">
                          
                          <!-- 1st TAB PILLS -->
                      <div id="menu" class="tab-pane fade in active" role="tabpanel">

                          <br/>

                        <div ng-controller="addFeeCtrl">

                            <div ng-if="single_proc" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>

                            <div style="color:red; font-weight: bolder;" ng-cloak ng-if="single_result"> {{ feeAmountResult }} </div><br/>

                              <form class="form-horizontal form-label-left input_mask" name="singleFeeForm" novalidate ng-cloak >                                            
                              <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                  <select name="setupId" ng-model="setupId" ng-change="fetchAmt()" class="form-control has-feedback-left" required>
                                  <option value=""> - Select Fee Type - </option>
                                   <?php
                                     
                                     $merchant_fees = $paydb->query("SELECT * FROM ".PAYMENT_CHOICE. " a INNER JOIN ".SETUP." b ON a.choiceId = b.choiceId WHERE a.merchantId = '$merchantId' AND a.req_fee_items = 'NO' ");
                                     while ($fees = $merchant_fees->fetch_array())

                                     {
                                        echo '<option value="'.$fees['setupId'].'">'.$fees['setup_name'].'</option>';
                                     }

                                   ?>

                                  </select>
                                <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>

                                   <div ng-show="singleFeeForm.$submitted">
                                      <div style="color: red;" ng-show="singleFeeForm.setupId.$error.required"> *Select Setup Name </div>
                                   </div>
                                </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                                  <input type="text" class="form-control has-feedback-left"  placeholder="Insert Amount (e.g: 10000)" name="feeAmount" ng-model="feeAmount" required >
                                  <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                                  </div>

                                  <div ng-show="singleFeeForm.$submitted">
                                      <div style="color: red;" ng-show="singleFeeForm.setupId.$error.required"> *Input Amount </div>
                                   </div>
                              </div>

                                
                                <div class="ln_solid"></div>

                           

                            <div class="form-group">
                              <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="reset" id="btn_single_fee_reset" ><i class="fa fa-times"></i> Reset</button>
                                <button type="button" class="btn btn-success" ng-disabled="singleFeeForm.$invalid" ng-click="submitSingleFee(singleFeeForm.$valid)"><i class="fa fa-save"></i> Create Single Fee Amount </button>
                              </div>
                            </div>

                        </form>

                     </div>

                           
                    </div>                    

                    <!-- 2nd TAB PILLS -->
                    <div id="sec_menu" class="tab-pane fade in" role="tabpanel">

                        <br/>
                       
                            <div ng-controller="singleFeeCtrl">

                             <div style="color:red; font-weight: bolder;" ng-cloak> {{ feeItemDeleteResponse }} </div><br/>


                             <table width="60%" align="center" class="table-bordered table-condensed table-hover table-responsive table-striped" ng-cloak>
                               <tr>
                                 <td colspan="5">

                                 <form name="singleFeeForm" ng-init="" class="form-horizontal form-label-left input_mask">
                                   <div class="form-group has-feedback">
                                   <input type="text" name="filt" ng-model="filters" class="form-control" placeholder="Insert Setup Name to Filter"  />
                                   <i class="fa fa-search form-control-feedback"></i>
                                   </div>
                                 </form>
                                 
                                <!-- <span ng-show="!items.length"> No Match Found </span> -->
                                 </td>
                               </tr>
                               
                               <tr>
                                 <th> </th>
                                 <th> Setup Name </th>
                                 <th> Amount </th>
                               </tr>
                               
                               <tr ng-repeat="x in setup | filter:filters">
                                 <td > <i class="fa fa-angle-double-right pull-right"> </i></td>
                                 <td> <a href="#" ng-click="editSetup(x.setupId)"> {{ x.setupName }} </a> </td>
                                 <td> {{ x.amount | number }} </td>
                               </tr>
                                
                             </table>
                               
                            </div> 

                           <div class="ln_solid"></div>

                        </div>

                
                    </div><!--Tab Content-->

              </div> <!-- X-content -->
            

            </div>
          </div>
        </div>

</div>

<script src="../vendors/angularJs/angular.min.js"></script>
<!--<script src="../vendors/angularJs/angular-route.min.js"></script>-->
<script type="text/javascript" src="../vendors/angularJs/ui-bootstrap-tpls-2.5.0.min.js"></script>
          
<script type="text/javascript">

var app = angular.module('myApp',['ui.bootstrap']);

app.controller('singleFeeCtrl', ['$http', '$scope', '$rootScope', '$uibModal', function($http, $scope, $rootScope, $uibModal){

  //Populte all setupname peculiar to merchant
  $http.get("../production/ajax_calls/json_setup_call").then(function(response){ $scope.setup = response.data.records;  });

   //Call Bootstrap Modal Here and pass edit value
      $scope.editSetup = function(setid)
      {
          var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: '../production/ajax_main/merchant_edit_setup_amount?id=' + setid,
                controller: 'editSetupAmountCtrl', 
                backdrop: 'static',             
                resolve: { editId: function () { return setid; } }
          });
      };

      //Listener to the Update call
      $rootScope.$on('updateAmtCtrl', function(e, a)
      {
         $scope.setup = a;
      });

}]).controller('editSetupAmountCtrl', ['$http', '$scope', '$rootScope', '$uibModalInstance', 'editId', function($http, $scope, $rootScope, $uibModalInstance, editId){

     //When Modal is closed
     $scope.close = function(){

      $uibModalInstance.close(false);

      //Then reload the controller call again
      $http.get("../production/ajax_calls/json_setup_call").then(function(response){ $rootScope.$emit('updateAmtCtrl', response.data.records); });
   };

     //When the Save Edit Button is clicked
     $scope.saveAmountEdit = function(isValid){ 

    if(isValid){
                          
              //Prepare json data to be sent
               var sendData = {'setupid': $scope.setupId, 'amt': $scope.amount};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_update_fee_amount_edit',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.editSetupAmountResult = response.data; console.log(response); },

                          function errorCallback(response){ $scope.editSetupAmountResult = response.statusText; console.log(response); });
                  }

           };

}]).controller('addFeeCtrl', ['$http', '$scope', '$rootScope', function($http, $scope, $rootScope){

      $scope.fetchAmt = function(){
         
            //Prepare json data to be sent
               var sendData = {'setupid': $scope.setupId};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/json_fetch_setup_amount',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.feeAmount = response.data; console.log(response); },

                          function errorCallback(response){ $scope.feeAmount = response.statusText; console.log(response); });
                  };

      $scope.submitSingleFee = function(isValid)
      {
        if(isValid)
        {
          $scope.single_proc = true;
          $scope.single_result = false;
          //Prepare json data to be sent
               var sendData = {'setupid': $scope.setupId, 'amt': $scope.feeAmount};

                         $http({                         
                          method: 'POST',
                          url: '../production/ajax_calls/ng_create_single_fee_amount',
                          data: sendData,
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' } 

                          }).then(function successCallback(response){ $scope.feeAmountResult = response.data; 
                            console.log(response);

                          //Then reload the Payment setup controller
                          $http.get("../production/ajax_calls/json_setup_call").then(function(response){ $rootScope.$emit('updateAmtCtrl', response.data.records); }); 


                           },

                          function errorCallback(response){ $scope.feeAmountResult = response.statusText; console.log(response); }).catch(function(err){ $scope.feeAmountResult = err}).finally(function(){
                             $scope.single_proc = false; $scope.single_result = true;
                          });
        }

      };


}]);


  $(document).on('click', '#btn_single_fee_reset', function(){

  $('#single_fee_form')[0].reset();

});



 angular.bootstrap(document.getElementById('singleFeeSetup'), ['myApp']);

</script>

</body></html>
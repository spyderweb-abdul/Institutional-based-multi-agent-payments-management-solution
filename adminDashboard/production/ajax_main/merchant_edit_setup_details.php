<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';
?>

<html> 
 <body>
                 <!-- Modal Header -->
                 <div class="modal-header">
                    <h5 class="modal-title pull-left" id="modalLabel">Edit Merchant Details:</h5>
                    <button type="button" class="close" ng-click="close()" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>               

            <div ng-app="merchDetailsCtrl">

                    <div class="modal-body"> 

                  
                          <?php 

                          if(isset($_GET['merchid']))
                          {

                          $merchantId = $_GET['merchid'];

                          
                             $merchant_details = $paydb->query("SELECT * FROM ".MERCHANTS." a INNER JOIN ".MERCHANT_TYPE." b ON b.merchantTypeId = a.merchantTypeId WHERE a.merchantId = '$merchantId' ") or die (mysqli_error($paydb));
                              $fetch_details = $merchant_details->fetch_array();

                              $merchant_name = $fetch_details['merchant_name'];
                               $merchant_email = $fetch_details['merchant_email'];
                               $merchant_type_name = $fetch_details['merchant_type_name'];
                                $current_session = $fetch_details['current_session'];
                              $merchantTypeId = $fetch_details['merchantTypeId'];           

                          ?>
                       

                      <div ng-if="edit_saving" ng-cloak> <i class="fa fa-spin fa-2x fa-spinner fa-fw"> </i> ...Please Wait </div>

                    <div style="color:red; font-weight: bolder;" ng-cloak ng-if="edit_result"> {{ editResponse }} </div> <br/>

                            <form class="form-horizontal form-label-left" name="merchant_setup" id="merchant_setup" enctype="multipart/form-data">

                          <div class="row">
                                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" placeholder="Merchant's Name" name="merchant_name" ng-model="merchant_name"  ng-init="merchant_name='<?php echo $merchant_name; ?>'" ng-required="true"  >
                                    <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
                                  </div>
                          </div>
                          
                          <div class="row">
                                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" placeholder="Merchant's Official Email" name="merchant_email" ng-model="merchant_email"  ng-init="merchant_email='<?php echo $merchant_email; ?>'" ng-required="true" >
                                    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                  </div>
                          </div>

                          <div class="row">
                                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" placeholder="Current Financial Year (e.g 2016/2017)" name="session" ng-model="session" ng-init="session='<?php echo $current_session; ?>'" ng-required="true">
                                    <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                  </div>
                          </div>
                           
                          
                          <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <select name="merchant_type" ng-model="merchant_type" class="form-control has-feedback-left" required ng-required="true">

                                    <option ng-init="merchant_type='<?php echo $merchantTypeId;  ?>'" selected > <?php echo $merchant_type_name;  ?> 
                                    </option>
                                    <option> </option>
                                    
                                    <?php
                                        $sel_pay_type = $paydb->query("SELECT * FROM ".MERCHANT_TYPE);
                                        while($type = $sel_pay_type->fetch_array() )
                                            {  
                                    ?>
                                    <option ng-init="merchant_type='<?php echo $type['merchantTypeId']; ?>'" > <?php echo $type['merchant_type_name']; ?>                      
                                    </option>

                                    <?php } ?>

                                    </select>
                                    <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>

                                </div>
                          </div>
                         
                          <div class="row">

                          <div class="form-group has-feedback col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" class="form-control has-feedback-left" name="merchant_logo" id="merchant_logo" style="min-height: 45px;"   />
                                   <span class="fa fa-file-image-o form-control-feedback left" aria-hidden="true"></span>
                                 </div>
                          </div>

                          <input type="hidden" name="merchantId" ng-model="merchantId"  ng-init="merchantId='<?php echo $merchantId; ?>'"" >


                        </form>                                                        
                            
                      <?php } else {echo 'User ID Not Defined'; } ?>

                  </div>

                           <!-- Modal Footer -->
                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="close()"> Close </button>
                    <button type="button" class="btn btn-warning" ng-click="saveEdit(merchant_setup)" > Save Edit </button>
                  </div>
                <!-- -->

     </div>

</body></html>
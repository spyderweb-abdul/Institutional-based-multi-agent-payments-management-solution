<?php
session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

    $getDetails = get_session_info($_SESSION['userId']); //Call to function that gets Admin Users Details
    $merchantId = $getDetails['merchantId'];
    $merchant_name = $getDetails['merchant_name'];
    //$current_session = $getDetails['current_session'];



   echo '<div class="row">
           <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
               <select name="choiceId" id="choiceId" class="form-control has-feedback-left">
                   <option value=""> -Select Payment Choice- </option>';
                      
                           $sel_choice_id = $paydb->query("SELECT * FROM ".PAYMENT_CHOICE." WHERE merchantId = '$merchantId'");
                           while($choice = $sel_choice_id->fetch_array() )
                              {
                                 echo '<option value="'.$choice['choiceId'].'">'.$choice['payment_choice_name'].'</option>';
                              }

        echo  '</select>
               <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>

              </div>
          </div>

          <div class="row">
           <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
              <input type="text" class="form-control has-feedback-left" placeholder="Payment Type Name" name="payment_type_name" id="payment_type_name">
              <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
            </div>
         </div>


       </form>

                   <div class="form-group">
                     <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                      <button class="btn btn-primary" type="reset" id="btn_payment_type_reset"><i class="fa fa-times"></i> Reset</button>
                      <button type="button" class="btn btn-success" id="btn_save_payment_type"><i class="fa fa-save"></i> Create Payment Type</button>
                     </div>
                   </div>';

?>

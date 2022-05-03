<?php
//session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

if(isset($_GET['merchantname']))
{
$merchantId = trim_input($_GET['merchantname']);

   echo '<div class="row">
           <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
               <select name="choiceId" id="choiceId" class="form-control has-feedback-left" onchange="fetch_pay_type();">
                   <option value=""> -Select Payment Choice- </option>';
                      
                           $sel_choice_id = $paydb->query("SELECT * FROM ".PAYMENT_CHOICE." WHERE merchantId = '$merchantId'");
                           while($choice = $sel_choice_id->fetch_array() )
                              {
                                 echo '<option value="'.$choice['choiceId'].'">'.$choice['payment_choice_name'].'</option>';
                              }

        echo  '</select>
               <span class="fa fa-shopping-cart form-control-feedback left" aria-hidden="true"></span>

              </div>
          </div>


          <div id="pay_type_div2"></div>';
}
         
?>

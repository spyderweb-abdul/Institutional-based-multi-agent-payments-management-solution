<?php
//session_start();

    include_once '../../../config/connections/constant_connection.php';
    include_once '../../../config/constant_define/constants.php';
    include_once '../functions/admin_control_functions.php';

if(isset($_GET['choiceid']))
{
$choiceId = trim_input($_GET['choiceid']);

   echo '<div class="row">
           <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
               <select name="typeId" id="typeId" class="form-control has-feedback-left" onchange="fetch_setup_param();">
                   <option value=""> -Select Payment Type- </option>';
                      
                           $sel_type_id = $paydb->query("SELECT * FROM ".PAYMENT_TYPE." WHERE choiceId = '$choiceId'");
                           while($type = $sel_type_id->fetch_array())
                              {
                                 echo '<option value="'.$type['typeId'].'">'.$type['payment_type_name'].'</option>';
                              }

        echo  '</select>
               <span class="fa fa-list form-control-feedback left" aria-hidden="true"></span>

              </div>
          </div>


          <div id="pay_setup_param_div"></div>';

        

}

?>

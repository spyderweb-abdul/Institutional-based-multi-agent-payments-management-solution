<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

$userId = trim_input($_POST['userId']);


$get_payer_session = $paydb->query("SELECT DISTINCT b.session FROM ".USERS." a 
								   INNER JOIN ".PAYMENT_RECORDS." b ON b.merchantId = a.merchantId
								   WHERE a.userId = '$userId' ");
if(mysqli_num_rows($get_payer_session) > 0)
{
 
		    echo '<div class="row"><div class="col-md-6"> 
	               <div class="input-group">
           			 <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
             			<select name="session" id="session" class="form-control pay-detail-form" onchange="get_gateway()" >
						  <option value="">- Select Payment Session -</option>';		 
						   $get_session = $paydb->query("SELECT DISTINCT session FROM ".PAYMENT_RECORDS);
							while($session = $get_session->fetch_array())
							{
								echo '<option value="'.$session[0].'">'.$session[0].'</option>';
							}
                   echo '</select>
	          </div></div></div><br/>';
}


 ?>
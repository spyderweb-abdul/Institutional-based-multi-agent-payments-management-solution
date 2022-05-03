<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

$userId = trim_input($_POST['userId']);
$merchantId = trim_input($_POST['merchantId']);


$get_payer_option = $paydb->query("SELECT DISTINCT a.setupId, a.setup_name FROM ".SETUP." a 
								   INNER JOIN ".PAYMENT_RECORDS." b ON b.setupId = a.setupId
								   INNER JOIN ".USERS." c ON c.userId = b.userId WHERE c.userId = '$userId' AND b.merchantId = '$merchantId' ");
if(mysqli_num_rows($get_payer_option) > 0)
{
$user = get_user_data($userId, $merchantId);//Call to an external function to get some details about payer
echo '<h5>' .$user['merchant_type_name'].": ".$user['merchant_name'] .'</h5><br/>';

 echo '<div class="row"><div class="col-md-6"> 
        <div class="input-group">
           <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
             <select name="setupId" id="setupId" class="form-control pay-detail-form" onchange="display_session()" >
			  <option value="">- Select Payment Type -</option>';
				while($payer_option = $get_payer_option->fetch_array())
				{
					echo '<option value="'.$payer_option[0].'">'.$payer_option[1].'</option>';
				}
         echo '</select>
	    </div></div></div><br/>';
		  
}
else
{
		echo '<button class="btn btn-danger btn-sm">User Not Found</button>';

}


 ?>
<?php

if(isset($_GET['gateway']))
{

include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

	$gateway = trim_input($_GET['gateway']);

//To get the list of payment options available to payment gateways
$get_option_list = $paydb->query("SELECT a.optionId, a.option_name FROM ".PAY_OPTIONS." a INNER JOIN ".OPTION_LIST." b ON b.optionId = a.optionId
                                  INNER JOIN ".CHANNEL." c ON c.gatewayId = b.gatewayId
								  WHERE c.gateway_name = '$gateway' ");
		
	     echo '<label class="pay-detail-form-label"> Payment Option: </label> 
	            <div class="input-group">
            	<span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
                <select name="paymentMode" id="paymentMode" class="form-control pay-detail-form" >
                <option value="" selected>-Select Payment Mode-</option>';
				while($list = $get_option_list->fetch_array())
				{
                  echo '<option value="'.$list[0].'">'.$list[1].'</option>';
				}
              
			  echo '</select></div>';
}

?>
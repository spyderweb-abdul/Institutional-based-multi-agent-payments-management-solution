<?php

if(isset($_GET['gateway']))
{

include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

	$gatewayId = trim_input($_GET['gateway']);
	$merchantId = trim_input($_GET['merchantId']);
	$setup = trim_input($_GET['setupname']);


	//Call to a function that generates invoice number
	 $invoice = assign_invoice($setup, $gatewayId);
		
	     echo '<div class="row"> <div class="col-md-12 alert alert-warning" style="margin:15px;"><p style="display:block; text-align:left"> <i class="fa fa-2x fa-warning" ></i><strong> IMPORTANT NOTICE: </strong> </p>
	            <h6> Everytime you <strong> PROCESS </strong> a payment transaction; whether or not it has been paid for, your invoice number changes. </h6> </div></div> 

	            <div class="row"> 
		           <div class="col-md-8">
		            <label class="pay-detail-form-label"> Purpose: </label>
		              <div class="input-group">
		                <span class="input-group-addon"><i class="fa fa-file"></i></span>      
		                <input class="form-control pay-detail-form" name="description" id="description" placeholder="Payment Type" readonly value="'.$invoice.'"  >
		            </div>
		          </div>
		        </div>
		        <br/>

	            <div class="row">
	              <div class="col-md-6">
		           <label class="pay-detail-form-label"> Payment Option: </label> 
	                <div class="input-group">
            	      <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
                        <select name="optionId" id="optionId" class="form-control pay-detail-form" >
                          <option value="" selected>-Select Payment Mode-</option>';

	                //To get the list of payment options available to payment gateways
					$get_option_list = $paydb->query("SELECT a.optionId, a.option_name FROM ".PAY_OPTIONS." a 
	                              INNER JOIN ".OPTION_LIST." b ON b.optionId = a.optionId
                                  WHERE a.gatewayId = '$gatewayId' AND b.merchantId = '$merchantId' ");

								while($list = $get_option_list->fetch_array())
								{
				                  echo '<option value="'.$list[0].'">'.$list[1].'</option>';
								}
              
			  		  echo '</select>
			       </div>
			      </div>
			    </div>';
}

?>
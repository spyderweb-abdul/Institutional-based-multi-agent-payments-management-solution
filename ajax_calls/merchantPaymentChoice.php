<?php

include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';

		$merchant_id = trim_input($_POST['merchant_id']);
		
		$sql = $paydb->query("SELECT * FROM ".PAYMENT_CHOICE." WHERE merchantId = '$merchant_id' ");
					
	     if(mysqli_num_rows($sql) > 0)
		  {  
         	echo '<div class="input-group">
                    <span class="input-group-addon"><b class="glyphicon glyphicon-list-alt"></b></span>
                      <select class="form-control merchant-choice-form" name="payChoice" id="payChoice" onchange="load_type()" >';			                  
                             
                             echo '<option selected="selected" value="">-PAYMENT CHOICE-</option>';
							 while($row = $sql->fetch_array())
							 {
								 echo '<option value="'.$row[0].'">'.$row[2].'</option>';
							 }
      
                 echo '</select>';
		     }
			  else
			 {
			  	echo '<span class="btn btn-proc btn-primary" id="payNull">-NO PAYMENT CHOICE LISTED YET-</span>';
			 } 
			  
    echo '</div>';


?>
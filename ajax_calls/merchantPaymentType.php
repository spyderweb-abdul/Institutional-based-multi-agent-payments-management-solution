<?php

include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';
      
		$choiceId = trim_input($_POST['payChoice']);
	    
		$payType = $paydb->query("SELECT * FROM ".PAYMENT_TYPE." WHERE choiceId = '$choiceId'");
             
			 if(mysqli_num_rows($payType))
				{
			    	echo '<div class="input-group">
           		 	<span class="input-group-addon"><b class="glyphicon glyphicon-folder-open"></b></span>
              		<select class="form-control merchant-choice-form" name="payType" id="payType">
			  
			  		<option value="" selected="selected">-PAYMENT TYPE-</option>';
				    while($row = $payType->fetch_array())
					{
                           echo '<option value="'.$row[0].'">'.$row[2].'</option>';
					}		 
   
        echo '</select></div> <br/>';
        echo '<button data-toggle="modal" data-target="#myModal" class="btn btn-proc procs btn-success" onclick="get_choice_value()" > Process Payment </button>';  

			  }
			 else
			 {
			  	echo '<span class="btn btn-proc btn-primary">-NO PAYMENT TYPE LISTED YET-</span>';
			 } 
        
		
             
?>
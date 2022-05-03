<?php
include_once '../config/connections/constant_connection.php';
include_once '../config/constant_define/constants.php';
include_once '../config/functions/control_functions.php';


	$userId = trim_input($_POST['userId']);
     
     //UserId not more than 8 characters
	if(strlen($userId) == 8)
	{
			$sel_user = $paydb->query("SELECT * FROM ".USERS."  WHERE userId = '$userId'");

			if(mysqli_num_rows($sel_user) == 1)
			{
				//$fetchDetails = $sel_user->fetch_array();

			        echo '<div class="form-group has-feedback">
			                     <input type="Password" class="form-control" name="securecode" id="securecode" placeholder="Password"  >
			                     <i class="glyphicon glyphicon-lock form-control-feedback right" aria-hidden="true"></i>
			               </div>
			               
	                <button type="button" class="btn btn-success" id="btn-logUser"> Login to your account </button> <br/>';
			}
			else
			{
				echo '<h6 style="color: red"> *User ID Not Found </h6>';
			}

	}

?>
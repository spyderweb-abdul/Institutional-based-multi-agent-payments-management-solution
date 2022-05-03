<?php
session_start( );
$_SESSION['userID'] = $_POST['userID'];
if (!isset($_SESSION['userID']))
	  {
		  die ('ERROR: You attempted to access a restricted page. Please <a href=logoutAdminNow.php> Log In </a>' );
	  }

      include_once('../include/constant_connection.php');
		 		   
		   $userID = $_POST['userID'];
		   $passCode = $_POST['passCode'];
		   		   
		   $sql = $paydb->query("SELECT * FROM ".TBL_ADMIN." WHERE userID = '$userID' AND passcode = '$passCode' ");
		 
	        
			if(mysqli_num_rows($sql) == 1){
				
				echo '<div class="alert alert-success styleTb" style="text-align:center"> Login credentials Verified OK - <a href="#" id="redir">Click to proceed </a>';
			}
			else
			{
				echo '<div class="alert alert-danger styleTb" style="text-align:center"> User ID or Password Not Match - Verification Failed! </div>';
			}
					
  ?>
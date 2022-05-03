<?php
require_once('../../include/constant_connection.php');

                      $feeItem = mysql_real_escape_string(trim($_POST['feeItem']));
					  $amount = mysql_real_escape_string(trim($_POST['amount']));
					 // $scholarship_applied = mysql_real_escape_string(trim($_POST['scholarship_applied']));
					  
					  $find = $paydb->query("SELECT * FROM ".TBL_FEE_ITEMS." WHERE feeItem = '$feeItem' AND amount = '$amount'");
					  $num = mysqli_num_rows($find);
					  
					 if($num > 0)
					 {
						 echo '<div class="alert alert-danger styleTb2"> This Fee Item already exist </div>';
					 }
					 else
					 {
						  $postFee = $paydb->query("INSERT INTO ".TBL_FEE_ITEMS." (feeItem, amount) values ('$feeItem', '$amount')");
						  
						  if($postFee == TRUE)
						  {
							  echo '<div class="alert alert-success styleTb2">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  Fee Successfully Created 
							  </div>';
						  }
					 }

?>
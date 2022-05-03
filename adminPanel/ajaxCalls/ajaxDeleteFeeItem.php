<?php
 include_once('../../include/constant_connection.php');
 
			 if(isset($_GET['cmdelete']))
			 {
			 $UID = $_GET['cmdelete'];
			 }
			 
			 $fetch = $paydb->query("DELETE FROM ".TBL_FEE_ITEMS." WHERE feeID ='$UID'");
			 
			 if($fetch == TRUE)
			 {
				 echo '<div class="alert alert-success fade in styleTb2"> Fee Item deleted successfully.</div>';
			 }
			 else
			 {
				 echo '<div class="alert alert-danger fade in styleTb2">
				 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 Operation Failed.</div><br/>';
			 }
			 
		

?>
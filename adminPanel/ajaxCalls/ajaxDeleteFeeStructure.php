<?php
 include_once('../../include/constant_connection.php');
 
			//if(isset($_GET['delet']))//this deletes from fee_structure_table
		      // {	
			   		 
			 $prog = $_GET['prog'];
			 $nation = $_GET['nat'];
			 $level = $_GET['lev'];
	 
			 $fetchDel = $paydb->query("DELETE FROM ".TBL_FULL_FEE_STRUCTURE." WHERE prog ='$prog' AND nationality = '$nation' AND level = '$level'");
			 $fetchDel2 = $paydb->query("DELETE FROM ".TBL_FEE_STRUCTURE." WHERE prog ='$prog' AND nationality = '$nation' AND level = '$level'");

			 if($fetchDel == TRUE)
			 {
				 echo '<div class="alert alert-success styleTb2">Programme fee structure deleted successfully.</div>';
				 
			 }
			 else
			 {
				 echo '<div class="alert alert-danger styleTb"> Deletion Not Successful. Try Again! </div>';
			 }
		// }
			 
		

?>
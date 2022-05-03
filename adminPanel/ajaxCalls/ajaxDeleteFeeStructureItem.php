<?php
session_start();
 include_once('../../include/constant_connection.php');
 
			 if(isset($_GET['cmdelete']))
			 {
			 $feeID = $_GET['cmdelete'];
			 }
		
$del = $paydb->query("DELETE FROM ".TBL_FEE_STRUCTURE." WHERE feeID ='$feeID' AND prog = '$_SESSION[prog]' AND level = '$_SESSION[lev]' AND nationality = '$_SESSION[nat]'");
			 
			 if($del == TRUE)
			 {
				  //Try to rebuild the fee amount in the structure_full_table
		 $amount = 0;
	     $s = $paydb->query("SELECT feeID FROM ".TBL_FEE_STRUCTURE." WHERE prog = '$_SESSION[prog]' AND level = '$_SESSION[lev]' AND nationality = '$_SESSION[nat]'");
		 while ($r = mysqli_fetch_array($s))
		 {
			 $feeid = $r['feeID'];
			 
			 $amtID = $paydb->query("SELECT amount FROM ".TBL_FEE_ITEMS." WHERE feeID = '$feeid'");
			 $a = mysqli_fetch_array($amtID);
			 
			 $amt = $a['amount'];
			 
			 $amount += $amt;
		 }
					
$upd = $paydb->query("UPDATE ".TBL_FULL_FEE_STRUCTURE." SET amount = '$amount' WHERE prog = '$_SESSION[prog]' AND level = '$_SESSION[lev]' AND nationality = '$_SESSION[nat]'");
									
		if($upd == TRUE)
		{ 			 
		  echo '<div class="alert alert-success fade in styleTb2"> Fee Item deleted successfully and new fee amount updated. </div>';
		}
		else
		{
		  echo '<div class="alert alert-warning styleTb2"> New total amount caanot be updated. Please check and try again </div>';	
		}
}
 else
{
				 echo '<div class="alert alert-danger fade in styleTb2">
				 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 Operation Failed.</div><br/>';
}

?>
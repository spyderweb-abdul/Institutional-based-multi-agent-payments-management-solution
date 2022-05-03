<?php
session_start();
 include_once('../../include/constant_connection.php');
   
			$feeID = mysql_real_escape_string(trim($_POST['feeID']));	
	
	//First, insert newly added Item into fee_structure_table		
$insert = $paydb->query("INSERT INTO ".TBL_FEE_STRUCTURE." (facName, deptName, prog, level, feeID, nationality) VALUES ('$_SESSION[facName]','$_SESSION[deptName]', '$_SESSION[prog]', '$_SESSION[lev]', '$feeID', '$_SESSION[nat]')");

if($insert = TRUE)//If insertion was successful, do:
{
	     $amount = 0;  //Initialize amount - to sum up the total amount extracted in each of the iterations
		 
		 //Select the particular feeID based on condition
	     $s = $paydb->query("SELECT feeID FROM ".TBL_FEE_STRUCTURE." WHERE prog = '$_SESSION[prog]' AND level = '$_SESSION[lev]' AND nationality = '$_SESSION[nat]'");
		 while ($r = mysqli_fetch_array($s)) //Iteration starts here
		 {
			 $feeid = $r['feeID'];  //Get the feeID
			 
			 $amtID = $paydb->query("SELECT amount FROM ".TBL_FEE_ITEMS." WHERE feeID = '$feeid'"); //Select the specific amount allocated to the feeID
			 $a = mysqli_fetch_array($amtID);
			 
			 $amt = $a['amount']; //Get the amount
			 
			 $amount += $amt;  //Sum amount and re-iterate
		 }
				
	//Update the sum amount in the fee_structure_full_table				
$upd = $paydb->query("UPDATE ".TBL_FULL_FEE_STRUCTURE." SET amount = '$amount' WHERE prog = '$_SESSION[prog]' AND level = '$_SESSION[lev]' AND nationality = '$_SESSION[nat]'");
									
		if($upd == TRUE) //If update query was successful, flag success message
		{ 			 
		  echo '<div class="alert alert-success fade in styleTb2"> Fee Item added successfully and new fee amount updated. </div>';
		}
		else  //else, do this:
		{
		  echo '<div class="alert alert-warning styleTb2"> New total amount caanot be updated. Please check and try again </div>';	
		}
}
 else   //Else if Insertion was unsuccessful
{
				 echo '<div class="alert alert-danger fade in styleTb2">
				 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 Operation Failed.</div><br/>';
}

?>
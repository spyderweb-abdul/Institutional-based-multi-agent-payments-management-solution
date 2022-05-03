<?php
 include_once('../../include/constant_connection.php');
 
                      $feeItem = mysql_real_escape_string(trim($_POST['feeItem']));
					  $amount = mysql_real_escape_string(trim($_POST['amount']));
					  $feeID = mysql_real_escape_string(trim($_POST['feeID']));
						
						//First, select amount associated with the feeID
						$selAmount = $paydb->query("SELECT amount FROM ".TBL_FEE_ITEMS." WHERE feeID = '$feeID'");
						$s = mysqli_fetch_array($selAmount);
						
						$currentAmount = $s['amount']; //Get an amount as $currentAmount
						
						$maximum = max($amount, $currentAmount); //Get the maximum of the two values i.e the current amount in the database and the newly entered value				 
												
						//Update the fee_item_table with the new value
						$upd_item = $paydb->query("UPDATE ".TBL_FEE_ITEMS." SET feeItem = '$feeItem', amount = '$amount' WHERE feeID = '$feeID' ");
						
						if($upd_item == TRUE)//If update query executes successfully, do:
						{
							//get each programme, nationality, level associated with the feeID
							$getProg = $paydb->query("SELECT prog, nationality, level FROM ".TBL_FEE_STRUCTURE." WHERE feeID = '$feeID'");
							 while($p = mysqli_fetch_array($getProg))//Start an iteration for each selection of the programme
							{
								$prog = $p['prog']; //Get a programme
								$nation = $p['nationality']; //Get nationality
								$level = $p['level'];  //Get level
								
								//Select amount associated with that programme, antionality and level in the structure_full_table
								$getAmount = $paydb->query("SELECT amount FROM ".TBL_FULL_FEE_STRUCTURE." WHERE prog = '$prog' AND nationality = '$nation' AND level = '$level'");
								$g = mysqli_fetch_array($getAmount);
								
								$progAmount = $g['amount']; //Get an amount
								
								 if($maximum == $amount) //Now, if maximum amount is the newly entered amount, do:
								 { 
								    $difference = $amount - $currentAmount;  //Get the difference between the newly entered and the current amount from the database
								    $newAmount =  $progAmount + $difference; //Add the difference to the current programme amount to give a new amount								 
								 
								 }
								 elseif ($maximum == $currentAmount) //else if the maximum amount is the current amount from the database, do:
								 {
								 	 $difference = $currentAmount - $amount;  //Get the difference between the current amount from the db and the newly entered amount
									 $newAmount = $progAmount - $difference;  //Subtract the current amount from the current programme amount
								 }
								 else //If values reamin the same
								 {
									 $newAmount = $progAmount; 
								 }
	                             
								 
								
								//Update the new amount agains the selected programme, nationality and level and re-iterate
								$newUpd = $paydb->query("UPDATE ".TBL_FULL_FEE_STRUCTURE." SET amount = '$newAmount' WHERE prog = '$prog' AND nationality = '$nation' AND level = '$level'");
							}						
							  
							   
							//success message
							echo '<div class="alert alert-success fade in styleTb2"> Fee Item Edited successfully and new fees have been built.</div>';
						}
			            else //else, error
			            {
				              echo '<div class="alert alert-danger fade in styleTb2">
				              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				              Operation Failed.</div><br/>';
			            }
			 
		

?>
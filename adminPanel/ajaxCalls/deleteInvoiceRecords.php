<?php
 include_once('../../include/constant_connection.php');
 
       if(isset($_POST['id']))
	   {  		
			$payID = $_POST['id'];			
			$payid = explode(",", $payID);
			
			$i = 0;
			
			foreach($payid as $x)
			{
				//First select the payment type associated with the ID
				$sel = $paydb->query("SELECT * FROM ".TBL_PAYMENTS_RECORD." WHERE id = '$x'");
				$rec = mysqli_fetch_array($sel);
				
				$payType = $rec['paymentType']; //Get the payment type
				$orderID = $rec['orderID']; //Get the order ID;
				$userId = $rec['userId']; //Get the payer ID
				
				echo $orderID." ".$userId." ".$payType;
				
				if($payType == "PG REGISTRATION")
				{
					//Delete all records associated with order ID in fees_order
					$del_fees_order = $pgdb->query("DELETE FROM fees_order WHERE trans_id = '$orderID' ");
					
					//Delete all records associated with order ID in fees_summary 
					$del_fees_summary = $pgdb->query("DELETE FROM fees_summary WHERE trans_id = '$orderID' ");
				}
				
				//Delete record associated with order ID in payments_record
				$del = $paydb->query("DELETE FROM ".TBL_PAYMENTS_RECORD." WHERE id = '$x' ");
				
				$i = 1;
			}
			  
			  
			if($i == 1)
			{
			 	$fetch = $paydb->query("SELECT * FROM ".TBL_PAYMENTS_RECORD." WHERE userId = '$userId' ");
			 
			 if(mysqli_num_rows($fetch) > 0)
			 	{
					echo '<div class="alert alert-success styleTb"> Record deleted successfully </div><br/>';
					
				  echo '<form name="frm-del" id="frm-del" method="post" > <table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb">';
				   
				   echo '<tr><th>  </th>';
				   echo '<th> Payer ID </th>';
				   echo '<th> Name of Payer </th>';
				   echo '<th> Transaction ID </th>';
				   echo '<th> Description </th>';
				   echo '<th> Session </th>';
				   echo '<th> Amount Payable</th>';
				   echo '<th> Status </th>';
				   echo '</tr>';
				   
				   while($row = mysqli_fetch_array($fetch)){
					 echo '<tr>';
					 echo '<td> 
					      <input type="checkbox" name="id[]" id="id" value="'.$row['id'].'" style="height:auto; box-shadow:none; border:#CCC thin" />
					  </td>';
					 echo '<td>'. $row['userId'] .'</td>';
					 echo '<td>'. $row['payerName'] .'</td>';
					 echo '<td>'. $row['orderID'] .'</td>';
 					 echo '<td>'. $row['paymentType'] .'</td>';
					 echo '<td>'. $row['session'] .'</td>';
					 echo '<td>'. $row['amount'] .'</td>';
					 echo '<td>'. $row['payment_status'] .'</td>'; 
					 echo '</tr>';   
				   }
			echo '<tr><td colspan=8> <input type="button" name="delete-invoice" id="delete-invoice" value="Delete Invoice(s)" class="btn btn-danger btn-sm" /> </td></tr></table></form>';
			 }
			 else
			 {
				 echo '<div class="alert alert-danger styleTb"> There\'s no record for this Payer ID </div>';
			 }
			 
	  }
	  else
	  {
				 echo '<div class="alert alert-danger styleTb"> Delete Operation Failed </div>';
	  }
	  
	   }

?>
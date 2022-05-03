<?php
 include_once('../../include/constant_connection.php');
  		
			$userId = $_POST['payer_id'];
			 
			 $fetch = $paydb->query("SELECT * FROM ".TBL_PAYMENTS_RECORD." WHERE userId = '$userId' ");
			 			 
			 if(mysqli_num_rows($fetch) > 0)
			 {
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
			echo '<tr><td colspan="8"> <input type="button" name="delete-invoice" id="delete-invoice" value="Delete Invoice(s)" class="btn btn-danger btn-sm" /> </td></tr></table></form>';
			 }
			 else
			 {
				 echo '<div class="alert alert-danger styleTb"> There\'s no record for this Payer ID </div>';
			 }
			 
		

?>

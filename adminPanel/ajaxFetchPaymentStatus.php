<?php
include_once('../include/connect.php');

$paymentType = $_POST['paymentType'];
$payment_status = $_POST['status'];
$session = $_POST['session'];


$chk = mysql_query("SELECT * FROM payments_record WHERE paymentType = '$paymentType' AND payment_status = '$payment_status' AND session = '$session'"); 
if(mysql_num_rows($chk) > 0)
{
	    $i = 1;
	              echo '<table border="0" class=" table-bordered table-condensed table-striped table-hover styleTb img-thumbnail"><tr>';
				  echo '<td colspan="10">';
				  if($payment_status == 'PAID')
				  {
					  $p = mysql_query("SELECT SUM(amount), COUNT(id) FROM payments_record WHERE paymentType = '$paymentType' AND payment_status = '$payment_status' AND session = '$session'");
					  $f = mysql_fetch_array($p);
					  $num = mysql_num_rows($p);
					  
					  if($num > 0)
					  {
						  echo '<strong>TOTAL No. OF RECORD: </strong>'.$f['COUNT(id)'];
						  echo '<br/><br/>';
						  echo '<strong>TOTAL AMOUNT: </strong>'.number_format($f['SUM(amount)']);
						  echo '<br/><br/>';
						  echo '<strong>PAYMENT TYPE: </strong>'.$paymentType;
					  }
				  }
				  echo '<div style="text-align:right"><a href="excelExportPayment.php?type='.$paymentType.'&status='.$payment_status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div>';
				  
				  echo '</td></tr>';
				  echo '<tr>';
				   echo '<td> <strong>S/No.</strong> </td>';
				   echo '<td> <strong>PAYER ID</strong> </td>';
				   echo '<td> <strong>PAYER\'S NAME</strong> </td>';
				   echo '<td><strong> ORDER ID</strong> </td>';
				   echo '<td> <strong>PHONE NO.</strong> </td>';
				   echo '<td> <strong>TRANS ID</strong> </td>';
				   echo '<td> <strong>AMOUNT</strong> </td>';
				   echo '<td> <strong>CHANNEL</strong> </td>';
				   echo '<td> <strong>STATUS</strong> </td>';
				   echo '<td> <strong>SESSION</strong> </td>';
				   echo '</tr>';
	             while($ft = mysql_fetch_array($chk))
	              {
					  echo '<tr>';
					  echo '<td>'.$i.'</td>';
					  echo '<td>'.$ft['userId'].'</td>';
					  echo '<td>'.$ft['payerName']. '</td>';
					  echo '<td>'.$ft['orderID'].'</td>';
					  echo '<td>'.$ft['payerPhone'].'</td>';
					  echo '<td>'.$ft['transactionID'].'</td>';
					  echo '<td>'.$ft['amount'].'</td>';
					  echo '<td>'.$ft['channel'].'</td>';
					  echo '<td>'.$ft['payment_status'].'</td>';
					  echo '<td>'.$ft['session'].'</td>';
					  $i++;
		
	              }
				  
				  echo '</tr></table>';
}
else
{
	echo '<div class="alert alert-danger styleTb"> There\'s no payment records for these options </div>';
}

?>
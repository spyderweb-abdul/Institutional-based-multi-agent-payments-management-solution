<?php
 require_once('../../include/constant_connection.php');	

$paymentType = $_POST['paymentType'];
$payment_status = $_POST['status'];
$session = $_POST['session'];

//If selection is UG Registration fee on eduerp
if($paymentType == "UG REGISTRATION FEE")
{
	
 if($payment_status == "PAID") {$payment_status = "payment_received";} 
 
 
 $chk = $edudb->query("SELECT jambno, order_id, SUM(price), status, fullnames, session, email, programme FROM ".TBL_FEES_ORDER." WHERE status = '$payment_status' AND session = '$session' AND level_name >= 100 
 AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' GROUP BY jambno");
 $c = mysqli_num_rows($chk);
 
 if($c > 0)
 {
 
 $i = 1;
	              echo '<table border="0" class=" table-bordered table-condensed table-striped table-hover styleTb img-thumbnail"><tr>';
				  echo '<td colspan="10">';
				  if($payment_status == 'payment_received')
				  {
					  $p = $edudb->query("SELECT SUM(price) FROM ".TBL_FEES_ORDER." WHERE status = '$payment_status' AND session = '$session'
					  AND level_name >= 100 AND programme <> 'General Fee Structure' AND programme <> 'Matriculation'");
					  $f = mysqli_fetch_array($p);
					  $num = mysqli_num_rows($p);
					  
					  if($num > 0)
					  {
						  echo '<strong>TOTAL No. OF RECORD: </strong>'.$c;
						  echo '<br/><br/>';
						  echo '<strong>TOTAL AMOUNT: </strong>'.number_format($f['SUM(price)']);
						  echo '<br/><br/>';
						  echo '<strong>PAYMENT TYPE: </strong> UG REGISTRATION FEE';
					  }
				  }
				  echo '<div style="text-align:right"><a href="excelCalls/excelUGRegFee.php?type='.$paymentType.'&status='.$payment_status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div>';
				  
				  echo '</td></tr>';
				  echo '<tr>';
				   echo '<td> <strong>S/No.</strong> </td>';
				   echo '<td> <strong>PAYER ID</strong> </td>';
				   echo '<td> <strong>PAYER\'S NAME</strong> </td>';
				   echo '<td><strong> ORDER ID</strong> </td>';
				   echo '<td> <strong>TRANS ID</strong> </td>';
				   echo '<td> <strong>AMOUNT</strong> </td>';
				   echo '<td> <strong>PROG.</strong> </td>';
				   echo '<td> <strong>STATUS</strong> </td>';
				   echo '<td> <strong>SESSION</strong> </td>';
				   echo '</tr>';
	             while($ft = mysqli_fetch_array($chk))
	              {
					  echo '<tr>';
					  echo '<td>'.$i.'</td>';
					  echo '<td>'.$ft['jambno'].'</td>';
					  echo '<td>'.strtoupper($ft['fullnames']). '</td>';
					  echo '<td>'.$ft['order_id'].'</td>';
					  echo '<td>'.$ft['email'].'</td>';
					  echo '<td>'.number_format($ft['SUM(price)']).'</td>';
					  echo '<td>'.$ft['programme'].'</td>';
					  echo '<td>'.$ft['status'].'</td>';
					  echo '<td>'.$ft['session'].'</td>';
					  $i++;
		
	              }
				  
				  echo '</tr></table>';
}
else
{
	echo '<div class="alert alert-danger styleTb"> There\'s no payment records for these options </div>';
}

}

//Ends here


//Else if selection is PG Registration fee (Eduerp) on eduerp
elseif($paymentType == "PG REGISTRATION FEE (EduERP)"){
 
 if($payment_status == "PAID") { $payment_status = "payment_received"; } 
  
 $chk = $edudb->query("SELECT jambno, order_id, SUM(price), status, fullnames, session, email, programme FROM ".TBL_FEES_ORDER." WHERE status = '$payment_status' AND session = '$session' AND level_name < 100 AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' GROUP BY jambno");
 $c = mysqli_num_rows($chk);
 
 if($c > 0)
 {
 
 $i = 1;
	              echo '<table border="0" class=" table-bordered table-condensed table-striped table-hover styleTb img-thumbnail"><tr>';
				  echo '<td colspan="10">';
				  if($payment_status == 'payment_received')
				  {
					  $p = $edudb->query("SELECT SUM(price) FROM ".TBL_FEES_ORDER." WHERE status = '$payment_status' AND session = '$session'
					  AND level_name < 100 AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' ");
					  $f = mysqli_fetch_array($p);
					  $num = mysqli_num_rows($p);
					  
					  if($num > 0)
					  {
						  echo '<strong>TOTAL No. OF RECORD: </strong>'.$c;
						  echo '<br/><br/>';
						  echo '<strong>TOTAL AMOUNT: </strong>'.number_format($f['SUM(price)']);
						  echo '<br/><br/>';
						  echo '<strong>PAYMENT TYPE: </strong> PG REGISTRATION FEE (EDUERP)';
					  }
				  }
				  echo '<div style="text-align:right"><a href="excelCalls/excelPGRegFee-EDUERP.php?type='.$paymentType.'&status='.$payment_status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div>';
				  
				  echo '</td></tr>';
				  echo '<tr>';
				   echo '<td> <strong>S/No.</strong> </td>';
				   echo '<td> <strong>PAYER ID</strong> </td>';
				   echo '<td> <strong>PAYER\'S NAME</strong> </td>';
				   echo '<td><strong> ORDER ID</strong> </td>';
				   echo '<td> <strong>TRANS ID</strong> </td>';
				   echo '<td> <strong>AMOUNT</strong> </td>';
				   echo '<td> <strong>PROG.</strong> </td>';
				   echo '<td> <strong>STATUS</strong> </td>';
				   echo '<td> <strong>SESSION</strong> </td>';
				   echo '</tr>';
	             while($ft = mysqli_fetch_array($chk))
	              {
					  echo '<tr>';
					  echo '<td>'.$i.'</td>';
					  echo '<td>'.$ft['jambno'].'</td>';
					  echo '<td>'.strtoupper($ft['fullnames']). '</td>';
					  echo '<td>'.$ft['order_id'].'</td>';
					  echo '<td>'.$ft['email'].'</td>';
					  echo '<td>'.number_format($ft['SUM(price)']).'</td>';
					  echo '<td>'.$ft['programme'].'</td>';
					  echo '<td>'.$ft['status'].'</td>';
					  echo '<td>'.$ft['session'].'</td>';
					  $i++;
		
	              }
				  
				  echo '</tr></table>';
}
else
{
	echo '<div class="alert alert-danger styleTb"> There\'s no payment records for these options </div>';
}

}
//Ends here

//Else if selection is UG Acceptance Fee, do
elseif($paymentType == "UG ACCEPTANCE FEE"){
   
 $chk = $admdb->query("SELECT * FROM acceptance_payment_2016 WHERE status = '$payment_status' AND session = '$session'");
 $c = mysqli_num_rows($chk);


 
 if($c > 0)
 {
 
 $i = 1;
	              echo '<table border="0" class=" table-bordered table-condensed table-striped table-hover styleTb img-thumbnail"><tr>';
				  echo '<td colspan="10">';
				  if($payment_status == 'PAID')
				  {
					  $p = $admdb->query("SELECT SUM(amt) FROM acceptance_payment_2016 WHERE status = '$payment_status' AND session = '$session' ");
					  $f = mysqli_fetch_array($p);
					  $num = mysqli_num_rows($p);
					  
					  if($num > 0)
					  {
						  echo '<strong>TOTAL No. OF RECORD: </strong>'.$c;
						  echo '<br/><br/>';
						  echo '<strong>TOTAL AMOUNT: </strong>'.number_format($f['SUM(amt)']);
						  echo '<br/><br/>';
						  echo '<strong>PAYMENT TYPE: </strong> UG ACCEPTANCE FEE';
					  }
				  }
				  echo '<div style="text-align:right"><a href="excelCalls/excelUGAcceptanceFee.php?type='.$paymentType.'&status='.$payment_status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div>';
				  
				  echo '</td></tr>';
				  echo '<tr>';
				   echo '<td> <strong>S/No.</strong> </td>';
				   echo '<td> <strong>PAYER ID</strong> </td>';
				   echo '<td> <strong>PAYER\'S NAME</strong> </td>';
				   echo '<td> <strong>TRANS ID</strong> </td>';
				   echo '<td> <strong>AMOUNT</strong> </td>';
				   echo '<td> <strong>STATUS</strong> </td>';
				   echo '<td> <strong>SESSION</strong> </td>';
				   echo '</tr>';
	             while($ft = mysql_fetch_array($chk))
	              {
					   $jambNo = $ft['jambNo'];
					   
					   $fet = $admdb->query("SELECT name FROM admission_2015_2016 WHERE jambNo = '$jambNo'");
					   $f = mysqli_fetch_array($fet);
					   
					  echo '<tr>';
					  echo '<td>'.$i.'</td>';
					  echo '<td>'.$ft['jambNo'].'</td>';
					  echo '<td>'.strtoupper($f[0]). '</td>';
					  echo '<td>'.$ft['rrr'].'</td>';
					  echo '<td>'.number_format($ft['amt']).'</td>';
					  echo '<td>'.$ft['status'].'</td>';
					  echo '<td>'.$ft['session'].'</td>';
					  $i++;
		
	              }
				  
				  echo '</tr></table>';
}
else
{
	echo '<div class="alert alert-danger styleTb"> There\'s no payment records for these options </div>';
}

}
//End Here


//Else display any selection condition from the payment system database
else
{
		
$chk = $paydb->query("SELECT * FROM ".TBL_PAYMENTS_RECORD." WHERE paymentType = '$paymentType' AND payment_status = '$payment_status' AND session = '$session'"); 
$c = mysqli_num_rows($chk);


if($c > 0)
{
	    $i = 1;
	              echo '<table border="0" class=" table-bordered table-condensed table-striped table-hover styleTb img-thumbnail"><tr>';
				  echo '<td colspan="10">';
				  if($payment_status == 'PAID')
				  {
					  $p = $paydb->query("SELECT SUM(amount), COUNT(id) FROM ".TBL_PAYMENTS_RECORD." WHERE paymentType = '$paymentType' AND payment_status = '$payment_status' AND session = '$session'");
					  $f = mysqli_fetch_array($p);
					  $num = mysqli_num_rows($p);
					  
					  if($num > 0)
					  {
						  echo '<strong>TOTAL No. OF RECORD: </strong>'.$f['COUNT(id)'];
						  echo '<br/><br/>';
						  echo '<strong>TOTAL AMOUNT: </strong>'.number_format($f['SUM(amount)']);
						  echo '<br/><br/>';
						  echo '<strong>PAYMENT TYPE: </strong>'.$paymentType;
					  }
				  }
				  echo '<div style="text-align:right"><a href="excelCalls/excelExportPayment.php?type='.$paymentType.'&status='.$payment_status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div>';
				  
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
	             while($ft = mysqli_fetch_array($chk))
	              {
					  echo '<tr>';
					  echo '<td>'.$i.'</td>';
					  echo '<td>'.$ft['userId'].'</td>';
					  echo '<td>'.$ft['payerName']. '</td>';
					  echo '<td>'.$ft['orderID'].'</td>';
					  echo '<td>'.$ft['payerPhone'].'</td>';
					  echo '<td>'.$ft['transactionID'].'</td>';
					  echo '<td>'.number_format($ft['amount']).'</td>';
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

}

?>
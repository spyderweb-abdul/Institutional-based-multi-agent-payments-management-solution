 <?php
 
 include_once('../include/connect.php');
 
 $session = $_POST['session'];
	     
		 $rep = mysql_query("SELECT paymentType FROM payments_record WHERE session = '$session' GROUP BY paymentType ORDER BY paymentType ASC") or die (mysql_error());
		 
		 if(mysql_num_rows($rep) > 0)
		 {
		 $x = 1;
		 echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb"><tr>';
		 echo '<th> S/No. </th>';
		 echo '<th> Payment Type </th>';
		 echo '<th> Total Amount (=N=)</th>';
		 echo '</tr>';
		 
		 echo '<tr>';
		 while ($f = mysql_fetch_array($rep))
		 {
			 $paymentType = $f['paymentType'];
			 
			 echo '<td>'.$x.'</td>';
			 echo '<td>'.$paymentType.'</td>';
			 echo '<td>';
			 
			   $amt = mysql_query("SELECT SUM(amount) FROM payments_record WHERE paymentType = '$paymentType' AND session = '$session' AND payment_status = 'PAID' ");
			   $a = mysql_fetch_array($amt);
			   
			   echo '<strong>'.number_format($a['SUM(amount)'], 2).'</strong>';
			 
			 echo '</td>';
			 echo '</tr>';
			 $x++;
			 
		 }
		 
		  echo '<tr><td> </td>';
		  echo '<td> UG REGISTRATION FEES </td>';
		  
		  echo '<td>';
		  
		  include('../include/eduerp_connect.php');
		  
		  	$fee = mysql_query("SELECT SUM(original_amount) AS total FROM fees_order WHERE status='payment_received' AND session = '$session' ");
			$totFee = mysql_fetch_array($fee);
			
			$totalFee = $totFee['total'];

		  echo '<strong>'.number_format($totalFee, 2).'</strong>';
		  
		  echo '</td></tr>';
		    echo '<tr><td colspan="3">';
			
			include('../include/connect.php');
			  $sum = mysql_query("SELECT SUM(amount) FROM payments_record WHERE session = '$session' AND payment_status = 'PAID'");
			  $tot = mysql_fetch_array($sum);
			  
			  $genTot = $tot['SUM(amount)'] + $totalFee;			  
			  
			  echo '<div class="btn btn-default styleTb"><i class="fa fa-2x fa-money"></i>&nbsp; <strong> Total Sum Generated: N'.number_format($genTot, 2).' </strong></div>';
			echo '</td></tr>';
		    echo '</table>';
		 }
		 else
		 {
			 '<div class="alert alert-danger"> No Available Payment Summary For this Session</div>';
		 }
	   
	   ?>
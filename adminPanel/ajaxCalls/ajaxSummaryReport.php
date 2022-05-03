 <?php
 
 include_once('../../include/constant_connection.php');
 
 $session = $_POST['session'];
 
      
	    //Selecting all payment types from  the payment system without the PG Registration records
		 $rep = $paydb->query("SELECT paymentType FROM ".TBL_PAYMENTS_RECORD." WHERE session = '$session' AND description <> 'PG REGISTRATION FEE' GROUP BY paymentType ORDER BY paymentType ASC");
		 
		 if(mysqli_num_rows($rep) > 0)
		 {
		 $x = 1;
		 echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb"><tr>';
		 echo '<th> S/No. </th>';
		 echo '<th> Payment Type </th>';
 		 echo '<th> No. of Depositors </th>';
		 echo '<th> Total Amount (=N=)</th>';
		 echo '</tr>';
		 
		 echo '<tr>';
		 		 
		 $sum = 0;
		 
		 while ($f = mysqli_fetch_array($rep))
		 {
			 $paymentType = $f['paymentType'];
			 
		$con = $paydb->query("SELECT * FROM ".TBL_PAYMENTS_RECORD." WHERE paymentType = '$paymentType' AND session = '$session' AND payment_status = 'PAID' ");
			 $c = mysqli_num_rows($con);
			 
			  echo '<td>'.$x.'</td>';
			  echo '<td>'.$paymentType.'</td>';
			  echo '<td>'.$c.'</td>';

			 echo '<td>';

			 //Selecting all other payments from the payment system without 'PG REGISTRATION FEE' into a loop
			   $amt = $paydb->query("SELECT SUM(amount) AS totsum FROM ".TBL_PAYMENTS_RECORD." WHERE paymentType = '$paymentType' AND session = '$session' 
			   AND payment_status = 'PAID' AND description <> 'PG REGISTRATION FEE'");
			   $a = mysqli_fetch_array($amt);
			   
			   echo '<strong>'.number_format($a['totsum'], 2).'</strong>';
			 
			 echo '</td>';
			 echo '</tr>';
			 $x++;
			 
			 $sum = $sum + $a['totsum'];
			 
		 }
		    
			/*echo '<tr><td>'.$x++.' </td>';
		  	  		  
		
		  //Trying to select UG Acceptance payment from putme portal
		    $putme = mysql_query("SELECT SUM(amt), COUNT(jambNo) FROM acceptance_payment_2016 WHERE status = 'PAID' AND session = '$session' ", $admdb);
			//$c = mysql_num_rows($putme);
			$p = mysql_fetch_array($putme);
			
			$putmeFee = $p['SUM(amt)'];
			
			//
		  echo '<td> UG ACCEPTANCE FEE </td>';
		   echo '<td>'.$p['COUNT(jambNo)']. '</td>';
		  
		  echo '<td>';
		  $putmeAmt = $p['SUM(amt)'];

		  echo '<strong>'.number_format($putmeAmt, 2).'</strong>';
		  
		  echo '</td></tr>';
		  */
		  //
		 
		 //Selecting ONLY 'PG REgistration Fees' from the pg portal
			   $pgamt = $pgdb->query("SELECT SUM(amount) AS totpgsum FROM fees_order WHERE session = '$session' AND payment_status = 'PAID'");
			   $pga = mysqli_fetch_array($pgamt);
			   
			   $pgamount = $pga['totpgsum'];
		 
		  echo '<tr><td>'.$x++.' </td>';
		  		  		  
		  //Trying to select PG registration payments from eduerp
			$edufee = $edudb->query("SELECT SUM(price) AS pgtotal FROM ".TBL_FEES_ORDER." WHERE level_name < 100
			AND status ='payment_received' AND session = '$session' AND programme <> 'Matriculation' AND programme <> 'General Fee Structure' 
			AND programme NOT LIKE '%Bachelor%' ");
			$eduTotFee = mysqli_fetch_array($edufee);
				
			$pgfee = $eduTotFee['pgtotal'];
		  
		  //Trying to select UG registration payments fron eduerp
		  	$fee = $edudb->query("SELECT SUM(price) AS total FROM ".TBL_FEES_ORDER." WHERE level_name >= 100 AND status='payment_received' AND session = '$session' AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' ");
			$totFee = mysqli_fetch_array($fee);
			
			$totalFee = $totFee['total'];
			
			//
		  echo '<td> UG REGISTRATION FEES </td>';
		   echo '<td>';
		   
		   //Count ug depositors from eduerp
		   $eugc = $edudb->query("SELECT * FROM ".TBL_FEES_ORDER." WHERE level_name >= 100
			AND status ='payment_received' AND session = '$session' AND programme <> 'Matriculation' AND programme <> 'General Fee Structure' 
		    GROUP BY jambno ");
			$euc = mysqli_num_rows($eugc);
			
			echo $euc;

		   
		   echo '</td>';
		  
		  echo '<td>';

		  echo '<strong>'.number_format($totalFee, 2).'</strong>';
		  
		  echo '</td></tr>';
		  
		  //
		  
		   echo '<tr><td> '.$x++.'</td>';
		  echo '<td> PG REGISTRATION FEES </td>';
		  echo '<td>';
		  
		  
		   //Count ug depositors from eduerp
		   $epgc = $edudb->query("SELECT * FROM ".TBL_FEES_ORDER." WHERE level_name < 100
			AND status ='payment_received' AND session = '$session' AND programme <> 'Matriculation' AND programme <> 'General Fee Structure' 
		    AND programme NOT LIKE '%Bachelor%' GROUP BY jambno ");
			$epc = mysqli_num_rows($epgc);
			
		 //Count the no of pg depositors on pg portal
		  $pgc = $pgdb->query("SELECT * FROM fees_order WHERE session = '$session' AND payment_status = 'PAID' GROUP BY admNo");
		  $ppc = mysqli_num_rows($pgc);
			
			echo $s = $epc + $ppc;
		  
		  echo '</td>';
		  
		  echo '<td>';
		  
		  //Total PG REgistration Fees amount = pg reg fee on eduerp + pg reg fee on payment system.
		  
		  $totalpgamount = $pgfee + $pgamount;

		  echo '<strong>'.number_format($totalpgamount, 2).'</strong>';
		  
		  echo '</td></tr>';
		  
		  //
		    echo '<tr><td colspan="5" align="center">';
				  
			  $genTot = $sum + $totalFee + $totalpgamount + $putmeAmt;			  
			  
			  echo '<span class="btn btn-success styleTb2"><i class="fa fa-2x fa-money"></i>&nbsp; <strong> Total Sum Generated: N'.number_format($genTot, 2).' </strong></span>';
			
			echo '</td></tr>';
		    echo '</table>';
		 }
		 else
		 {
			 '<div class="alert alert-danger"> No Available Payment Summary For this Session</div>';
		 }
	   
	   ?>
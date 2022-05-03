 <?php
 
 include_once('../include/eduerp_connect.php');
 
 $session = $_POST['session2'];
				 
	$sql = mysql_query("SELECT title, price, COUNT(jambno) AS jambno, SUM(original_amount) AS total FROM fees_order WHERE status='payment_received' AND session='$session' GROUP BY title ");
	
	if(mysql_num_rows($sql) == 0)
	{
		echo '<div class="alert alert-danger styleTb"> No payment breakdown report for this session </div>';
	}
    else
	{	
	
	$i = 1;
	echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb">';
	echo '<tr>';
	                        echo '<th><strong> S/No.</strong></th>';
							echo '<th><strong> PAYMENT TYPE </strong></th>';
							echo '<th><strong> NO. OF DEPOSITORS </strong></th>';
							echo '<th><strong> TOTAL PAID (=N=)</strong></th>';
							echo '</tr>';
	                       
						   while($f2 = mysql_fetch_array ($sql)){
							echo '<tr>';
							echo '<td >' .$i.'.</td>';
							echo '<td> <a href="paymentBreakdown.php?title='.$f2['title'].'&session='.$session.'" target="_blank" >'.$f2['title'].'</a>'. '</td>';
							echo '<td>' .$f2['jambno'] . '</td>';
							echo '<td class=style4>' .number_format($f2['total'], 2). '</td>';
							echo '</tr>';
							$i++;					
		
	}
	echo '</table>';
	
	}
	   ?>
<?php
 
echo '<table width="100%" border="0" align="center" >';
echo '<tr><td valign="top">';

require_once('../../include/connection.php');
 
 $session = $_POST['session2'];
 $status = 'PAID';
				 
	$sql = mysql_query("SELECT feeItem, SUM(amount) AS amt, COUNT(admNo) AS admNo FROM fees_order WHERE payment_status='$status' AND session='$session' GROUP BY feeItem ");
	
	if(mysql_num_rows($sql) == 0)
	{
		echo '<div class="alert alert-danger styleTb"> No payment breakdown report for this session </div>';
	}
    else
	{	
	
	$i = 1;
	echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb">';
	echo '<tr>';
	                        echo '<th colspan="4"> PG PAYMENTS - PGPORTAL </th></tr>';
	                        echo '<tr><th><strong> S/No.</strong></th>';
							echo '<th><strong> PAYMENT TYPE </strong></th>';
							echo '<th><strong> NO. OF DEPOSITORS </strong></th>';
							echo '<th><strong> TOTAL PAID (=N=)</strong></th>';
							echo '</tr>';
							
							$sum = 0;
	                       
						while($f2 = mysql_fetch_array ($sql)){
							     
								 $fee = $f2['feeItem'];
								 $admno = $f2['admNo'];
								 $amt = $f2['amt'];
											   
							echo '<tr>';
							echo '<td class=style4>' .$i.'.</td>';
							echo '<td class=style4><a href="paymentBreakdown.php?item='.$fee.'&session='.$session.'" target="_blank">'.$fee.'</a></td>';
							echo '<td class=style4 >' .$admno. '</td>';
							echo '<td class=style4>' .number_format($amt, 2). '</td>';
							echo '</tr>';
							$i++;
							
							$sum = $sum + $amt;	
				
	}
	echo '<tr><td colspan=3 align=right><b>TOTAL AMOUNT</b></td><td><b>'.number_format($sum, 2).'</b></td></tr>';
	echo '</table>';
	
	}

echo '</td><td> &nbsp; </td>';
echo '<td valign="top">';

require_once('../../include/eduerp_connect.php');
 $eduerp = mysql_query("SELECT title, SUM(price) AS price, COUNT(jambno) AS jambno FROM fees_order WHERE level_name < 100 AND status = 'payment_received' 
						AND session = '$session' AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' AND programme NOT LIKE '%Bachelor%' GROUP BY title ");	
	if(mysql_num_rows($eduerp) == 0)
	{
		echo '<div class="alert alert-danger styleTb"> No payment breakdown report for this session </div>';
	}
    else
	{	
	
	$i = 1;
	echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb">';
	echo '<tr>';	        
	                        echo '<th colspan="4"> PG PAYMENTS - EDUERP </th></tr>';
	                        echo '<th><strong> S/No.</strong></th>';
							echo '<th><strong> PAYMENT TYPE </strong></th>';
							echo '<th><strong> NO. OF DEPOSITORS </strong></th>';
							echo '<th><strong> TOTAL PAID (=N=)</strong></th>';
							echo '</tr>';
							
							$sum = 0;
	                       
						while($edu = mysql_fetch_array ($eduerp)){
							     
								 $edu_fee = $edu['title'];
								 $edu_admno = $edu['jambno'];
								 $edu_amt = $edu['price'];
					
							  							   
							echo '<tr>';
							echo '<td class=style4>' .$i.'.</td>';
							echo '<td class=style4><a href="paymentBreakdown.php?item2='.$edu_fee.'&session='.$session.'" target="_blank">'.$edu_fee.'</a></td>';
							echo '<td class=style4 >' .$edu_admno. '</td>';
							echo '<td class=style4>' .number_format($edu_amt, 2). '</td>';
							echo '</tr>';
							$i++;
							
							$sum = $sum + $edu_amt;	
				
	}
	echo '<tr><td colspan=3 align=right><b>TOTAL AMOUNT</b></td><td><b>'.number_format($sum, 2).'</b></td></tr>';
	echo '</table>';
	
	}

echo '</td></tr></table>'; 



?>
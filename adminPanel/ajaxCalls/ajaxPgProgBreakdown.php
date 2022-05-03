<?php
 
echo '<table width="100%" border="0" align="center" >';
echo '<tr><td valign="top">';

include_once('../../include/constant_connection.php');
 
 $session = $_POST['session4'];
 $status = 'PAID';
				 
	$result = $pgdb->query("SELECT programme, SUM(amount) FROM fees_order WHERE payment_status = '$status' AND session = '$session' GROUP BY programme ORDER BY programme");
	

	if(mysqli_num_rows($result) == 0)
	{
		echo '<div class="alert alert-danger styleTb"> We can\'t retrieve any payment record for this programme now</div>';
	}
    else
	{	
	   $rec = mysqli_num_rows($result);
	   //echo '<div class="btn btn-default btn-sm"> Total No of Programmes: '.$rec.'</div><br/>';
				
	$i = 1;
	echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb">';
	                        echo '<tr>';
						    
							echo '<th colspan="4"> PG PROGRAMME PAYMENTS - PGPORTAL ('.$session.') </th></tr>';
	                        echo '<th><strong> S/No.</strong></th>';
							echo '<th><strong> PROGRAMME</strong></th>';
							echo '<th><strong> NO. OF PAYERS</strong></th>';
     						echo '<th><strong> TOTAL SUM (=N=)</strong></th>';
							echo '</tr>';
	                       
						   $sum = 0;
						   
						   while($row = mysqli_fetch_array($result)){
							   
							 $prg = urlencode($row['programme']);
							 $prog = $row['programme'];
							 $prgamount = $row['SUM(amount)'];
							 
							 $con = $pgdb->query("SELECT * FROM fees_order WHERE programme = '$prog' AND payment_status = '$status' AND session = '$session' GROUP BY admNo");
							 $c = mysqli_num_rows($con);
							 
							

							echo '<tr>';
							echo '<td >' .$i.'.</td>';
					        echo '<td><a href="paymentBreakdown.php?pgprog='.$prg.'&session='.$session.'" target="_blank" >'.$prog.'</a></td>';
						    echo '<td>'.$c. '</td>';
						    echo '<td>'.number_format($prgamount, 2). '</td>';
							echo '</tr>';
							$i++;					
		
	                      $sum = $sum + $prgamount;				
		
	}
	                       echo '<tr><td colspan=3 align=right><strong>TOTAL AMOUNT</strong></td>
						        <td><b>'.number_format($sum, 2).'</b></td></tr>';
	echo '</table>';
	
	}

echo '</td><td> &nbsp; </td>';
echo '<td valign="top">';

                $eduerp = $edudb->query("SELECT programme, SUM(price) FROM ".TBL_FEES_ORDER." WHERE level_name < 100 AND status = 'payment_received' 
				AND session = '$session' AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' AND programme NOT LIKE '%Bachelor%' GROUP BY programme ORDER BY programme");
						
		if(mysqli_num_rows($eduerp) == 0)
	{
		echo '<div class="alert alert-danger styleTb"> No payment breakdown report for this session </div>';
	}
    else
	{	
	
	$i = 1;
	echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb">';
	echo '<tr>';	        
	                        echo '<th colspan="4"> PG PROGRAMME PAYMENTS - EDUERP ('.$session.')</th></tr>';
							echo '<th><strong> S/No.</strong></th>';
							echo '<th><strong> PROGRAMME</strong></th>';
							echo '<th><strong> NO. OF PAYERS</strong></th>';
							echo '<th><strong> TOTAL SUM (=N=)</strong></th>';
							echo '</tr>';
							
							$sum = 0;
	                       
						while($edu = mysqli_fetch_array($eduerp)){
							     
								 $edu_prg = $edu['programme'];
								 $edu_amt = $edu['SUM(price)'];
								 
		        $edu_con = $edudb->query("SELECT * FROM ".TBL_FEES_ORDER." WHERE level_name < 100 AND programme = '$edu_prg' AND status = 'payment_received' 
				AND session = '$session' AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' AND programme NOT LIKE '%Bachelor%' GROUP BY jambno");
				$ed = mysqli_num_rows($edu_con);
					  							   
							echo '<tr>';
							echo '<td class=style4 >' .$i.'.</td>';
							echo '<td class=style4 ><a href="paymentBreakdown.php?eduprog='.$edu_prg.'&session='.$session.'" target="_blank">'.$edu_prg.'</a></td>';
							echo '<td class=style4 >' .$ed. '</td>';
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
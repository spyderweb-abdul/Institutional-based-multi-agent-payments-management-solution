<?php
 
echo '<table width="100%" border="0" align="center" >';
echo '<tr><td valign="top">';

include_once('../../include/constant_connection.php');
 
 $session = $_POST['session3'];
 $status = 'PAID';
				 
	$result = $pgdb->query("SELECT facName, SUM(amount) FROM fees_order WHERE payment_status = '$status' AND session = '$session' GROUP BY facName");
	          
	if(mysqli_num_rows($result) == 0)
	{
		echo '<div class="alert alert-danger styleTb"> We can\'t retrieve any payment record for faculties/colleges now</div>';
	}
    else
	{	
	
	$i = 1;
	echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb">';
	echo '<tr>';
	                       	echo '<th colspan="4"> PG FACULTY PAYMENTS - PGPORTAL ('.$session.') </th></tr>';
	                        echo '<th><strong> S/No.</strong></th>';
							echo '<th><strong> FACULTY</strong></th>';
							echo '<th><strong> No. OF DEPOSITORS</strong></th>';
							echo '<th><strong> AMOUNT GENERATED (=N=)</strong></th>';
							echo '</tr>';
							
							$sum = 0;
	                       
						   while($f2 = mysqli_fetch_array($result)){
							   
							   $facName = $f2['facName'];
							   $amountGen = $f2['SUM(amount)'];
							   
							 $con = $pgdb->query("SELECT * FROM fees_order WHERE facName = '$facName' AND payment_status = '$status' AND session = '$session' GROUP BY admNo");
							 $c = mysqli_num_rows($con);

							echo '<tr>';
							echo '<td >' .$i.'.</td>';
						    echo "<td>".'<a href="paymentBreakdown.php?pgfac='.$facName.'&session='.$session.'" target="_blank" >'.$facName.'</a>' ."</td>";
							echo "<td>".$c. "</td>";
						    echo "<td>".number_format($amountGen, 2). "</td>";
							echo '</tr>';
							$i++;	
							
							$sum = $sum + $amountGen;				
		
	                     }
	                      echo '<tr><td colspan=3 align=right><strong>TOTAL AMOUNT</strong></td>
						        <td><b>'.number_format($sum, 2).'</b></td></tr>';
	echo '</table>';
	
	}

echo '</td><td> &nbsp; </td>';
echo '<td valign="top">';

 $eduerp = $edudb->query("SELECT college, SUM(price), COUNT(jambno) FROM ".TBL_FEES_ORDER." WHERE level_name < 100 AND status = 'payment_received' 
AND session = '$session' AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' AND programme NOT LIKE '%Bachelor%'  GROUP BY college");	
						
		if(mysqli_num_rows($eduerp) == 0)
	{
		echo '<div class="alert alert-danger styleTb"> We can\'t retrieve any payment record for faculties/colleges now</div>';
	}
    else
	{	
	
	$i = 1;
	echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb">';
	echo '<tr>';	        
	                        echo '<th colspan="4"> PG FACULTY PAYMENTS - EDUERP ('.$session.')</th></tr>';
							echo '<th><strong> S/No.</strong></th>';
							echo '<th><strong> FACULTY</strong></th>';
							echo '<th><strong> No. OF DEPOSITORS</strong></th>';
							echo '<th><strong> AMOUNT GENERATED (=N=)</strong></th>';
							echo '</tr>';
							
							$sum = 0;
	                       
						while($edu = mysqli_fetch_array($eduerp)){
							     
								 $edu_col = $edu['college'];
								 $edu_amt = $edu['SUM(price)'];
								 
								
 $edu_con = $edudb->query("SELECT college, SUM(price) FROM ".TBL_FEES_ORDER." WHERE level_name < 100 AND college = '$edu_col' AND status = 'payment_received' 
 AND session = '$session' AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' AND programme NOT LIKE '%Bachelor%' GROUP BY jambno");
				$ed = mysqli_num_rows($edu_con);
					
					
							  							   
							echo '<tr>';
							echo '<td class=style4 >' .$i.'.</td>';
							echo '<td class=style4 ><a href="paymentBreakdown.php?educol='.$edu_col.'&session='.$session.'" target="_blank">'.$edu_col.'</a></td>';
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
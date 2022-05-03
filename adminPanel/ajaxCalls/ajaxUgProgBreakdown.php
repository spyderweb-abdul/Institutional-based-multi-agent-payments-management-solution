 <?php
 
 include_once('../../include/constant_connection.php');
 
 $session = $_POST['session4'];
				 
	$result = $edudb->query("SELECT programme, SUM(original_amount) AS TotalAmount FROM ".TBL_FEES_ORDER." WHERE (level_name = '100' OR level_name = '200' OR level_name = '300' OR level_name = '400' 
	OR level_name = '500' OR level_name = '600' OR level_name = '700' OR level_name = '800' OR level_name = '900') AND status = 'payment_received' AND session = '$session' 
	AND programme <> 'General Fee Structure' GROUP BY programme");
	          
	if(mysqli_num_rows($result) == 0)
	{
		echo '<div class="alert alert-danger styleTb"> We can\'t retrieve any payment record for this programme now</div>';
	}
    else
	{	
	   $rec = mysqli_num_rows($result);
	   echo '<div class="btn btn-default btn-sm"> Total No of Programmes: '.$rec.'</div><br/>';
				
	$i = 1;
	echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb">';
	                        echo '<tr>';
	                        echo '<th><strong> S/No.</strong></th>';
							echo '<th><strong> PROGRAMME NAME</strong></th>';
							echo '<th><strong> NO. OF PAYERS </strong></th>';
							echo '<th><strong> AMOUNT GENERATED (=N=)</strong></th>';
							echo '</tr>';
	                       
						   
						   $sum = 0;
						   while($row = mysqli_fetch_array($result)){
							   
							 $prg = urlencode($row['programme']);
							 $prog = $row['programme'];
							 $amt = $row['TotalAmount'];
							 
						$edu_con = $edudb->query("SELECT * FROM ".TBL_FEES_ORDER." WHERE level_name >= 100 AND programme = '$prog' AND status = 'payment_received' 
				AND session = '$session' AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' GROUP BY jambno");
				$ed = mysqli_num_rows($edu_con);
					  							   
							echo '<tr>';
							echo '<td >' .$i.'.</td>';
					        echo '<td><a href="paymentBreakdown.php?prog='.$prg.'&session='.$session.'" target="_blank" >'.$prog.'</a></td>';
							echo '<td>'.$ed.'</td>';
						    echo '<td>'.number_format($amt, 2). '</td>';
							echo '</tr>';
							$i++;	
							
							$sum = $sum + $amt;				
		
	                       }
						   
						    echo '<tr>
							<td colspan=3 align="right"> <strong>TOTAL AMOUNT</strong> </td>
							<td><b>'.number_format($sum, 2).'</b></td></tr>';
	echo '</table>';
	
	}
	   ?>
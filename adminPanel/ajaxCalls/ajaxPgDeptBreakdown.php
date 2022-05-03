 <?php
 
 include_once('../../include/constant_connection.php');
 
 $session = $_POST['session5'];
 $status = 'PAID';
				 
	$result = $pgdb->query("SELECT deptName, SUM(amount) AS 'TotalAmount Generated' FROM fees_order WHERE payment_status = '$status' AND session = '$session' GROUP BY deptName");

	          
	if(mysqli_num_rows($result) == 0)
	{
		echo '<div class="alert alert-danger styleTb"> We can\'t retrieve any payment record for faculties/colleges now</div>';
	}
    else
	{	
	
	$i = 1;
	echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb">';
	echo '<tr>';
	                        echo '<th><strong> S/No.</strong></th>';
							echo '<th><strong> DEPARTMENT NAME</strong></th>';
							echo '<th><strong> AMOUNT GENERATED (=N=)</strong></th>';
							echo '</tr>';
							
							$sum = 0;
	                       
						   while($f2 = mysqli_fetch_array ($result)){
							echo '<tr>';
							echo '<td >' .$i.'.</td>';
						    echo "<td>".'<a href="paymentBreakdown.php?pgdept='.$f2['deptName'].'&session='.$session.'" target="_blank" >'.$f2['deptName'].'</a>' ."</td>";
						    echo "<td>".number_format($f2['TotalAmount Generated'], 2). "</td>";
							echo '</tr>';
							$i++;					
		
	                         $sum = $sum + $f2['TotalAmount Generated'];				
		
	                          }
	                        echo '<tr><td colspan=2 align=right><strong>TOTAL AMOUNT</strong></td>
						        <td><b>'.number_format($sum, 2).'</b></td></tr>';
	   echo '</table>';
	
	}
	   ?>
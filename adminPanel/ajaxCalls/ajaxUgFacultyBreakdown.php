 <?php
 
 include_once('../../include/constant_connection.php');
 
 $session = $_POST['session3'];

 $result = $edudb->query("SELECT college, SUM(price) AS 'TotalAmount Generated' FROM ".TBL_FEES_ORDER." WHERE level_name >= 100 AND status =   'payment_received' AND session = '$session' AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' GROUP BY college");
	          
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
							echo '<th><strong> FACULTY NAME</strong></th>';
							echo '<th><strong> NO. OF PAYERS</strong></th>';
							echo '<th><strong> AMOUN GENERATED (=N=)</strong></th>';
							echo '</tr>';
							
							$sum = 0;
	                       
						   while($f2 = mysqli_fetch_array ($result)){
							   
							   $col = $f2['college'];
							   $amt = $f2['TotalAmount Generated'];
							   
				$edu_con = $edudb->query("SELECT * FROM ".TBL_FEES_ORDER." WHERE level_name >= 100 AND college = '$col' AND status = 'payment_received' 
				AND session = '$session' AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' GROUP BY jambno");
				$ed = mysqli_num_rows($edu_con);
							   
							echo '<tr>';
							echo '<td >' .$i.'.</td>';
						    echo "<td>".'<a href="paymentBreakdown.php?fac='.$col.'&session='.$session.'" target="_blank" >'.$col.'</a>' ."</td>";
							echo '<td>'.$ed.'</td>';
						    echo "<td>".number_format($amt, 2). "</td>";
							echo '</tr>';
							$i++;
							
							$sum = $sum + $amt;

	                        }
	                           echo '<tr><td colspan=3 align=right><strong>TOTAL AMOUNT</strong></td>
							      <td><b>'.number_format($sum, 2).'</b></td></tr>';		
	                      
						  echo '</table>';
	
	                    }
	   ?>
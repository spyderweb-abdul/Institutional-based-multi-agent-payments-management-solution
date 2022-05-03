 <?php
 
 include_once('../include/eduerp_connect.php');
 
 $session = $_POST['session3'];
				 
	$result = mysql_query("SELECT college, SUM( original_amount ) AS 'TotalAmount Generated' FROM fees_order WHERE STATUS = 'payment_received' AND session = '$session' GROUP BY college");
	          
	if(mysql_num_rows($result) == 0)
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
							echo '<th><strong> AMOUN GENERATED (=N=)</strong></th>';
							echo '</tr>';
	                       
						   while($f2 = mysql_fetch_array ($result)){
							echo '<tr>';
							echo '<td >' .$i.'.</td>';
						    echo "<td>".'<a href="paymentBreakdown.php?fac='.$f2['college'].'&session='.$session.'" target="_blank" >'.$f2['college'].'</a>' ."</td>";
						    echo "<td>".number_format($f2['TotalAmount Generated'], 2). "</td>";
							echo '</tr>';
							$i++;					
		
	}
	echo '</table>';
	
	}
	   ?>
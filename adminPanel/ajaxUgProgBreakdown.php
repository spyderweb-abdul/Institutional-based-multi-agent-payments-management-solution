 <?php
 
 include_once('../include/eduerp_connect.php');
 
 $session = $_POST['session4'];
				 
	$result = mysql_query("SELECT programme, SUM(original_amount) AS TotalAmount FROM fees_order WHERE STATUS = 'payment_received' AND session = '$session' GROUP BY programme", $mydb);
	          
	if(mysql_num_rows($result) == 0)
	{
		echo '<div class="alert alert-danger styleTb"> We can\'t retrieve any payment record for this programme now</div>';
	}
    else
	{	
	   $rec = mysql_num_rows($result);
	   echo '<div class="btn btn-default btn-sm"> Total No of Programmes: '.$rec.'</div><br/>';
				
	$i = 1;
	echo '<table class="table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb">';
	                        echo '<tr>';
	                        echo '<th><strong> S/No.</strong></th>';
							echo '<th><strong> PROGRAMME NAME</strong></th>';
							echo '<th><strong> AMOUNT GENERATED (=N=)</strong></th>';
							echo '</tr>';
	                       
						   while($row = mysql_fetch_array($result)){
							   
							 $prg = urlencode($row['programme']);

							echo '<tr>';
							echo '<td >' .$i.'.</td>';
					        echo '<td><a href="paymentBreakdown.php?prog='.$prg.'&session='.$session.'" target="_blank" >'.$row['programme'].'</a></td>';
						    echo '<td>'.number_format($row['TotalAmount'], 2). '</td>';
							echo '</tr>';
							$i++;					
		
	                       }
	echo '</table>';
	
	}
	   ?>
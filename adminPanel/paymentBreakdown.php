<?php
session_start();
include_once('../include/constant_connection.php');


/*$timeout = 20 * 60;

if(isset($_SESSION['timeout']))
{
$dur = time() - (int)$_SESSION['timeout'];

if($dur > $timeout)
{
	session_destroy();
	session_start();
	header('Location: sessionLog.php');
}
}
*/
$_SESSION['timeout'] = time();

 if(isset($_GET['token']))
  {
	  $token = md5($_GET['token']);
	  $_SESSION['userID'] = $token;
  }

 if((!isset($_SESSION['userID'])) )
  {
	 header('Location: sessionLog.php');
  }

  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/udus-logo.png" />
<title>UDUS |  Integrated Payment System - UDUPay</title>

<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<script src="../pgcourselist.js" type="text/javascript"></script>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<link href="../font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">

.styleTb
{
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-weight:500;
	color:#000000;
	font-size:11px;

}
.styleTb2
{
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-weight:500;
	color:#FFFFFF;
	font-size:11px;

}

.nav-sidebar > li > a {
	color:#060;
	
}
.nav-sidebar > li > a:hover {
	color:#060;
	background-color:#F2F2F2;
 }
.nav-sidebar > li > a:focus {
	color:#FFF;
	background-color: #FC6;
}


.nav-pills> li.active > a {
	color:#FFF;
	background-color: #090;
	
}
.nav-pills > li.active> a:hover {
	color:#060;
	background-color: #F2F2F2;
	
}
.nav-pills > li.active > a:focus {
	color:#FFF;
	background-color: #FC6;
	
}
</style>
</head>

<body>
<div class="page">
  
  <table width="554" border="0" align="center" cellpadding="5" cellspacing="5">
    <tr>
      <td width="62" height="119" align="right" valign="middle"><img src="../images/udus-logo.png" width="71" height="73" /></td>
      <td width="457" align="center" valign="middle"><span class="bannerStyle">USMANU DANFODIYO UNIVERSITY SOKOTO</span>
      <span class="uduPay">Integrated Payment Systems Platform (UDUPay)</span></td>
    </tr>
  </table>
  <br/>
  <table width="1008" height="379" border="0" align="center" cellpadding="7" cellspacing="7" >
        <tr>
        <td width="815" height="365" valign="top">
             <?php   
			 
			 
			 //For Fee Item Breakdown
						
			$sql = $paydb->query("SELECT * FROM ".TBL_ADMIN." WHERE userID = '$_SESSION[userID]'");
			$chk = mysqli_fetch_array($sql);
			
			if($chk['active'] == 'YES')
			{
				include('userSessionLog.php');
				$readonly = 'readonly';	
			
			?>
        <table width="100%" border="0" align="center" cellpadding="10" cellspacing="10" class="table_bg2">
          <tr>
            <td width="100%" height="282" valign="top">
            <p class="payMode"> PAYMENT BREAKDOWN</p>
            
            <hr noshade="noshade" />
             
             <?php
			 
			 
			 //For UG Fee Items Breakdown
		    if(isset($_GET['title']))
			{	
				$title = $_REQUEST['title'];
				$session = $_REQUEST['session'];
			
				
				$tt = $edudb->query("SELECT * FROM ".TBL_FEES_ORDER." WHERE level_name >= 100 AND title = '$title' AND status = 'payment_received' AND session = '$session'
				AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' GROUP BY jambno ORDER BY course, level_name ASC");
				
				$cal = $edudb->query("SELECT SUM(price) FROM ".TBL_FEES_ORDER." WHERE title = '$title' AND status = 'payment_received' AND session = '$session'
				AND level_name >= 100 AND programme <> 'General Fee Structure' AND programme <> 'Matriculation'");
		        $info = mysqli_fetch_assoc ($cal);
				
		        $sumpaid = $info['SUM(price)'];
	
						if($tt)
						{
							$num = mysqli_num_rows($tt);
							echo "<br/>";
							
							echo '<div class="styleTb">';
							echo "All Record Breakdown for Item: ".strtoupper($title);
							echo "<br/>";
		                    echo "-------------------------------------------";
							echo "<br/>";
							echo "The total No. of Records: ". $num;
		                    echo "<br/>";
		                    echo "--------------------------------------------";
		                    echo "<br/>";
							echo "The Total Amount Paid: N". number_format($sumpaid, 2);
							echo "<br/>";
		                    echo "<br/></div>";
							
							echo '<hr noshade="noshade" />';
							
									
		$count = 1;
	echo "<table class='table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb'><tr>";
	
	$status = 'payment_received';
	echo '<tr><td colspan="10"><div style="text-align:right"><a href="excelCalls/excelUGItem.php?title='.$title.'&status='.$status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div></td></tr>';

    echo "<th >". "S/No." ."</th>";
	echo "<th >". "ADMISSION NO."."</th>";
	echo "<th >". "INVOICE NO."."</th>";
	echo "<th >". "RRR"."</th>";
	echo "<th >". "NAME OF DEPOSITORS". "</th>";
    echo "<th >". "AMOUNT PAID". "</th>";
	echo "<th >". "DEPT.". "</th>";
	echo "<th >". "LEVEL". "</th>";
	echo "<th >". "STATUS.". "</th>";
	echo "</tr>";
	

	
	while($row = mysqli_fetch_assoc($tt))
	{
		$name = strtoupper($row['fullnames']);
		$jambno = $row['jambno'];
		
		    echo "<tr>";
			echo "<td >". $count ."."."</td>";
	        echo "<td >". $row['jambno']."</td>";
			echo "<td >". $row['order_id']."</td>";
			echo "<td>".$row['email']."</td>";
	        echo "<td >". $name. "</td>";
			echo "<td  align=center>";
	
           echo number_format($row['price'], 2);
			 
			echo "</td>";
	        echo "<td  align=left>". strtoupper($row['course']). "</td>";
			echo "<td  align=left>". strtoupper($row['level_name']). "</td>";
			echo "<td  align=left>". strtoupper($row['status']). "</td>";
		echo "</tr>";
		$count++;
	}	
	
	echo "</table>";
							
						}	
							
			}
			
      //For UG Faculty Payment Breakdown


                    if(isset($_GET['fac']))
					{
					
						$college = $_REQUEST['fac'];
						$session = $_REQUEST['session'];
												
						$col = $edudb->query("SELECT * FROM ".TBL_FEES_ORDER." INNER JOIN ".TBL_ORDERS." ON ".TBL_ORDERS."order_id = ".TBL_FEES_ORDER."order_id WHERE ".TBL_FEES_ORDER."college = '$college' AND ".TBL_FEES_ORDER."status = 'payment_received' 
						AND ".TBL_FEES_ORDER."session = '$session' AND ".TBL_FEES_ORDER."level_name >= 100 AND ".TBL_FEES_ORDER."programme <> 'General Fee Structure' AND ".TBL_FEES_ORDER."programme <> 'Matriculation' 
						GROUP BY ".TBL_FEES_ORDER."order_id ORDER BY ".TBL_FEES_ORDER."level_name  ASC");
						
						$result = $edudb->query("SELECT SUM(price) AS sumtotal FROM ".TBL_FEES_ORDER." WHERE status = 'payment_received' AND college = '$college' AND session = '$session' AND level_name >= 100
						AND programme <> 'General Fee Structure' AND programme <> 'Matriculation'");
						$c = mysqli_fetch_array($result);
						
						if (mysqli_num_rows($col) == 0)
						{ 
						echo '<div class="alert alert-danger styleTb"> There\'s no payment record for this faculty yet!</div>';
						}
						else
						{
							$num = mysqli_num_rows($col);
							
							echo '<div class="styleTb">';
							echo "<br/>";
							
							echo "All records of payment made to: ".strtoupper($college);
							echo "<br/>";
		                    echo "----------------------------------------------------------------";
							echo "<br/>";
							echo "The total No. of records: ". $num;
		                    echo "<br/>";
		                    echo "----------------------------------------------------------------";
		                    echo "<br/>";
							echo "The total Amount: =N=".number_format($c['sumtotal'], 2);
		                    echo "<br/>";
		                    echo '</div>';
							
							echo '<hr noshade="noshade" />';
							
		
		$count = 1;
	echo "<table class='table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb'><tr>";
	
	$status = 'payment_received';
	echo '<tr><td colspan="10"><div style="text-align:right"><a href="excelCalls/excelUGFaculty.php?fac='.$college.'&status='.$status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div></td></tr>';

    echo "<td >". "S/No." ."</td>";
	echo "<td >". "ADMISSION NO."."</td>";
	echo "<td >". "INVOICE NO."."</td>";
	echo "<th >". "RRR"."</th>";
	echo "<td >". "NAME OF DEPOSITORS". "</td>";
	echo "<td >". "AMOUNT PAID". "</td>";
	echo "<td >". "FACULTY.". "</td>";
	echo "<td >". "DEPT.". "</td>";
	echo "<td >". "LEVEL". "</td>";
	echo "</tr>";
	
	$sum = 0;
	 	
	while($row = mysqli_fetch_assoc ($col) )
	{
		$name = strtoupper($row['fullnames']);
		$jambno = $row['jambno'];
		
		    echo "<tr>";
			echo "<td>". $count ."."."</td>";
	        echo "<td>". $row['jambno']."</td>";
			echo "<td>". $row['order_id']."</td>";
			echo "<td>".$row['email']."</td>";
	        echo "<td>". $name. "</td>";
			echo "<td align=center>";
	
           echo number_format($row['order_total'], 2);
			 
			echo "</td>";
	        echo "<td>". strtoupper($row['college']). "</td>";
			echo "<td>". strtoupper($row['course']). "</td>";
			echo "<td>". strtoupper($row['level_name']). "</td>";
		echo "</tr>";
		$count++;
		
		$sum = $sum + $row['order_total'];
	}	
	
	echo '<tr><td colspan=9 align=right> <strong>TOTAL AMOUNT</strong>: '.number_format($sum, 2).'</td></tr>';
	
	echo "</table>";
							
						}
				
					}
              
			  
			  //For UG Programmes payment breakdown
			  
			if(isset($_GET['prog']))
			{
				
			$programme = urldecode($_REQUEST['prog']);
			$session = $_REQUEST['session'];
			
			$tt = $edudb->query("SELECT * FROM ".TBL_FEES_ORDER." INNER JOIN uc_orders ON ".TBL_FEES_ORDER."order_id = uc_orders.order_id WHERE ".TBL_FEES_ORDER."programme = '$programme'  AND ".TBL_FEES_ORDER." status = 'payment_received' AND ".TBL_FEES_ORDER." session = '$session' 
			AND ".TBL_FEES_ORDER." level_name >= 100 AND ".TBL_FEES_ORDER." programme <> 'General Fee Structure' AND ".TBL_FEES_ORDER." programme <> 'Matriculation' GROUP BY ".TBL_FEES_ORDER." order_id  ASC ORDER BY ".TBL_FEES_ORDER." course, ".TBL_FEES_ORDER." level_name ASC");
				
			$cal = $edudb->query("SELECT SUM(price) FROM ".TBL_FEES_ORDER." WHERE programme = '$programme' AND status = 'payment_received' AND session = '$session' AND level_name >= 100
			AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' ");
		    $info = mysqli_fetch_assoc ($cal);

		    $sumpaid = $info['SUM(price)'];
	
						if ($tt)
						{
							$num = mysqli_num_rows($tt);
							
							echo '<div class="styleTb">';
							echo "<br/>";
							
							echo "All Record Breakdown for Programmes: ".strtoupper($programme);
							echo "<br/>";
		                    echo "---------------------------------------";
							echo "<br/>";
							echo "The total No. of Records: ". $num;
		                    echo "<br/>";
		                    echo "----------------------------------------";
		                    echo "<br/>";
					    	echo "The Amount Paid: N". number_format($sumpaid, 2);
							echo "<br/>";
		                    echo '</div>';
							
							echo '<hr noshade="noshade" />';
									
	$count = 1;
	echo "<table class='table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb'><tr>";
	
	$status = 'payment_received';
	echo '<tr><td colspan="10"><div style="text-align:right"><a href="excelCalls/excelUGProgramme.php?prog='.$programme.'&status='.$status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div></td></tr>';

    echo "<th>S/No.</th>";
	echo "<th>ADMISSION NO.</th>";
	echo "<th>INVOICE NO.</th>";
	echo "<th >RRR</th>";
	echo "<th> NAME OF DEPOSITORS </th>";
	echo "<th> AMOUNT PAID </th>";
	echo "<th> PROGRAMME.</th>";
	echo "<th> LEVEL </th>";
	echo "</tr>";
	
	 $sum = 0;
	 
	
	while($row = mysqli_fetch_assoc ($tt) )
	{
		$name = strtoupper($row['fullnames']);
		$jambno = $row['jambno'];
		
		
		    echo "<tr>";
			echo "<td>". $count ."."."</td>";
	        echo "<td>". $row['jambno']."</td>";
			echo "<td>". $row['order_id']."</td>";
			echo "<td>".$row['email']."</td>";
	        echo "<td>". $name. "</td>";
			echo "<td align=center>";
	
           echo number_format($row['order_total'], 2);
			 
			echo "</td>";
	        echo "<td align=left>". strtoupper($row['course']). "</td>";
			echo "<td align=left>". strtoupper($row['level_name'])."</td>";
		echo "</tr>";
		$count++;
		
		$sum = $sum + $row['order_total'];
		
	}	
			echo '<tr><td colspan=8 align=right> <b>TOTAL AMOUNT: </b>'.number_format($sum,2).'</td></tr>';

	
	echo "</table>";
			
			}
				
			}
			  
			  
			  //For PG Fee Items Breakdown
			  
			  if(isset($_GET['item']))
			{
				
				$feeItem = $_REQUEST['item'];
				$session = $_REQUEST['session'];
				$status = 'PAID';
				
				$tt = $pgdb->query("SELECT * FROM fees_order WHERE feeItem = '$feeItem' AND payment_status = '$status' AND session = '$session' GROUP BY admNo ORDER BY deptName, level ASC");
				
				$cal = $pgdb->query("SELECT SUM(amount), amount FROM fees_order WHERE feeItem = '$feeItem' AND payment_status = '$status' AND session = '$session'");
		
		        $info = mysqli_fetch_assoc ($cal);
		        $sumtotal = $info['amount'];
		        $sumpaid = $info['SUM(amount)'];
	
						if ($tt)
						{
							$num = mysqli_num_rows($tt);
							echo "<br/>";
							
							echo '<div class="styleTb">';
							echo "All Record Breakdown for Item: ".strtoupper($feeItem);
							echo "<br/>";
		                    echo "----------------------------------------------------------------";
							echo "<br/>";
							echo "The total No. of Records: ". $num;
		                    echo "<br/>";
		                    echo "----------------------------------------------------------------";
		                    echo "<br/>";
							echo "The Total Amount Payable: N". number_format($sumtotal, 2);
							echo "<br/>";
		                    echo "----------------------------------------------------------------";
		                    echo "<br/>";
							echo "The Total Amount Paid: N". number_format($sumpaid, 2);
							echo "<br/>";
		                    echo '</div>';
							
							echo '<hr noshade="noshade" />';
									
		    $count = 1;
	       	echo "<table class='table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb'><tr>";

	        echo '<tr><td colspan="10"><div style="text-align:right"><a href="excelCalls/excelPGItem.php?item='.$feeItem.'&status='.$status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div></td></tr>';

            echo '<th>S/No.</th>';
	        echo '<th> ADMISSION NO.</th>';
	        echo '<th> INVOICE NO. </th>';
			echo '<th >RRR</th>';
	        echo '<th> NAME OF DEPOSITORS </th>';
	        echo '<th> PAYABLE </th>';
	        echo '<th> AMOUNT PAID (=N=) </th>';
	        echo '<th> DEPT. </th>';
	        echo '<th> LEVEL </th>';
	        echo '<th> STATUS </th>';
	        echo '</tr>';
	
	
	while($row = mysqli_fetch_assoc ($tt) )
	{
		    echo '<tr>';
			echo "<td>". $count ."."."</td>";
	        echo "<td>". $row['admNo']."</td>";
			echo "<td>". $row['trans_id']."</td>";
			echo "<td>".$row['rrr']."</td>";
	        echo "<td>". str_ireplace("-","",$row['fullName']). "</td>";
			echo "<td align=center>";
	
           echo number_format($row['amount'], 2);
			 
			echo "</td>";
			echo "<td>";
	
           echo number_format($row['fee'], 2);
			 
			echo "</td>";
	        echo "<td>". strtoupper($row['deptName']). "</td>";
			echo "<td>". strtoupper($row['level']). "</td>";
			echo "<td>". strtoupper($row['payment_status']). "</td>";
		echo "</tr>";
		$count++;
	}	
	
	echo '</table>';
							
						}				
			}
          
		  
		  //For PG Faculty Payment Breakdown
		  
		    if(isset($_GET['pgfac']))
					{						
						
						$facName = $_REQUEST['pgfac'];
						$session = $_REQUEST['session'];
						$status = 'PAID';
												
						$col = $pgdb->query("SELECT * FROM fees_order INNER JOIN fees_summary ON fees_summary.admNo = fees_order.admNo WHERE fees_order.facName = '$facName' AND fees_order.payment_status = '$status' AND fees_summary.session = '$session' AND fees_order.session = '$session' GROUP BY fees_order.admNo ASC");
						
						$result = $pgdb->query("SELECT SUM(amount) FROM fees_order WHERE payment_status = 'PAID' AND facName = '$facName' AND session = '$session' GROUP BY facName");
						$c = mysqli_fetch_array($result);
						
						if (mysqli_num_rows($col) == 0)
						{ 
						echo "There's no payment record for this faculty yet!";
						}
						else
						{
							$num = mysqli_num_rows($col);
							
							echo '<div class="styleTb">';
							echo "<br/>";
							
							echo "All records of payment made to: ".strtoupper($facName);
							echo "<br/>";
		                    echo "----------------------------------------------------------------";
							echo "<br/>";
							echo "The total No. of records: ". $num;
		                    echo "<br/>";
		                    echo "----------------------------------------------------------------";
		                    echo "<br/>";
							echo "The total Amount: =N=". number_format($c['SUM(amount)'], 2);
		                    echo "<br/>";
		                    echo '</div>';
							echo '<hr noshade="noshade" />';
							
		
		$count = 1;
	   	echo "<table class='table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb'><tr>";
        echo '<tr><td colspan="10"><div style="text-align:right"><a href="excelCalls/excelPGFaculty.php?pgfac='.$facName.'&status='.$status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div></td></tr>';

       echo '<th> S/No.</th>';
	   echo '<th> ADMISSION NO.</th>';
	   echo '<th> INVOICE NO. </th>';
	   echo '<th>RRR</th>';
	   echo '<th> NAME OF DEPOSITORS </th>';
	   echo '<th> AMOUNT PAID </th>';
	   echo '<th> FACULTY </th>';
	   echo '<th> DEPT. </th>';
	   echo '<th> LEVEL </th>';
	   echo '<th> CHANNEL </th>';
	   echo '<th> TRANSACTION PERIOD </th>';
	   echo "</tr>";
	   
	   $sum = 0;
	 	
	while($row = mysqli_fetch_assoc ($col) )
	{
				
		    echo "<tr>";
			echo "<td>". $count ."."."</td>";
	        echo "<td>". $row['admNo']."</td>";
			echo "<td>". $row['trans_id']."</td>";
			echo "<td>".$row['rrr'].'</td>';
	        echo "<td>". str_ireplace("-","",$row['fullName']). "</td>";
			echo "<td align=center>";
	
           echo number_format($row['fee'], 2);
			 
			echo "</td>";
	        echo "<td>". strtoupper($row['facName']). "</td>";
			echo "<td>". strtoupper($row['deptName']). "</td>";
			echo "<td>". strtoupper($row['level']). "</td>";
			echo "<td>". $row['channel']. "</td>";
			echo "<td>". $row['dateTime']. "</td>";
		    echo "</tr>";
		    $count++;
		
		    $sum = $sum + $row['fee'];
	}	
	
		    echo '<tr><td colspan=11 align=right> <b>TOTAL AMOUNT: </b>'.number_format($sum,2).'</td></tr>';
	
	        echo "</table>";
							
						}
					
					}
					
					
					//For PG Department Payment Breakdown
					
					if(isset($_GET['pgdept']))
					{
						
						
						$deptName = $_REQUEST['pgdept'];
						$session = $_REQUEST['session'];
						$status = 'PAID';
												
						$dep = $pgdb->query("SELECT * FROM fees_order INNER JOIN fees_summary ON fees_summary.admNo = fees_order.admNo WHERE fees_order.deptName = '$deptName' AND fees_order.payment_status = '$status' AND fees_summary.session = '$session' AND fees_order.session = '$session' GROUP BY fees_order.admNo ASC");
						
						$results = $pgdb->query("SELECT SUM(amount) FROM fees_order WHERE payment_status = '$status' AND deptName = '$deptName' AND session = '$session' GROUP BY deptName");
						$d = mysqli_fetch_array($results);
						
						if(mysqli_num_rows($dep) == NULL)
						{ 
						echo "There's no payment record for this department yet!";
						}
						else
						{
							$num = mysqli_num_rows($dep);
							
							echo '<div class="styleTb">';
							
							echo "<br/>";
							echo "All records of payment made to: ".strtoupper($deptName);
							echo "<br/>";
		                    echo "----------------------------------------------------------------";
							echo "<br/>";
							echo "The total No. of records: ". $num;
		                    echo "<br/>";
		                    echo "----------------------------------------------------------------";
		                    echo "<br/>";
							echo "The total Amount: =N=". number_format($d['SUM(amount)'], 2);
		                    echo "<br/>";
		                    echo '</div>';
							
							echo '<hr noshade="noshade" />';
							
		
		$count = 1;
  	    echo "<table class='table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb'><tr>";
        echo '<tr><td colspan="9"><div style="text-align:right"><a href="excelCalls/excelPGDept.php?pgdept='.$deptName.'&status='.$status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div></td></tr>';
    
	    echo '<th> S/No. </th>';
	    echo '<th> ADMISSION NO. </th>';
	    echo '<th> INVOICE NO. </th>';
		echo '<th> RRR </th>';
	    echo '<th> NAME OF DEPOSITORS </th>';
	    echo '<th> AMOUNT PAID </th>';
	    echo '<th> DEPT. </th>';
	    echo '<th> LEVEL </th>';
	    echo '<th> CHANNEL </th>';
	    echo '<th> TRANSACTION PERIOD </th>';
	    echo '</tr>';
	 	
		$sum = 0;
	while($row = mysqli_fetch_assoc($dep))
	{
				
		    echo "<tr>";
			echo "<td>". $count ."."."</td>";
	        echo "<td>". $row['admNo']."</td>";
			echo "<td>". $row['trans_id']."</td>";
			echo "<td>". $row['rrr']."</td>";
	        echo "<td>". str_ireplace("-","",$row['fullName']). "</td>";
			echo "<td align=center>";
	
           echo number_format($row['fee'], 2);
			 
			echo "</td>";
			echo "<td>". strtoupper($row['deptName']). "</td>";
			echo "<td>". strtoupper($row['level']). "</td>";
     		echo "<td>". $row['channel']. "</td>";
			echo "<td>". $row['dateTime']. "</td>";
		    echo "</tr>";
		   
		   $count++;
		
		$sum = $sum + $row['fee'];
	}	
	     echo '<tr><td colspan=11 align=right> <b>TOTAL AMOUNT: </b>'.number_format($sum,2).'</td></tr>';
	     echo "</table>";
		
				}
						
					}
					
					
					//For PG Programme Payment Breakdown
		if(isset($_GET['pgprog']))
			{
								
			$programme = urldecode($_REQUEST['pgprog']);
			$session = $_REQUEST['session'];
			$status = 'PAID';
			
			$tt = $pgdb->query("SELECT * FROM fees_order INNER JOIN fees_summary ON fees_summary.admNo = fees_order.admNo WHERE fees_order.programme = '$programme'  AND fees_order.payment_status = '$status' AND fees_summary.session = '$session' AND fees_order.session = '$session' GROUP BY fees_summary.admNo  ASC ORDER BY deptName, level ASC");
				
				$cal = $pgdb->query("SELECT SUM(amount), fee FROM fees_order WHERE programme = '$programme' AND payment_status = 'PAID' AND session = '$session'");
		        $info = mysqli_fetch_assoc ($cal);
		        $sumtotal = $info['fee'];
		        $sumpaid = $info['SUM(amount)'];
	
						if ($tt)
						{
							$num = mysqli_num_rows($tt);
							
							echo '<div class="styleTb">';
							echo "<br/>";
							
							echo "All Record Breakdown for Programmes: ".strtoupper($programme);
							echo "<br/>";
		                    echo "----------------------------------------------------------------";
							echo "<br/>";
							echo "The total No. of Records: ". $num;
		                    echo "<br/>";
		                    echo "----------------------------------------------------------------";
		                    echo "<br/>";
							echo "Amount Payable: N". number_format($sumtotal, 2);
							echo "<br/>";
		                    echo "----------------------------------------------------------------";
		                    echo "<br/>";
							echo "The Total Amount Paid: N". number_format($sumpaid, 2);
							echo "<br/>";
		                    echo '</div>';
							
							echo '<hr noshade="noshade" />';
									
		$count = 1;
  	    echo "<table class='table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb'><tr>";
        echo '<tr><td colspan="10"><div style="text-align:right"><a href="excelCalls/excelPGProg.php?pgprog='.$programme.'&status='.$status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div></td></tr>';
    echo '<th> S/No. </th>';
	echo '<th> ADMISSION NO. </th>';
	echo '<th> INVOICE NO. </th>';
	echo '<th> RRR </th>';
	echo '<th> NAME OF DEPOSITORS </th>';
	echo '<th> PAYABLE </th>';
	echo '<th> AMOUNT PAID (=N=) </th>';
	echo '<th> PROGRAMME </th>';
	echo '<th> LEVEL </th>';
	echo '<th> STATUS </th>';
	echo '</tr>';
	
	$sum = 0;
	
	while($row = mysqli_fetch_assoc ($tt) )
	{
		$name = strtoupper($row['fullName']);
		$admNo = $row['admNo'];
		
		    echo "<tr>";
			echo "<td>". $count ."."."</td>";
	        echo "<td>". $row['admNo']."</td>";
			echo "<td>". $row['trans_id']."</td>";
			echo "<td>". $row['rrr']."</td>";
	        echo "<td>". str_ireplace("-","",$row['fullName']). "</td>";
			echo "<td>";
	
           echo number_format($row['amount'], 2);
			 
			echo "</td>";
			echo "<td>";
	
           echo number_format($row['fee'], 2);
			 
			echo "</td>";
	        echo "<td>". strtoupper($row['deptName']). "</td>";
			echo "<td>". strtoupper($row['level'])."</td>";
			echo "<td>". strtoupper($row['payment_status']). "</td>";
		    echo "</tr>";
		$count++;
		
		$sum = $sum + $row['fee'];
	  }	
	
	echo '<tr><td colspan=11 align=right> <b>TOTAL AMOUNT: </b>'.number_format($sum,2).'</td></tr>';

	echo "</table>";
							
			}
	
		}
          
		  
		  
		  
		  //For Eduerp PG Fee Items Breakdown
		    if(isset($_GET['item2']))
			{	
				
				
				$item = $_REQUEST['item2'];
				$session = $_REQUEST['session'];
				$status = 'payment_received';
			
				
				$tt = $edudb->query("SELECT * FROM ".TBL_FEES_ORDER." WHERE level_name < 100 AND title = '$item' AND status = '$status' AND session = '$session'
				AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' AND programme NOT LIKE '%Bachelor%' GROUP BY jambno ORDER BY course, level_name ASC");
				
				$cal = $edudb->query("SELECT SUM(price) FROM ".TBL_FEES_ORDER." WHERE title = '$item' AND status = '$status' AND session = '$session'
				AND level_name < 100 AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' AND programme NOT LIKE '%Bachelor%' ");
		        $info = mysql_fetch_assoc ($cal);
				
		        $sumpaid = $info['SUM(price)'];
	
						if($tt)
						{
							$num = mysqli_num_rows($tt);
							echo "<br/>";
							
							echo '<div class="styleTb">';
							echo "All Record Breakdown for Item: ".strtoupper($title);
							echo "<br/>";
		                    echo "-------------------------------------------";
							echo "<br/>";
							echo "The total No. of Records: ". $num;
		                    echo "<br/>";
		                    echo "--------------------------------------------";
		                    echo "<br/>";
							echo "The Total Amount Paid: N". number_format($sumpaid, 2);
							echo "<br/>";
		                    echo "<br/></div>";
							
							echo '<hr noshade="noshade" />';
							
									
		$count = 1;
	echo "<table class='table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb'><tr>";
	

	echo '<tr><td colspan="10"><div style="text-align:right"><a href="excelCalls/excelPGEduerpItem.php?title='.$item.'&status='.$status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div></td></tr>';

    echo "<th >". "S/No." ."</th>";
	echo "<th >". "ADMISSION NO."."</th>";
	echo "<th >". "INVOICE NO."."</th>";
	echo "<th >". "RRR"."</th>";
	echo "<th >". "NAME OF DEPOSITORS". "</th>";
	echo "<th >". "AMOUNT PAID". "</th>";
	echo "<th >". "DEPT.". "</th>";
	echo "<th >". "LEVEL". "</th>";
	echo "<th >". "STATUS.". "</th>";
	echo "</tr>";
	

	
	while($row = mysqli_fetch_assoc($tt))
	{
		$name = strtoupper($row['fullnames']);
		$jambno = $row['jambno'];
		
		    echo "<tr>";
			echo "<td >". $count ."."."</td>";
	        echo "<td >". $row['jambno']."</td>";
			echo "<td >". $row['order_id']."</td>";
			echo "<td>".$row['email']."</td>";
	        echo "<td >". $name. "</td>";
			echo "<td  align=center>";
	
           echo number_format($row['price'], 2);
			 
			echo "</td>";
	        echo "<td  align=left>". strtoupper($row['course']). "</td>";
			echo "<td  align=left>". strtoupper($row['level_name']). "</td>";
			echo "<td  align=left>". strtoupper($row['status']). "</td>";
		echo "</tr>";
		$count++;
	}	
	
	echo "</table>";		
		}	
			}
			
			
  //For PG Eduerp Faculty Payment Breakdown


                    if(isset($_GET['educol']))
					{
						
						$college = $_REQUEST['educol'];
						$session = $_REQUEST['session'];
						$status = 'payment_received';
												
						$col = $edudb->query("SELECT * FROM fees_order INNER JOIN uc_orders ON uc_orders.order_id = ".TBL_FEES_ORDER."order_id WHERE ".TBL_FEES_ORDER."college = '$college' AND ".TBL_FEES_ORDER."status = '$status' 
						AND ".TBL_FEES_ORDER."session = '$session' AND ".TBL_FEES_ORDER."level_name < 100 AND ".TBL_FEES_ORDER."programme <> 'General Fee Structure' AND ".TBL_FEES_ORDER."programme <> 'Matriculation' AND ".TBL_FEES_ORDER."programme NOT LIKE '%Bachelor%'
						GROUP BY ".TBL_FEES_ORDER."order_id ORDER BY ".TBL_FEES_ORDER."level_name  ASC");
						
						$result = $edudb->query("SELECT SUM(price) AS sumtotal FROM ".TBL_FEES_ORDER." WHERE status = '$status' AND college = '$college' AND session = '$session' AND level_name < 100
						AND programme <> 'General Fee Structure' AND programme <> 'Matriculation'");
						$c = mysqli_fetch_array($result);
						
						if (mysqli_num_rows($col) == 0)
						{ 
						echo '<div class="alert alert-danger styleTb"> There\'s no payment record for this faculty yet!</div>';
						}
						else
						{
							$num = mysqli_num_rows($col);
							
							echo '<div class="styleTb">';
							echo "<br/>";
							
							echo "All records of payment made to: ".strtoupper($college);
							echo "<br/>";
		                    echo "----------------------------------------------------------------";
							echo "<br/>";
							echo "The total No. of records: ". $num;
		                    echo "<br/>";
		                    echo "----------------------------------------------------------------";
		                    echo "<br/>";
							echo "The total Amount: =N=".number_format($c['sumtotal'], 2);
		                    echo "<br/>";
		                    echo '</div>';
							
							echo '<hr noshade="noshade" />';
							
		
		$count = 1;
	echo "<table class='table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb'><tr>";
	
	echo '<tr><td colspan="10"><div style="text-align:right"><a href="excelCalls/excelPGEduerpFaculty.php?fac='.$college.'&status='.$status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div></td></tr>';

    echo "<td >". "S/No." ."</td>";
	echo "<td >". "ADMISSION NO."."</td>";
	echo "<td >". "INVOICE NO."."</td>";
	echo "<th >". "RRR"."</th>";
	echo "<td >". "NAME OF DEPOSITORS". "</td>";
	echo "<td >". "AMOUNT PAID". "</td>";
	echo "<td >". "FACULTY.". "</td>";
	echo "<td >". "DEPT.". "</td>";
	echo "<td >". "LEVEL". "</td>";
	echo "</tr>";
	
	$sum = 0;
	 	
	while($row = mysqli_fetch_assoc ($col) )
	{
		$name = strtoupper($row['fullnames']);
		$jambno = $row['jambno'];
		
		    echo "<tr>";
			echo "<td>". $count ."."."</td>";
	        echo "<td>". $row['jambno']."</td>";
			echo "<td>". $row['order_id']."</td>";
			echo "<td>".$row['email']."</td>";
	        echo "<td>". $name. "</td>";
			echo "<td align=center>";
	
           echo number_format($row['order_total'], 2);
			 
			echo "</td>";
	        echo "<td>". strtoupper($row['college']). "</td>";
			echo "<td>". strtoupper($row['course']). "</td>";
			echo "<td>". strtoupper($row['level_name']). "</td>";
		echo "</tr>";
		$count++;
		
		$sum = $sum + $row['order_total'];
	}	
	
	echo '<tr><td colspan=9 align=right> <strong>TOTAL AMOUNT</strong>: '.number_format($sum, 2).'</td></tr>';
	
	echo "</table>";
			}
		}	
		
			  //For PG Eduerp Programmes payment breakdown
			  
			if(isset($_GET['eduprog']))
			{
				
			$programme = urldecode($_REQUEST['eduprog']);
			$session = $_REQUEST['session'];
			$status = 'payment_received';

			
			$tt = $edudb->query("SELECT * FROM ".TBL_FEES_ORDER." INNER JOIN uc_orders ON ".TBL_FEES_ORDER."order_id = uc_orders.order_id WHERE ".TBL_FEES_ORDER."programme = '$programme'  AND ".TBL_FEES_ORDER."status = '$status' AND ".TBL_FEES_ORDER."session = '$session' 
			AND ".TBL_FEES_ORDER."level_name < 100 AND ".TBL_FEES_ORDER."programme <> 'General Fee Structure' AND ".TBL_FEES_ORDER."programme <> 'Matriculation' AND ".TBL_FEES_ORDER."programme NOT LIKE '%Bachelor%'
			GROUP BY ".TBL_FEES_ORDER."order_id  ASC ORDER BY ".TBL_FEES_ORDER."course, ".TBL_FEES_ORDER."level_name ASC");
				
			$cal = $edudb->query("SELECT SUM(price) FROM ".TBL_FEES_ORDER." WHERE programme = '$programme' AND status = '$status' AND session = '$session' AND level_name < 100
			AND programme <> 'General Fee Structure' AND programme <> 'Matriculation' AND programme NOT LIKE '%Bachelor%' ");
		    $info = mysqli_fetch_assoc ($cal);

		    $sumpaid = $info['SUM(price)'];
	
						if ($tt)
						{
							$num = mysqli_num_rows($tt);
							
							echo '<div class="styleTb">';
							echo "<br/>";
							
							echo "All Record Breakdown for Programmes: ".strtoupper($programme);
							echo "<br/>";
		                    echo "---------------------------------------";
							echo "<br/>";
							echo "The total No. of Records: ". $num;
		                    echo "<br/>";
		                    echo "----------------------------------------";
		                    echo "<br/>";
					    	echo "The Amount Paid: N". number_format($sumpaid, 2);
							echo "<br/>";
		                    echo '</div>';
							
							echo '<hr noshade="noshade" />';
									
	$count = 1;
	echo "<table class='table-bordered table-condensed table-hover table-responsive table-striped img-thumbnail styleTb'><tr>";
	
	echo '<tr><td colspan="10"><div style="text-align:right"><a href="excelCalls/excelPGEduerpProgramme.php?prog='.$programme.'&status='.$status.'&sess='.$session.'"><img src="../images/Excel_15.png" /> Export to Excel </a> </div></td></tr>';

    echo "<th>S/No.</th>";
	echo "<th>ADMISSION NO.</th>";
	echo "<th>INVOICE NO.</th>";
	echo "<th >RRR</th>";
	echo "<th> NAME OF DEPOSITORS </th>";
	echo "<th> AMOUNT PAID </th>";
	echo "<th> PROGRAMME.</th>";
	echo "<th> LEVEL </th>";
	echo "</tr>";
	
	 $sum = 0;
	 
	
	while($row = mysqli_fetch_assoc ($tt) )
	{
		$name = strtoupper($row['fullnames']);
		$jambno = $row['jambno'];
		
		
		    echo "<tr>";
			echo "<td>". $count ."."."</td>";
	        echo "<td>". $row['jambno']."</td>";
			echo "<td>". $row['order_id']."</td>";
			echo "<td>".$row['email']."</td>";
	        echo "<td>". $name. "</td>";
			echo "<td align=center>";
	
           echo number_format($row['order_total'], 2);
			 
			echo "</td>";
	        echo "<td align=left>". strtoupper($row['course']). "</td>";
			echo "<td align=left>". strtoupper($row['level_name'])."</td>";
		echo "</tr>";
		$count++;
		
		$sum = $sum + $row['order_total'];
		
	}	
			echo '<tr><td colspan=8 align=right> <b>TOTAL AMOUNT: </b>'.number_format($sum,2).'</td></tr>';

	
	echo "</table>";
			
			}
				
			}				
          
          ?>
             
             
            <p>&nbsp;</p></td>
          </tr>
        </table>
        
        <?php
		}
			else
			{
				echo '<div class="btn btn-danger"> Your account is still inactive. Kindly change your password. </div>';
			}
	  ?>
        
        </td>
      </tr>
  </table>
  <br/>
</div>

<div class="clearf"></div>
<div class="footer">
Copyright &copy; <?php echo date('Y') ?> All rights reserved - UDUS <br/><br/>
Concept Designed and Developed By: UDUS WEB Team</div>
</div>

</body>
</html>
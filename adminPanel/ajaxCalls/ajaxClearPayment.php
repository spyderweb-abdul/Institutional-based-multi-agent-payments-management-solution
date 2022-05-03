<?php
include_once('../../include/constant_connection.php');

$userId = $_POST['userId'];
$category = $_POST['category'];

$mySubstr = substr($userId, 0, 2);

if(($mySubstr >= 14) && ($category == 'POSTGRADUATE'))
{
	
	$sql = $pgdb->query("SELECT * FROM fees_order AS a INNER JOIN fees_summary AS b ON b.admNo = a.admNo WHERE a.admNo = '$userId' AND b.admNo = '$userId' GROUP BY b.admNo, b.session ORDER BY b.admNo, b.session DESC");
	$num = mysqli_num_rows($sql);
	
	if($num > 0)
	{
echo '<table width="95%" border="0" cellspacing="5" cellpadding="5" class="table-bordered table-striped table-condensed table-hover styleTb img-thumbnail" >';
   echo '<tr><th> S/No. </th>';
   echo '<th> Payer ID </th>';
   echo '<th> Name of Payer </th>';
   echo '<th> Transaction ID </th>';
   echo '<th> Description </th>';
   echo '<th> Channel </th>';
   echo '<th> Session </th>';
   echo '<th> Amount Payable</th>';
   echo '<th> Status </th>';
   echo '</tr>';
   
   $i = 1;
   while ($r = $sql->fetch_array()){
   echo '<tr>';
   echo '<td>'.$i.'</td>';
   echo '<td>'.$r['admNo'].'</td>';
   echo '<td>'.$r['fullName'].'</td>';
   echo '<td>'.$r['trans_id'].'</td>';
   echo '<td>'.$r['paymentType'].'</td>';
   echo '<td>'.$r['channel'].'</td>';
   echo '<td>'.$r['session'].'</td>';
   echo '<td>'.number_format($r['amount'], 2).'</td>';
   echo '<td>'.$r['payment_status'].'</td>';
   echo '</tr>';
   
   $i++;
   
	}
	
	echo '</table>';
	}
	else
     {
	echo '<div class="alert alert-danger styleTb"> There\'s no match for either this ADMISSSION NO. Kindly try again! </div>';
     }
}
elseif(($mySubstr < 14) && ($category == 'POSTGRADUATE'))
{
	
	$sql = $edudb->query("SELECT * FROM ".TBL_FEES_ORDER." WHERE jambno = '$userId' GROUP BY jambno, session");     
    $num = mysqli_num_rows($sql);

	if($num > 0)
	{
   echo '<table width="95%" border="0" cellspacing="5" cellpadding="5" class="table-bordered table-striped table-condensed table-hover styleTb img-thumbnail" >';
   echo '<tr><th> S/No. </th>';
   echo '<th> Payer ID </th>';
   echo '<th> Name of Payer </th>';
   echo '<th> Transaction ID </th>';
   echo '<th> RRR </th>';
   echo '<th> Description </th>';
   echo '<th> Channel </th>';
   echo '<th> Session </th>';
   echo '<th> Status </th>';
   echo '<th> Amount Payable</th>';
   
   echo '</tr>';
   
   $i = 1;
   
   $sum = 0;
   while ($r = $sql->fetch_array()){
	   
	   $order_id = $r['order_id'];
	   
	   $fet = $edudb->query("SELECT order_total FROM ".TBL_ORDERS." WHERE order_id = '$order_id'");
	   $f = $fet->fetch_array();
	   
	   $price = $f['order_total'];
	   
	      echo '<tr>';
   echo '<td>'.$i.'</td>';
   echo '<td>'.$r['jambno'].'</td>';
   echo '<td>'.$r['fullnames'].'</td>';
   echo '<td>'.$r['order_id'].'</td>';
   echo '<td>'.$r['email'].'</td>';
   echo '<td> REGISTRATION FEES </td>';
   echo '<td> Bank Payment </td>';
   echo '<td>'.$r['session'].'</td>';
   echo '<td>'.$r['status'].'</td>';
   echo '<td>'.number_format($price, 2).'</td>';
   
   echo '</tr>';
   
   $i++;
   
   $sum = $sum + $price;
	}
	
	echo '<tr><td colspan=9 align=right>TOTAL AMOUNT </td>
	      <td><b>'.number_format($sum, 2).'</b></td></tr>';
	
	echo '</table>';
	}
	else
    {
	echo '<div class="alert alert-danger styleTb"> There\'s no match for either this ADMISSSION NO. Kindly try again! </div>';
    }
}
elseif(($mySubstr >= 08) && ($category == 'UNDERGRADUATE'))
{
	
	$sql = $edudb->query("SELECT * FROM ".TBL_FEES_ORDER." WHERE jambno = '$userId' GROUP BY jambno, session");     
    $num = mysqli_num_rows($sql);

	if($num > 0)
	{
   echo '<table width="95%" border="0" cellspacing="5" cellpadding="5" class="table-bordered table-striped table-condensed table-hover styleTb img-thumbnail" >';
   echo '<tr><th> S/No. </th>';
   echo '<th> Payer ID </th>';
   echo '<th> Name of Payer </th>';
   echo '<th> Transaction ID </th>';
   echo '<th> RRR </th>';
   echo '<th> Description </th>';
   echo '<th> Channel </th>';
   echo '<th> Session </th>';
   echo '<th> Status </th>';
   echo '<th> Amount Payable</th>';
   
   echo '</tr>';
   
   $i = 1;
   
   $sum = 0;
   while ($r = $sql->fetch_array()){
	   
	   $order_id = $r['order_id'];
	   
	   $fet = $edudb->query("SELECT order_total FROM ".TBL_ORDERS." WHERE order_id = '$order_id'");
	   $f = $fet->fetch_array();
	   
	   $price = $f['order_total'];
	   
	      echo '<tr>';
   echo '<td>'.$i.'</td>';
   echo '<td>'.$r['jambno'].'</td>';
   echo '<td>'.$r['fullnames'].'</td>';
   echo '<td>'.$r['order_id'].'</td>';
   echo '<td>'.$r['email'].'</td>';
   echo '<td> REGISTRATION FEES </td>';
   echo '<td> Bank Payment </td>';
   echo '<td>'.$r['session'].'</td>';
   echo '<td>'.$r['status'].'</td>';
   echo '<td>'.number_format($price, 2).'</td>';
   
   echo '</tr>';
   
   $i++;
   
   $sum = $sum + $price;
	}
	
	echo '<tr><td colspan=9 align=right>TOTAL AMOUNT </td>
	      <td><b>'.number_format($sum, 2).'</b></td></tr>';
	
	echo '</table>';
	}
	else
    {
	echo '<div class="alert alert-danger styleTb"> There\'s no match for either this ADMISSSION NO. Kindly try again! </div>';
    }
}
else
{
	echo '<div class="alert alert-danger styleTb"> NO RECORD FOUND </div>';
}


?>
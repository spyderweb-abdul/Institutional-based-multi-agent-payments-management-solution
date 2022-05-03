<?php
include_once('../include/connect.php');

$orderID = $_POST['orderID'];

$mySubstr = substr($orderID, 0, 2);
   
  if($mySubstr == '01')
    {
	   include('../include/connectMatric.php');
	   
	   $sql = mysql_query("
	   SELECT * FROM payment AS a 
	   INNER JOIN biodata AS b 
	   ON b.admNo = a.admNo 
	   WHERE a.invoiceno = '$orderID' OR a.rrr = '$orderID'");	 
	   $mt = mysql_fetch_array($sql) or die (mysql_error());	
	   
	   $name = strtoupper($mt['surname']." ".$mt['firstname']." ".$mt['middlename']);
	   $phone = $mt['phone'];
	   $email = $mt['email'];
	   $amt = $mt['amt'];
	   $rrr = $mt['rrr'];
	   $payment_status = $mt['payment_status'];
	   $descr = $mt['descr'];
	         
    }
elseif($mySubstr == '02')
{
	include('../include/connectMatric.php');
	   
	   $sql = mysql_query("
	   SELECT * FROM hostel_payment AS a 
	   INNER JOIN biodata AS b 
	   ON b.admNo = a.admNo 
	   WHERE a.invoiceno = '$orderID' OR a.rrr = '$orderID'");	 
	   $mt = mysql_fetch_array($sql) or die (mysql_error());	
	   
	   $name = strtoupper($mt['surname']." ".$mt['firstname']." ".$mt['middlename']);
	   $phone = $mt['phone'];
	   $email = $mt['email'];
	   $amt = $mt['amt'];
	   $rrr = $mt['rrr'];
	   $payment_status = $mt['payment_status'];
	   $descr = $mt['descr'];
}
elseif($mySubstr == '03')
{
	include('../include/connection.php');
	   
	   $sql = mysql_query("
	   SELECT * FROM fees_order AS a 
	   INNER JOIN fees_summary AS b 
	   ON b.admNo = a.admNo 
	   WHERE a.trans_id = '$orderID'");	 
	   $mt = mysql_fetch_array($sql) or die (mysql_error());	
	   
	   $name = strtoupper($mt['fullName']);
	   $phone = $mt['phone'];
	   $email = $mt['email'];
	   $amt = $mt['amount'];
	   $rrr = $mt['rrr'];
	   $payment_status = $mt['payment_status'];
	  // $descr = $mt['descr'];
}
elseif($mySubstr == '04' || $mySubstr == '05' || $mySubstr == '06' || $mySubstr == '07' || $mySubstr == '08' || $mySubstr == '09' || $mySubstr == '10'
       || $mySubstr == '11' || $mySubstr == '12' || $mySubstr == '13' || $mySubstr == '14' || $mySubstr == '15' || $mySubstr == '16' || $mySubstr == '17'
	   || $mySubstr == '18')
{
	include('../include/connect.php');
	   
	   $sql = mysql_query("
	   SELECT * FROM payments_record WHERE orderID = '$orderID'");	 
	   $mt = mysql_fetch_array($sql) or die (mysql_error());	
	   
	   $name = strtoupper($mt['payerName']);
	   $phone = $mt['payerPhone'];
	   $email = $mt['payerEmail'];
	   $amt = $mt['amount'];
	   $rrr = $mt['transactionID'];
	   $payment_status = $mt['payment_status'];
	   $descr = $mt['paymentType'];
}

if(mysql_num_rows($sql) == 1)
{
	
	echo '<p><strong>PAYMENT VERIFICATION FOR: '.$descr. '</strong></p>';
                 
		echo '<table width="524" border="0" cellspacing="5" cellpadding="5" class="table-bordered table-striped table-condensed table-hover styleTb" >
            <tr>
            <td width="147" height="31"><strong>Payer\'s Name:</strong></td>';
          echo '<td width="340">'. $name .'</td>
            </tr>
            <tr>
            <td height="29"><strong>RRR:</strong></td>
              <td>'. $rrr .'</td>
            </tr>
            <tr>
              <td height="32"><strong>Payer\'s Email Address:</strong></td>
              <td>'. $email .'</td>
            </tr>
            <tr>
              <td height="32"><strong>Payer\'s Phone No:</strong></td>
              <td>'. $phone. '</td>
            </tr>
            <tr>
              <td height="34"><strong>Amount Paid:</strong></td>
              <td>'. number_format($amt).'.00</td>
            </tr>
            <tr>
              <td height="29"><strong>Transaction Status:</strong></td>
              <td>'. $payment_status. '</td>
            </tr>
            <tr>
              <td height="31"><strong>Date Verified:</strong></td>
              <td>'. date('Y-M-d').'</td>
            </tr>
          </table>';
	
}
else
{
	echo '<div class="alert alert-danger styleTb"> There\'s no match for either this ORDER ID or RRR. Kindly try again </div>';
}
?>
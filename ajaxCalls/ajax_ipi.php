 <?php
include_once('../include/constant_connection.php');

$userId = $_POST['id'];

$sql = $paydb->query("SELECT * FROM ".TBL_PAYMENTS_RECORD." WHERE userId = '$userId'");
$r =    $sql->fetch_array();


	$name = strtoupper($r['payerName']);
	$phone = $r['payerPhone'];
		
	if ($r['payerEmail'] != NULL)
	{
		$email = $r['payerEmail'];
	}
	else
	{
		$email = NULL;
	}
	//$amt = '10000';
	
	$des = 'INVESTMENT PROPERTY INCOME';
	$payType = 'INVESTMENT PROPERTY INCOME';
	
	$session = '2016/2017';
	
	
	//$check = mysql_query("SELECT * FROM payments_record WHERE userId = '$userId' AND description = '$des' AND session = '$session' ", $mydb);
	//$chk = mysql_fetch_array($check);	
	
	$invoice = '20'.substr(date('Y'), -2).rand(1000, 9999).rand(3000, 8999);
	
	/*if($chk['orderID'] == NULL)
	{
		$invoice = $orderID;
	}
	else
	{
		$invoice = $chk['orderID'];
	}
	*/
	$descr = 'INVESTMENT PROPERTY INCOME - '.$invoice;
	
	/*if($chk['payment_status'] == 'PAID')
	{
	
		echo '<br/>';
	   echo '<div class="btn btn-danger"> You have already made payment for this purpose. </div>';	
	}
	else
	{
      */
echo'
<table width="273" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td>
    
        <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-user"></b></span>
        <input type="text" class="form-control styleTb" size="30" required="required" value="'.$name.'" name="name" id="name" data-toggle="tooltip" data-placement="bottom" title="CANDIDATE\'S NAME" placeholder="INSERT FULL NAME" />
        </div>
        
    
    </td>
  </tr>
  <tr>
    <td>
    
       
        <input type="hidden" class="form-control styleTb" size="30" required="required" readonly="readonly" value="'.$invoice.'" name="orderID" id="orderID" data-toggle="tooltip" data-placement="bottom" title="INVOICE NO." />
            
    
    </td>
  </tr>
  <tr>
    <td>
    
    
        <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-phone"></b></span>
        <input type="text" class="form-control styleTb" size="30" required="required" value="'.$phone.'" name="phone" id="phone" data-toggle="tooltip" data-placement="bottom" title="PAYER\'S PHONE NO" placeholder="INSERT PHONE NO" />
        </div>
        
    
    
    </td>
  </tr>
  <tr>
    <td>
         <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-envelope"></b></span>
        <input type="text" class="form-control styleTb" size="30" value="'.$email.'" name="email" id="email" data-toggle="tooltip" data-placement="bottom" title="PAYER\'S EMAIL ADDRESS" placeholder="INSERT EMAIL ADDRESS" />
        </div>

    </td>
  </tr>
  
  <tr>
    <td>
	
	<div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-usd"></b></span>
        <input type="text" class="form-control styleTb" size="30" required="required" value="" name="amount" id="amount" data-toggle="tooltip" data-placement="bottom" title="PAYABLE AMOUNT" placeholder="ENTER AMOUNT (e.g: 5000)" />
        </div>
         

    </td>
  </tr>
  
  <tr>
    <td height="23">
    
         <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-briefcase"></b></span>
        <input type="text" class="form-control styleTb" readonly="readonly" size="30" value="'.$descr.'" name="description" id="description" data-toggle="tooltip" data-placement="bottom" title="DESCRIPTION OF PAYMENT" />
        </div>
		
		   <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-shopping-cart"></b></span>
		 <select class="form-control styleTb" title="Credit Card Type" name="paymenttype" id="paymenttype" autocomplete="off">
					    <option>-- Select Payment Type --</option>
						<option value="VERVE"> Verve Card</option>
						<option value="VISA"> Visa</option>
						<option value="MASTERCARD"> MasterCard</option>
						<option value="POCKETMONI"> PocketMoni</option>
						<option value="POS"> POS</option>
						<option value="ATM"> ATM</option>
						<option value="BANK_BRANCH" selected="selected">BANK BRANCH</option>
						<option value="BANK_INTERNET">BANK INTERNET</option>
						<option value="REMITA_PAY"> Remita Account Transfer</option>
					    </select>
			</div>
        <br/>
		
				<input type="hidden" value="'.$des.'" name="des" id="des" />
				<input type="hidden" value="'.$payType.'" name="payType" id="payType" />
		        <input type="hidden" value="'.$session.'" name="session" id="session" />



          <div class="btn btn-danger"> Kindly seek assistance if this is not your record. <br/>
		   You may modify the email address if you wish.</div>
   </td>
  </tr>
  <tr>
    <td height="23">
	<br/>
    <input name="btn-pay" type="submit" value="Generate Invoice" class="btn btn-success" />
    
    </td>
  </tr>
</table>';
	//}


?>
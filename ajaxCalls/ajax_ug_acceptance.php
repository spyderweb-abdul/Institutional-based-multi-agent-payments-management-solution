 <?php
include_once('../include/constant_connection.php');

$userId = $_POST['id'];

//if(strlen($userId) == 10)
//{
$sql = $admdb->query("SELECT * FROM ".TBL_UG_ADM." WHERE jambNo = '$userId'");
$r =  $sql->fetch_array();

if(mysqli_num_rows($sql) > 0)
{
	$name = strtoupper($r['name']);
	$userId = $r['jambNo'];
	
	$invoice = '34'.rand(3333, 7777).rand(5000, 9999);
	$amt = '3000';
	$payment_status = 'PENDING';
	
	$descr = 'UG ACCEPTANCE FEE - '.$invoice;
	$des = 'UG ACCEPTANCE';
	$payType = 'UG ACCEPTANCE';
	
	$session = '2016/2017';
	
$chk = $paydb->query("SELECT * FROM ".TBL_PAYMENTS_RECORD." WHERE userId = '$userId' AND paymentType = 'UG ACCEPTANCE' AND session = '$session' ");
if(mysqli_num_rows($chk) > 0)
{
	echo '<div class="alert alert-warning"> You have genereted invoice for this payment already. <a href="http://payment.udusok.edu.ng/regenerateRRR.php"> Click here to regenerate your invoice </a> </div>';
}
else
{

echo'
<table width="273" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td>
    
        <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-user"></b></span>
        <input type="text" class="form-control styleTb" size="30" required="required" value="'.$name.'" name="name" id="name" data-toggle="tooltip" data-placement="bottom" title="CANDIDATE\'S NAME" />
        </div>
        
    
    </td>
  </tr>
  <tr>
    <td>
    
       
        <input type="hidden" class="form-control styleTb" size="30" required="required" readonly="readonly" value="'.$invoice.'" name="orderID" id="orderID" data-toggle="tooltip" data-placement="bottom" title="CANDIDATE\'S NAME" />
            
    
    </td>
  </tr>
  <tr>
    <td>
    
    
        <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-phone"></b></span>
        <input type="text" class="form-control styleTb" size="30" required="required" value="" name="phone" id="phone" placeholder="Candidate\'s Phone No." data-toggle="tooltip" data-placement="bottom" title="CANDIDATE\'S PHONE NO" />
        </div>
        
    
    
    </td>
  </tr>
  <tr>
    <td>
         <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-envelope"></b></span>
        <input type="text" class="form-control styleTb" size="30" value="payments@udusok.edu.ng" name="email" id="email" data-toggle="tooltip" data-placement="bottom" title="CANDIDATE\'S EMAIL ADDRESS" />
        </div>

    </td>
  </tr>
  
  <tr>
    <td>
         <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-briefcase"></b></span>
        <input type="text" class="form-control styleTb" readonly="readonly" size="30" value="'.$descr.'" name="description" id="description" data-toggle="tooltip" data-placement="bottom" title="DESCRIPTION OF PAYMENT" />
        </div>

    </td>
  </tr>
  
  <tr>
    <td height="23">
    
     <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-usd"></b></span>
        <input type="text" class="form-control styleTb" readonly="readonly" size="30" required="required" value="'.$amt.'" name="amount" id="amount" data-toggle="tooltip" data-placement="bottom" title="PAYABLE AMOUNT" />
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
<input type="hidden" value="'.$des.'" name="des" id="des"/>
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
}

}
else
{
	echo '<div class="alert alert-danger styleTb"> There is no match for this Jamb Number. </div>';
}

/*}
else
{
	echo '<div class="alert alert-danger styleTb"> Incomplete Jamb Number. </div>';
}*/
?>
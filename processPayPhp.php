<title>UDUS | Integrated Payment System - UDUPay</title>
<?php
include_once('include/connection.php');

$paymentID = $_POST['paymentID'];

if(strlen($paymentID) == 9)
{
$sql = mysql_query("SELECT * FROM account_table WHERE paymentID = '$paymentID'", $mydb);
$r = mysql_fetch_array($sql);

if(mysql_num_rows($sql) > 0)
{
	$name = strtoupper($r['sName']." ".$r['fName']." ".$r['oName']);

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
    
    
        <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-phone"></b></span>
        <input type="text" class="form-control styleTb" size="30" required="required" value="'.$r['phone'].'" name="phone" id="phone" data-toggle="tooltip" data-placement="bottom" title="CANDIDATE\'S PHONE NO" />
        </div>
        
    
    
    </td>
  </tr>
  <tr>
    <td>
         <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-envelope"></b></span>
        <input type="text" class="form-control styleTb" size="30" value="'.$r['email'].'" name="email" id="email" data-toggle="tooltip" data-placement="bottom" title="CANDIDATE\'S EMAIL ADDRESS" />
        </div>

    </td>
  </tr>
  <tr>
    <td height="23">
    
     <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-usd"></b></span>
        <input type="text" class="form-control styleTb" readonly="readonly" size="30" required="required" value="10000" name="amount" id="amount" data-toggle="tooltip" data-placement="bottom" title="PAYABLE AMOUNT" />
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
						<option value="BANK_BRANCH">BANK BRANCH</option>
						<option value="BANK_INTERNET">BANK INTERNET</option>
						<option value="REMITA_PAY"> Remita Account Transfer</option>
					    </select>
			</div>
        <br/>
          <div class="btn btn-danger"> Kindly seek assistance if this is not your record.</div>
   </td>
  </tr>
  <tr>
    <td height="23">
	<br/>
    <input name="btn-pay" type="submit" value="Pay Now" class="btn btn-success" />
    
    </td>
  </tr>
</table>';
}
else
{
	echo '<div class="alert alert-danger styleTb"> There is no match for this transaction ID </div>';
}

}
else
{
	echo '<div class="alert alert-danger styleTb"> Incomplete Transaction ID </div>';
}
?>
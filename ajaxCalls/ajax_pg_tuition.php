 <?php
include_once('../include/constant_connection.php');

  $ses = $pgdb->query("SELECT session FROM session_table WHERE status = 'OPEN'"); //Trying to get the current, just to be changed session
  $sess = $ses->fetch_array();
  
  $session = $sess['session'];
					   

$userId = $_POST['id'];

if((strlen($userId) == 11) || (strlen($userId) == 12))
{
$sql = $pgdb->query("SELECT * FROM fees_order AS a INNER JOIN fees_summary AS b ON b.admNo = a.admNo WHERE a.admNo = '$userId' AND a.session = '$session' AND b.session = '$session'");
$r = $sql->fetch_array();

if(mysqli_num_rows($sql) > 0)
{
	$name = strtoupper($r['fullName']);
	
	$name = str_ireplace(",","", $name); 
	$admNo = $r['admNo'];
	$phone = $r['phone'];
	$email = $r['email'];
	
	if ($r['email'] != NULL)
	{
		$email = $r['email'];
	}
	else
	{
		$email = 'pgtuition@udusok.edu.ng';
	}
	$amt = $r['amount'];
	$payment_status = $r['payment_status'];
	$invoice = $r['trans_id'];
	$descr = $r['paymentType'].' - '.$invoice;
	$session = $r['session'];
	
	$des = 'PG REGISTRATION FEE';
	$payType = 'PG REGISTRATION';
	
	
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
        <input type="text" class="form-control styleTb" size="30" required="required" value="'.$phone.'" name="phone" id="phone" data-toggle="tooltip" data-placement="bottom" title="CANDIDATE\'S PHONE NO" />
        </div>
        
    
    
    </td>
  </tr>
  <tr>
    <td>
         <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-envelope"></b></span>
        <input type="text" class="form-control styleTb" size="30" value="'.$email.'" name="email" id="email" data-toggle="tooltip" data-placement="bottom" title="CANDIDATE\'S EMAIL ADDRESS" />
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
    <input name="btn-pay" type="submit" value="Pay or Generate Invoice" class="btn btn-success styleWhite" />
    
    </td>
  </tr>
</table>';
}
else
{
	echo '<div class="alert alert-danger styleTb"> There is no match for this Admission Number. </div>';
}

}
else
{
	echo '<div class="alert alert-danger styleTb"> Incomplete Admission Number. </div>';
}
if(isset($_SESSION['id']))
{
	unset($_SESSION['id']);
}

?>
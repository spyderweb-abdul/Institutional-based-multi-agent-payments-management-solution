<html xmlns="http://www.w3.org/1999/xhtml">
<head>

</head>
<body>

<div id="verify-form">
<form name="verify" id="verify" >

  <div class="row"><div class="col-md-6"> 
    <label class="pay-detail-form-label"> Select Merchant: </label>
        <div class="input-group">
           <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
             <select name="merchantId" id="merchantId" class="form-control pay-detail-form" >
               <option value="">-</option>
                 <?php    
                  $merchant_id = $paydb->query("SELECT DISTINCT merchantId, merchant_name FROM ".MERCHANTS);
                    while($merchantList = $merchant_id->fetch_array())
                                {
                                 echo '<option value="'.$merchantList[0].'">'.$merchantList[1].'</option>';
                                }
            ?>
       </select>
      </div></div></div><br/>


     <div class="row">
		<div class="col-md-6">
            <label class="pay-detail-form-label"> Insert Your User ID: </label>
          	<div class="input-group">
            	<span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                <input class="form-control pay-detail-form" name="userId" id="userId" placeholder="User ID" onKeyUp="get_payer_institution_ver()" >
            </div>
         </div>
     </div>
     <br/>
   <p id="merchant_pay_options_ver"> </p>
   
   <p id="merchant_pay_session_ver"> </p>
   
   <p id="merchant_pay_gateway_ver"> </p>
   
   <p id="merchant_pay_invoice_ver"> </p>
   
   <p id="paymentOption"> </p>
</form>
</div><!-- Reprocess-form close -->

      <p id="verify-spinner"> </p>
      <p id="verify-result"> </p>
   
   


</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/udus-logo.png" />
<title>UDUS |  Integrated Payment System - UDUPay</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">

.styleTb
{
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-weight:500;
	color:#000000;
	font-size:11px;

}

</style>
</head>

<body>
<div class="page">
  
  <table width="554" border="0" align="center" cellpadding="5" cellspacing="5">
    <tr>
      <td width="62" height="119" align="right" valign="middle"><img src="images/udus-logo.png" width="71" height="73" /></td>
      <td width="457" align="center" valign="middle"><span class="bannerStyle">USMANU DANFODIYO UNIVERSITY SOKOTO</span>
      <span class="uduPay">Integrated Payment Systems Platform (UDUPay)</span></td>
    </tr>
  </table>
  <br/>
  <table width="902" height="2051" border="0" align="center" cellpadding="7" cellspacing="7" >
        <tr>
        <td width="862" height="2025">
        <a href="index.php"> <span class="alert-link" style="text-align:left"> >>Back to Home </span></a><br/>
        
        <p class="bold_text"><u>GUIDELINES ON HOW TO MAKE PAYMENT ON THIS PLATFORM</u></p>
          <br/>
          
          <span class="notes">STEP 1: </span> Choose the appropriate 'Payment Option' and 'Payment Type' from the drop down. <br/><br/>
          <p style="text-align:center"> <img src="images/img_home.png" width="598" height="176" class="img-thumbnail" /></p><br/>
          <span class="notes">STEP 2: </span> Insert your <strong>Admission No./Invoice No./Transaction ID</strong>, as the case may be, in the blank field. <br/><br/>
          <p style="text-align:center"><img src="images/img_inv.png" width="407" height="127" class="img-thumbnail" /></p>
          <p>&nbsp;</p>
          <p><span class="notes">STEP 3:</span> On insertion of your Admission No./Invoice No./Transaction ID, or as the case may be, notice the displayed records. Check to make sure the information displayed is yours, otherwise, seek for technical assistance. However, in some cases, this information may not be automatically displayed, in such a case, you shal be required to fill out the blank spaces. Note Also, your '<strong>Invoice No</strong>' in the displayed information, you may be needing it to verify your payment.</p>
          <p style="text-align:center"><img src="images/img_call.png" width="342" height="375" class="img-thumbnail" /></p>
          <p style="text-align:center">&nbsp;</p>          
          <p><span class="notes">STEP 4:</span> On click on '<strong>Generate Invoice</strong>', the platform will be redirected to the Remita Payment Gateway platform. Kindly <strong>print</strong> your payment invoice from the displayed page as shown in the image below and proceed to any bank of your choice to make the necessary payment. However, you can also choose from any of the numerous payment channels provided on the platform to make your online payment. </p>
          <p style="text-align:center"><img src="images/img_rrr.png" width="513" height="354" class="img-thumbnail" /></p>
          <p>See sample receipt below:</p>
          <p style="text-align:center"><img src="images/img_receipt.png" width="517" height="325" class="img-thumbnail" /></p><br/>
          <p><span class="notes">STEP 5:</span> Upon posting of your payment at the bank, you will receive a text message confirming the receipt of your payment. You may then logon to the portal to print your <strong>UDUS Payment Receipt</strong> by verifying the same payment on our portal. Note that, you will be required to verify your payment with the <strong>INVOICE NO</strong> as specified below:</p>
          <p style="text-align:center"><img src="images/img_ver.png" width="1004" height="187" class="img-thumbnail" /></p><br/>
          <p><span class="notes">STEP 6:</span> Print your UDUS Payment Receipt and also proceed with your registration or documentation as the case may require.</p>
          <p style="text-align:center"><img src="images/img_udu_rec.png" width="529" height="361" class="img-thumbnail" /></p>
          
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

<script src="js/jquery-1.8.2.js" type="text/javascript"> </script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
 $("#verify_pay").click(function(){
		   $(".feedback").html('<img src="images/fancybox_loading.gif" /> Please Wait...');
		dataString = $("#form1").serialize();	
		$.ajax({
    				type: "POST",
					url: "ajaxCalls/paymentConfirmationPage.php",
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$(".feedback").empty();
						$(".feedback").html(msg);		
					},
					error: function()
					{
						alert("failure");
					}
      		});
	});
</script>
</body>
</html>
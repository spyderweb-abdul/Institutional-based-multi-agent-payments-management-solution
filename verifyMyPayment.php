<?php
$confirm = 0;
if(isset($_GET['jambno']))
{

 include_once('include/constant_connection.php');

	$userId = $_GET['jambno'];
	
	$sql = $paydb->query("SELECT orderID, paymentType FROM ".TBL_PAYMENTS_RECORD." WHERE userId = '$userId' AND (paymentType = 'UG ACCEPTANCE' OR paymentType = 'SCREENING FEES') ");
	$num = mysqli_num_rows($sql);
	if($num == 1)
	{
		$fetch = $sql->fetch_array();
		$paymentType = $fetch[1];
		
		if($paymentType == 'SCREENING FEES')	{ 
		echo 'You have not generated your ACCEPTANCE FEE payment invoice. Kindly generate and make payment before verification. <a href="http://admissions.udusok.edu.ng/verifyPayment.php"> Back to previous </a>';
		 exit();
		 }
		else {
	     echo 'You have not generated your SCREENING FEE payment invoice. Kindly generate and make payment before verification. <a href="http://admissions.udusok.edu.ng/verifyPayment.php"> Back to previous </a>'; 
		exit(); 
		}
	}
	else if($num == 2)
	{
		$i = 0;
		$arr = array(0, 0);
		while($fetch = $sql->fetch_array())
		{
			$arr[$i] = $fetch[0];
		    $i++;
		}
		
		$confirm = 1;
	}
	else
	{
		echo 'A problem occured while trying to confirm your Jamb No. Kindly generate payment invoice or visit MIS for assistance. <a href="http://admissions.udusok.edu.ng/verifyPayment.php"> Back to previous </a>';
		exit();
	}
}
	
?>
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
      <td width="62" height="69" align="right"><img src="images/udus-logo.png" width="71" height="73" /></td>
      <td width="457" align="center" valign="bottom"><span class="bannerStyle">USMANU DANFODIYO UNIVERSITY SOKOTO</span>
      <span class="uduPay">Integrated Payment Systems Platform (UDUPay)</span></td>
    </tr>
  </table>
  <br/>
  <table width="791" height="393" border="0" align="center" class="table_bg" style="background:url(images/payBackground.png)" >
        <tr>
        <td width="785" height="389">
        
            <table width="532" height="234" border="1" align="center" cellpadding="5" cellspacing="5" class="table_bg2">
              <tr>
                <td width="502" height="212" align="center"><p>
                <a href="index.php"> <div class="alert alert-link styleTb" style="text-align:left">&gt;&gt; Back to home </div></a>

<div class="uduPay" > Verify Your Payment </div><br/>
<p class="feedback"> </p>
<div id="response"> </div>
<form action="" method="" name="form1" id="form1"> 
<table width="273" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td width="253">
    
        <?php
		if($confirm == 1)//For Undergraduate Screening and Acceptance Payment
		{
	    ?>
        <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-briefcase"></b></span>
        <input type="text" class="form-control styleTb" size="30" value="<?php echo $arr[0]; ?>" readonly="readonly" placeholder="INSERT YOUR INVOICE NO" name="orderID1" id="orderID" data-toggle="tooltip" data-placement="bottom" title="CANDIDATE'S INVOICE NO" />
        </div><br/>
        <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-briefcase"></b></span>
        <input type="text" class="form-control styleTb" size="30" value="<?php echo $arr[1]; ?>" readonly="readonly" placeholder="INSERT YOUR INVOICE NO" name="orderID2" id="orderID" data-toggle="tooltip" data-placement="bottom" title="CANDIDATE'S INVOICE NO" />
        </div><br/>        
        <input type="button" name="verify_pay2" id="verify_pay2" value="Verify Now" class="btn-success"  />

        <?php }
		else //For all other payments
		{
	    ?>
        <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-briefcase"></b></span>
        <input type="text" class="form-control styleTb" size="30" <?php if(isset($_GET['orderID'])){ $orderID = $_GET['orderID']; echo 'value='.$orderID;}  ?> required="required" placeholder="INSERT YOUR INVOICE NO" name="orderID" id="orderID" data-toggle="tooltip" data-placement="bottom" title="CANDIDATE'S INVOICE NO" />
        </div><br/>
        
            <input type="button" name="verify_pay" id="verify_pay" value="Verify Now" class="btn-success"  />

        <?php } ?>
        
    </td>
  </tr>
</table>
 </form>
                
                
                </p>

        
                </td>
              </tr>
            </table>
          
       </td>
      </tr>
  </table>
  <br/>
  <table width="662" border="0" align="center" cellpadding="5" cellspacing="5">
    <tr>
      <td width="609" height="96" align="center"><img src="images/remita-payment-logo-horizonal.png" width="500" height="96" /></td>
    </tr>
  </table>
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
	 
	 if($("#orderID").val() != ""){
		   $(".feedback").html('<img src="images/fancybox_loading.gif" /> Please Wait...');  
		   
		dataString = $("#form1").serialize();	
		$.ajax({
    				type: 'POST',
					url: 'ajaxCalls/paymentConfirmationPage.php',
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
			
	 }
	 else
	 {
		 $(".feedback").empty();
		 $("#response").html("*Empty Submission. Please fill the blank field.")
	 }
	});
	
	
	$("#verify_pay2").click(function(){
	 
		   $(".feedback").html('<img src="images/fancybox_loading.gif" /> Please Wait...');  
		   
		dataString = $("#form1").serialize();	
		$.ajax({
    				type: 'POST',
					url: 'ajaxCalls/paymentConfirmationPage2.php',
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
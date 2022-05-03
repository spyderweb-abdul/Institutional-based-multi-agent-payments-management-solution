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

<div class="uduPay" > Regenerate Your Payment Invoice</div><br/>
<p class="feedback"> </p>
<div id="response"> </div>
 
<table width="273" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td width="253">
        <form name="form1" id="form1" action="" method="">
         <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-shopping-cart"></b></span>
		 <select class="form-control styleTb" title="Credit Card Type" name="paymenttype" id="paymenttype" autocomplete="off">
					    <option>-- Select Payment Type --</option>
                        <?php
						   include_once ('include/constant_connection.php');
						   
						  					   					   
						   $sql = $paydb->query("SELECT paymentType FROM ".TBL_PAYMENTS_RECORD." GROUP BY paymentType ASC");
						 
						    while($ft = $sql->fetch_array())
							{
								echo '<option value="'.$ft['paymentType'].'">'.$ft['paymentType'].'</option>';
							}
						?>
						
					    </select>
			</div>
            
         <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-calendar"></b></span>
		 <select class="form-control styleTb" title="Session" name="session" id="session">
					    <option>-- Select Session --</option>
                        <?php
						 					   
						   $sql = $paydb->query("SELECT session FROM ".TBL_PAYMENTS_RECORD." GROUP BY session ASC");
						 
						    while($ft = $sql->fetch_array())
							{
								echo '<option value="'.$ft['session'].'">'.$ft['session'].'</option>';
							}
						?>
						
					    </select>
			</div>

           
        <div class="input-group">
        <span class="input-group-addon styleTb"><b class="glyphicon glyphicon-briefcase"></b></span>
        <input type="text" class="form-control styleTb" size="30" required="required" placeholder="INSERT ADMISSION/MATRIC/JAMB NO." name="id" id="id" data-toggle="tooltip" data-placement="bottom" title="PAYER'S ID" onkeyup="autoPop();" />
        </div>
         <br/>
        </form>
        
        
        <form name="form2" id="form2">
        <div id="invoice"></div>
      <input type="button" name="gen_rrr" id="gen_rrr" value="Generate RRR Now" class="btn btn-success" />
      </form>

    </td>
  </tr>
</table>
                
                
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
//For Matriculations Tuition
function autoPop()
{
dataString = $("#form1").serialize();
$.ajax({
	type:'POST',
	url:'ajaxCalls/fetchInvoice.php',
	data: dataString,
	success: function(data)
	{		
		$("#invoice").html(data);
	},
	
	});
}


$("#gen_rrr").click(function(){
		
		   $(".feedback").html('<img src="images/fancybox_loading.gif" /> Please Wait...'); 
		   
		dataString = $("#form2").serialize();	
		$.ajax({
    				type: 'POST',
					url: 'ajaxCalls/findMyRRR.php',
					data: dataString,
					dataType: 'html',
        			success: function(msg)
					{
						$("#form1").empty();
						$("#response").empty();
						$(".feedback").empty();
						$(".feedback").html(msg);		
					},
					error: function()
					{
						$("#response").empty();
						alert("failure");
					}
      		});
	});

 
</script>
</body>
</html>